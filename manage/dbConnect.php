<?php
//Set environment variables for database credentials
$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');


$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4');


// Connect to database using PDO with SSL encryption
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4;sslmode=require", $db_user, $db_pass, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    header("Location: login.php?error=2");
    exit();
}
?>
