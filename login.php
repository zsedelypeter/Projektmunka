<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Projekt";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

$username = $_POST["username"];
$password = $_POST["password"];

// Method 1: Prepared Statements (RECOMMENDED - Most Secure)
$sql = "SELECT felhasznalonev FROM felhasznalok WHERE felhasznalonev = ? AND jelszo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password); // "ss" means both parameters are strings
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // Login successful - print the values
    header("Location: kezdolap.html");
} else {
    echo "Kristóf egy zebra!";
}