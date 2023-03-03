<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=3");
    exit;
}

$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

if (!$db_host || !$db_name || !$db_user || !$db_pass) {
    header("Location: login.php?error=2");
    exit;
}


try {
    $dsn = "mysql:host=$db_host;dbname=$db_name";
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header("Location: login.php?error=2");
    exit;
}

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING);

$stmt = $pdo->prepare("DELETE FROM admin WHERE user_id = ? LIMIT 1");

if (!$stmt) {
    header("Location: login.php?error=2");
    exit;
}

$stmt->bindParam(1, $user_id, PDO::PARAM_STR);

if ($stmt->execute()) {
    header("Location: login.php");
    exit;
} else {
    header("Location: login.php?error=2");
    exit;
}
?>