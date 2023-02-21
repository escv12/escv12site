<?php
// Set environment variables for database credentials
$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

// Connect to database
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement with placeholders for values
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE user_id = :username");

    // Bind parameter to placeholder
    $stmt->bindParam(':username', $username);

    // Set parameter value
    $username = $_POST["username"];

    // Execute SQL statement
    $stmt->execute();

    // Fetch results as associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display results
    if ($result && password_verify($_POST["password"], $result["user_pw"])) {
        session_start();
        $_SESSION["user_id"] = $result["user_id"];
        header("Location: management.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
} catch(PDOException $e) {
        header("Location: login.php?error=2");
        exit();
}
?>