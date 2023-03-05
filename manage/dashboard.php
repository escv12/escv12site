<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/dashboard.css">
  <title>은성 관리자</title>
</head>

<body>
  <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
  <div class="wrapper">
    <?php require("./left_menus.php") ?>

    <div class="right_wrap">
      <div class="title">기본 설정 - *표시는 필수 정보입니다</div>
      <form action="" method="post" enctype="multipart/form-data">

        <h2>홈페이지 기본 정보</h2>
        <table class="info_table">
          <tr>
            <th>홈페이지명 *</th>
            <td><input type="text"></td>
          </tr>
          <tr>
            <th>파비콘</th>
            <td><input class="file_input" type="file" name="file" accept=".ico">
              <div class="des">.ico 파일만 업로드 가능합니다</div>
            </td>
          </tr>
          <tr>
            <th>도메인</th>
            <td>https:// <input class="readonly_input" type="text" value="escv12.com" readonly>
              <div class="des">도메인 변경을 원하시면 관리자에게 문의해주세요</div>
            </td>
          </tr>
        </table>


        <h2>회사 정보</h2>
        <table class="info_table">
          <tr>
            <th>상호 *</th>
            <td><input type="text"></td>
            <th>사업자등록번호 *</th>
            <td><input type="text"></td>
          </tr>
          <tr>
            <th>대표자 *</th>
            <td><input type="text"></td>
            <th>이메일 *</th>
            <td><input type="text"></td>
          </tr>
          <tr>
            <th>업태 *</th>
            <td><input type="text"></td>
            <th>종목 *</th>
            <td><input type="text"></td>
          </tr>

          <tr>
            <th>대표전화 *</th>
            <td><input type="text"></td>
            <th>팩스번호</th>
            <td><input type="text"></td>
          </tr>
          <tr>
            <th>주소 *</th>
            <td colspan="3">
              <input type="text" id="postcode" placeholder="우편번호">
              <br><br>
              <input type="text" id="address" placeholder="주소">
              <input type="text" id="extraAddress" placeholder="상세 주소">
              <br><br>
              <button type="button" id="searchAddress" onclick="searchAddress()">주소 찾기</button>
            </td>
          </tr>
        </table>


        <h2>고객센터 정보</h2>
        <table class="info_table">
          <tr>
            <th>전화번호 *</th>
            <td><input type="text"></td>
            <th>이메일</th>
            <td><input type="text"></td>
          </tr>
          <tr>
            <th>운영시간</th>
            <td colspan="3"><textarea type="text"></textarea></td>
          </tr>
          <tr>
            <th>책임자 성명 *</th>
            <td><input type="text"></td>
            <th>책임자 연락처 *</th>
            <td><input type="text"></td>
          </tr>
        </table>

        <button class="save_btn">저장하기</button>
      </form>
    </div>
  </div>

  <script>
    function searchAddress() {
      new daum.Postcode({
        oncomplete: function (data) {
          // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

          // 각 주소의 노출 규칙에 따라 주소를 조합한다.
          // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
          var addr = ''; // 주소 변수
          var extraAddr = ''; // 참고항목 변수

          //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
          if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
            addr = data.roadAddress;
          } else { // 사용자가 지번 주소를 선택했을 경우(J)
            addr = data.jibunAddress;
          }

          // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
          if (data.userSelectedType === 'R') {
            // 법정동명이 있을 경우 추가한다. (법정리는 제외)
            // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
            if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
              extraAddr += data.bname;
            }
            // 건물명이 있고, 공동주택일 경우 추가한다.
            if (data.buildingName !== '' && data.apartment === 'Y') {
              extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
            }
            // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
            if (extraAddr !== '') {
              extraAddr = ' (' + extraAddr + ')';
            }
            // 조합된 참고항목을 해당 필드에 넣는다.
            document.getElementById("extraAddress").value = extraAddr;

          } else {
            document.getElementById("extraAddress").value = '';
          }

          // 우편번호와 주소 정보를 해당 필드에 넣는다.
          document.getElementById('postcode').value = data.zonecode;
          document.getElementById("address").value = addr;
        }
      }).open();
    }
  </script>
</body>

</html>

<!-- <form action="upload.php" method="post" enctype="multipart/form-data">
<input type="file" name="file">
<input type="submit" value="업로드">
</form> -->

<?php
// // 업로드된 파일이 있는지 확인
// if(isset($_FILES['file'])){
//     // 임시 저장된 파일의 경로와 새로운 파일의 경로와 이름
//     $tmp_name = $_FILES['file']['tmp_name'];
//     $new_name = "uploads/".$_FILES['file']['name'];

//     // 원래 파일의 확장자 구하기
//     $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

//     // 확장자가 .ico인지 확인
//     if($ext == "ico"){
//         // 실제 이미지인지 확인
//         $img_info = getimagesize($tmp_name);
//         if($img_info[2] == 17){
//             // 임시 저장된 파일을 새 위치에 옮기고 이름 변경
//             if(move_uploaded_file($tmp_name,$new_name)){
//                 echo "파일 업로드 성공";
//             }else{
//                 echo "파일 이동 실패";
//             }
//         }else{
//             echo "유효하지 않은 이미지 형식";
//         }
//     }else{
//         echo "허용되지 않은 확장자";
//     }
// }
?>
<!-- 
<form action="upload.php" method="post" enctype="multipart/form-data">
<input type="file" name="file">
<input type="submit" value="업로드">
</form> -->