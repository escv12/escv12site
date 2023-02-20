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
        // Password is correct, do something here
        echo "Password is correct";
    } else {
        // Password is incorrect, do something else here
            echo "Password is incorrect";
            echo $result;
            echo $result["user_pw"];
    }
} catch(PDOException $e) {
    echo "Error retrieving data: " . $e->getMessage();
}
?>