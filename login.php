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

$sql = "SELECT felhasznalonev FROM felhasznalok WHERE felhasznalonev = ? AND jelszo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {

    header("Location: kezdolap.html");
} else {
    echo "Kristóf egy zebra!";
}