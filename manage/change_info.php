<?php

require('./dbConnect.php');

$stmt = $pdo->query("SELECT * FROM admin WHERE id = 1");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// 변수에 저장
$user_id = $row['user_id'];
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/change_info.css">
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/x-icon">
    <title>은성 관리자</title>
</head>

<body>
    <?php
    $error = "";
    if (isset($_GET["error"])) {
        if ($_GET["error"] == 1) {
            $error = "서버와의 연결을 확인해주세요";
        } else if ($_GET["success"] == 1) {
            $error = "변경 되었습니다";
        }
    }
    ?>

    <script type="text/javascript" src="../js/modal.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let warning = document.getElementById("warning");
            warning.textContent = "<?php echo htmlspecialchars($error, ENT_QUOTES); ?>";
        });

        function save_click() {
            /* 아이디 패스워드 검사 정규식 a~z A~Z 특수문자 숫자 */
            const re = /^[a-zA-Z0-9!@#$%^&*()_+\-=]{1,20}$/;
            const form = document.getElementById("change-form");

            const password = document.getElementById("password").value;
            const password_confirm = document.getElementById("password_confirm").value;


            if (!re.test(password)) {
                document.getElementById("warning").textContent = "비밀번호를 입력해주세요";
                return;
            }

            if (!(password === password_confirm)) {
                document.getElementById("warning").textContent = "비밀번호가 서로 다릅니다";
                return;
            }

            form.submit();
        }  
    </script>

    <div class="wrapper">
        <?php require("./left_menus.php") ?>

        <div class="right_wrap">
            <div class="title">계정설정</div>

            <form class="change-form" id="change-form" action="./change_account.php" method="post"
                onsubmit="return false">
                <div class="input_form">
                    <span>아이디 변경</span>
                    <div class="login_box">
                        <input id="username" name="username" type="text" placeholder="아이디" maxlength="20" value="<?php echo htmlspecialchars($user_id); ?>">
                    </div>
                </div>

                <div class="input_form">
                    <span>비밀번호 변경</span>
                    <div class="login_box">
                        <input id="password" name="password" type="password" placeholder="비밀번호" autocomplete="off" maxlength="20">
                    </div>
                </div>

                <div class="input_form">
                    <span>비밀번호 확인</span>
                    <div class="login_box">
                        <input id="password_confirm" type="password" placeholder="비밀번호 확인" autocomplete="off"
                            maxlength="20">
                    </div>
                </div>

                <div class="input_form">
                    <span>탈퇴</span>
                    <button class="delete" type="button" onclick="showConfirmModal()">탈퇴하기</button>
                </div>

                <p id="warning"></p>

                <input class="save" type="button" onclick="save_click()" value="변경사항 저장">

                <div id="confirm-modal" class="modal">
                    <div class="modal-content">
                        <p>탈퇴하실경우 관리자 페이지에 접속 할 수 없게 될 수도 있습니다.
                            <br><br>
                            탈퇴하시겠습니까?
                        </p>
                        <div class="modal-buttons">
                            <button id="cancel-btn" class="cancel-btn">아니요, 괜찮습니다</button>
                            <button id="confirm-btn" class="confirm-btn" type="button">네, 탈퇴합니다</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>