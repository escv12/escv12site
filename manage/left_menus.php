<?php //require("./check_session.php")?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/left_menus.css">
</head>

<body>
    <div class="hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
    </div>


    <div class="left_menu">
        <img src="../images/logo.png" alt="EUNSUNG">
        <div class="left_menu-item" tabindex="0" type="button" onclick="location.href='./dashboard.php'">기본 설정<img src="../images/setting.png" alt=""></div>
        <div class="left_menu-item" tabindex="0" type="button" onclick="location.href='./category.php'">메뉴 관리<img src="../images/category.png" alt=""></div>
        <div class="left_menu-item" tabindex="0" type="button" onclick="location.href='./product_write.php'">글쓰기<img src="../images/write.png" alt=""></div>
        <div class="left_menu-item" tabindex="0" type="button" onclick="location.href='./design.php'">디자인<img src="../images/design.png" alt=""></div>
        <div class="left_menu-item" tabindex="0" type="button" onclick="location.href='./statistics.php'">통계<img src="../images/leader.png" alt=""></div>
        <div class="left_menu-item" tabindex="0" type="button" onclick="location.href='./log.php'">접속 로그<img src="../images/log.png" alt=""></div>
        <div class="left_menu-item" tabindex="0" type="button" onclick="location.href='../main/index.php'">홈페이지<img src="../images/home.png" alt=""></div>
        <div class="left_menu-item" tabindex="0" type="button" onclick="location.href='./change_info.php'">계정 설정<img src="../images/account.png" alt=""></div>
        <div class="left_menu-item" tabindex="0" type="button" onclick="location.href='./logout.php'">로그아웃<img src="../images/logout.png" alt=""></div>
    </div>

    <script>
        /* Toggle navigation left_menu */
        function toggleMenu() {
            document.querySelector('.hamburger').classList.toggle('active');
        }
    </script>

</body>

</html>