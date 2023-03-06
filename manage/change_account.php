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
    header("Location: change_info.php?error=1");
    exit;
}

try {
    $dsn = "mysql:host=$db_host;dbname=$db_name";
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header("Location: change_info.php?error=1");
    exit;
}

$user_id = filter_input(INPUT_POST, $_SESSION['user_id'], FILTER_SANITIZE_STRING);
$new_user_id = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if (empty($new_user_id)) {
    // Only change the password
    $stmt = $pdo->prepare("UPDATE admin SET password = ? WHERE user_id = ?");
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute([$password_hash, $user_id]);
} else {
    // Change both user ID and password
    // Check if the new user ID is available
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin WHERE user_id = ?");
    $stmt->execute([$new_user_id]);

    if ($stmt->fetchColumn() > 0) {
        header("Location: error.php?error=1");
        exit;
    }

    // Update the user ID and password
    $stmt = $pdo->prepare("UPDATE admin SET user_id = ?, password = ? WHERE user_id = ?");
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute([$new_user_id, $password_hash, $user_id]);
}

if ($stmt->rowCount() > 0) {
    header("Location: change_info.php?success=1");
    exit;
} else {
    header("Location: change_info.php?error=1");
    exit;
}
?>
