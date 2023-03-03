<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.ico" favicon type="image/x-icon">
    <link rel="stylesheet" href="../css/login.css">
    <title>은성 관리자 로그인</title>
</head>

<body>
    <?php
        $error = "";
        if (isset($_GET["error"])) {
            if ($_GET["error"] == 1) {
                $error = "아이디 또는 비밀번호가 잘못되었습니다";
            } else if ($_GET["error"] == 2) {
                $error = "서버와의 연결을 확인해주세요";
            }
            else if ($_GET["error"] == 3) {
                $error = "로그인을 먼저 해주세요";
            }else if ($_GET["error"] == 4) {
                $error = "재로그인이 필요합니다";
            }
        }
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let warning = document.getElementById("warning");
            warning.textContent = "<?php echo htmlspecialchars($error, ENT_QUOTES); ?>";
        });


        function login_click() {
            /* 아이디 패스워드 검사 정규식 a~z A~Z 특수문자 숫자 */
            const re = /^[a-zA-Z0-9!@#$%^&*()_+\-=]{1,20}$/;
            const form = document.getElementById("login-form");

            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;
            

            if (!re.test(username) || !re.test(password)) {
                document.getElementById("warning").textContent = "아이디 또는 비밀번호를 입력해주세요";
                return;
            }

            form.submit();
        }  
    </script>

    <div class="login-container">
        <form class="login-form" id="login-form" action="./access.php" method="post" onsubmit="return false">
            <div class="login_box_wrap">
                <img src="../images/logo.png" alt="Logo" height="64">

                <div class="logo_name">관리자 로그인</div>

                <div class="login_box">
                    <input type="text" name="username" id="username" placeholder="아이디" maxlength="20"
                        onkeyup="if(window.event.keyCode==13){login_click()}">
                </div>

                <div class="login_box">
                    <input type="password" name="password" id="password" autoComplete="off" placeholder="비밀번호" maxlength="20"
                        onkeyup="if(window.event.keyCode==13){login_click()}">
                </div>

                <p id="warning"></p>

                <input class="login_btn" onclick="login_click()" type="button" value="로그인">
            </div>
        </form>
    </div>
</body>

</html>