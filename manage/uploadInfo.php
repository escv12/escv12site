<?php
require('./dbConnect.php');

// POST로 전송된 입력값 받아오기
$home_name = isset($_POST['home_name']) ? $_POST['home_name'] : '';
$company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
$company_reg_num = isset($_POST['company_reg_num']) ? $_POST['company_reg_num'] : '';
$ceo_name = isset($_POST['ceo_name']) ? $_POST['ceo_name'] : '';
$company_mail = isset($_POST['company_mail']) ? $_POST['company_mail'] : '';
$com_type = isset($_POST['com_type']) ? $_POST['com_type'] : '';
$com_item = isset($_POST['com_item']) ? $_POST['com_item'] : '';
$company_call = isset($_POST['company_call']) ? $_POST['company_call'] : '';
$company_fax = isset($_POST['company_fax']) ? $_POST['company_fax'] : '';
$postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';
$com_address = isset($_POST['com_address']) ? $_POST['com_address'] : '';
$extraAddress = isset($_POST['extraAddress']) ? $_POST['extraAddress'] : '';
$support_call = isset($_POST['support_call']) ? $_POST['support_call'] : '';
$support_mail = isset($_POST['support_mail']) ? $_POST['support_mail'] : '';
$support_time = isset($_POST['support_time']) ? $_POST['support_time'] : '';
$manager_name = isset($_POST['manager_name']) ? $_POST['manager_name'] : '';
$manager_call = isset($_POST['manager_call']) ? $_POST['manager_call'] : '';

// 입력값 검증
if (!isset($_POST['home_name']) || !is_string($_POST['home_name']) || trim($_POST['home_name']) === '') {
    die("홈페이지명을 입력해주세요.");
}
if (!isset($_POST['ceo_name']) || !is_string($_POST['ceo_name']) || trim($_POST['ceo_name']) === '') {
    die("대표자명을 입력해주세요.");
}
if (!isset($_POST['company_name']) || !is_string($_POST['company_name']) || trim($_POST['company_name']) === '') {
    die("회사명을 입력해주세요.");
}
if (!isset($_POST['company_reg_num']) || !is_string($_POST['company_reg_num']) || trim($_POST['company_reg_num']) === '') {
    die("사업자 번호을 입력해주세요.");
}
if (!isset($_POST['company_mail']) || !is_string($_POST['company_mail']) || trim($_POST['company_mail']) === '') {
    die("이메일을 입력해주세요.");
}
if (!isset($_POST['com_type']) || !is_string($_POST['com_type']) || trim($_POST['com_type']) === '') {
    die("업태를 입력해주세요.");
}
if (!isset($_POST['com_item']) || !is_string($_POST['com_item']) || trim($_POST['com_item']) === '') {
    die("종목을 입력해주세요.");
}
if (!isset($_POST['company_call']) || !is_string($_POST['company_call']) || trim($_POST['company_call']) === '') {
    die("대표번호를 입력해주세요.");
}
if (!isset($_POST['postcode']) || !is_string($_POST['postcode']) || trim($_POST['postcode']) === '') {
    die("우편번호를 입력해주세요.");
}
if (!isset($_POST['com_address']) || !is_string($_POST['com_address']) || trim($_POST['com_address']) === '') {
    die("주소를 입력해주세요.");
}
if (!isset($_POST['manager_name']) || !is_string($_POST['manager_name']) || trim($_POST['manager_name']) === '') {
    die("책임자 이름을 입력해주세요.");
}
if (!isset($_POST['manager_call']) || !is_string($_POST['manager_call']) || trim($_POST['manager_call']) === '') {
    die("책임자 번호를 입력해주세요.");
}

// SQL 쿼리 준비
$query = "UPDATE home_info SET home_name = :home_name, company_name = :company_name, company_reg_num = :company_reg_num,
ceo_name = :ceo_name, company_mail = :company_mail, com_type = :com_type, com_item = :com_item, 
company_call = :company_call, company_fax = :company_fax, postcode = :postcode, com_address = :com_address, 
extraAddress = :extraAddress, support_call = :support_call, support_mail = :support_mail, support_time = :support_time,
manager_name = :manager_name, manager_call = :manager_call
WHERE id = 1";

