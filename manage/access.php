<?php
require('./dbConnect.php');

$stmt = $pdo->prepare("SELECT * FROM admin WHERE user_id = :username LIMIT 1");
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);

$stmt->execute();

// Fetch results as associative array
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Display results
if ($result && password_verify($_POST["password"], $result["user_pw"])) {
    if ($_SERVER["HTTPS"] != "on") {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }

    ini_set('session.cookie_secure', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_samesite', 'Strict');

    session_start();
    session_regenerate_id(true);

    $_SESSION["user_id"] = $result["user_id"];
    $_SESSION["last_activity"] = time();
    $_SESSION["ip_address"] = $_SERVER["REMOTE_ADDR"];
    $_SESSION["user_agent"] = $_SERVER["HTTP_USER_AGENT"];
    $_SESSION['timeout'] = time() + 900; //15분 뒤 자동 로그아웃

    header("Location: dashboard.php");
    exit();
} else {
    sleep(1); //브루트 포스 공격 방지
    header("Location: login.php?error=1");
    exit();
}
?>