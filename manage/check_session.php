<?php
// 세션 시작
session_start();

// 유저 로그인, 세션상태 체크
if (
    !isset($_SESSION["user_id"]) || !isset($_SESSION["last_activity"]) ||
    ($_SESSION["last_activity"] + 1800) < time() ||
    $_SESSION["ip_address"] !== $_SERVER["REMOTE_ADDR"] ||
    $_SESSION["user_agent"] !== $_SERVER["HTTP_USER_AGENT"]
) {
    // 로그인 하지 않았으면 로그인 페이지로 리다이렉션
    header("Location: login.php?error=3");
    exit();
}

//15분 지나면 자동 로그아웃
if (isset($_SESSION['timeout']) && $_SESSION['timeout'] < time()) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php?error=4");
    exit();
}

$_SESSION['timeout'] = time() + 900;
?>