$stmt = $pdo->prepare($query);

// 데이터를 바인딩합니다.
$stmt->bindValue(':home_name', $home_name);
$stmt->bindValue(':company_name', $company_name);
$stmt->bindValue(':company_reg_num', $company_reg_num);
$stmt->bindValue(':ceo_name', $ceo_name);
$stmt->bindValue(':company_mail', $company_mail);
$stmt->bindValue(':com_type', $com_type);
$stmt->bindValue(':com_item', $com_item);
$stmt->bindValue(':company_call', $company_call);
$stmt->bindValue(':postcode', $postcode);
$stmt->bindValue(':com_address', $com_address);
$stmt->bindValue(':support_call', $support_call);
$stmt->bindValue(':manager_name', $manager_name);
$stmt->bindValue(':manager_call', $manager_call);

// company_fax, support_time, support_mail, extraAddress 값을 NULL 또는 입력받은 값으로 바인딩합니다.
$stmt->bindValue(':company_fax', empty($company_fax) ? null : $company_fax, PDO::PARAM_STR);
$stmt->bindValue(':support_time', empty($support_time) ? null : $support_time, PDO::PARAM_STR);
$stmt->bindValue(':support_mail', empty($support_mail) ? null : $support_mail, PDO::PARAM_STR);
$stmt->bindValue(':extraAddress', empty($extraAddress) ? null : $extraAddress, PDO::PARAM_STR);

// 쿼리 실행
try {
    if (!$stmt->execute()) {
        error_log("데이터베이스 저장 실패");
        $error = $stmt->errorInfo();
        header("Location: dashboard.php");
        exit();
    }
} catch (Exception $e) {
    echo "오류가 발생했습니다. 자세한 내용은 로그를 확인하세요. " . $e->getMessage();
    error_log($e->getMessage());
    header("Location: dashboard.php");
    exit();
}

$max_file_size = 100 * 1024; // 100KB
$allowed_mime_types = array("image/vnd.microsoft.icon");
// 문서 루트 바깥에 위치한 디렉터리 경로 설정
$upload_dir = "../favicon";

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    try {
        // 파일 업로드 크기 제한
        if ($_FILES['file']['size'] > $max_file_size) {
            throw new Exception("파일 크기가 너무 큽니다.");
        }

        // 허용되는 MIME 타입 확인
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);
        if (!in_array($mime_type, $allowed_mime_types)) {
            throw new Exception("허용되지 않은 파일 형식입니다.");
        }

        // 파일 형식 확인
        $img_info = @getimagesize($_FILES['file']['tmp_name']);
        if (!$img_info || $img_info[2] !== IMAGETYPE_ICO) {
            throw new Exception("유효하지 않은 이미지 형식입니다.");
        }

        // 파일 이름 중복 방지를 위해 파일 이름을 무작위로 생성
        try {
            $new_name = $upload_dir . bin2hex(random_bytes(8)) . ".ico";
        } catch (Exception $e) {
            throw new Exception("보안 랜덤 바이트 생성에 실패했습니다.");
        }

        // 기존 파일 삭제
        if (file_exists($upload_path)) {
            unlink($upload_path);
        }

        // 파일 경로 검사하여 경로 조작 방지
        if (!is_dir($upload_dir) || strpos(realpath($new_name), realpath($upload_dir)) !== 0) {
            throw new Exception("잘못된 파일 경로입니다.");
        }

        // 파일을 업로드 디렉터리로 이동
        if (move_uploaded_file($_FILES['file']['tmp_name'], $new_name)) {
            chmod($new_name, 0600); // 적절한 권한 설정
            header("Location: dashboard.php");
            exit();
        } else {
            throw new Exception("파일 이동 실패");
        }
    } catch (Exception $e) {
        error_log("파일 업로드 실패");
        header("Location: dashboard.php");
        exit();
    }
}

header("Location: dashboard.php");
?>