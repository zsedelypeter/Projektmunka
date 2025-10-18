<?php
// Enable MySQLi exceptions (at the top of your file)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Projekt";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

// Prepared Statements (RECOMMENDED - Most Secure)
$sql = "INSERT INTO felhasznalok (felhasznalonev, email, jelszo) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if prepare() failed
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $username, $email, $password);

try {
    $stmt->execute();
    
    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        $last_id = $conn->insert_id;
        echo "Sikeres regisztráció! Last inserted ID is: " . $last_id;
    } else {
        echo "Sikertelen regisztráció!";
    }
    
} catch (mysqli_sql_exception $e) {
    // Handle specific errors (like duplicate username/email)
    if ($e->getCode() == 1062) { // Duplicate entry error code
        echo "Hiba: A felhasználónév vagy email már létezik!";
    } else {
        echo "Hiba történt a regisztráció során: " . $e->getMessage();
    }
}
