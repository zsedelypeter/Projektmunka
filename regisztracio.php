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
$email = $_POST["email"];
$password = $_POST["password"];

$stmt = $conn->prepare("SELECT felhasznalonev FROM felhasznalok WHERE felhasznalonev = ?");
$stmt -> bind_param("s", $username);
$stmt -> execute();
$result = $stmt->get_result();
$new_user = true;

if ($result->num_rows > 0) {
    echo "Foglalt felhasználónév!<br>";
    $new_user = false;
}

$stmt = $conn->prepare("SELECT email FROM felhasznalok WHERE email = ?");
$stmt -> bind_param("s", $email);
$stmt -> execute();
$result = $stmt->get_result();
$new_email = true;

if ($result->num_rows > 0) {
    echo "Foglalt email!<br>";
    $new_email = false;
}

if ($new_user AND $new_email) {
    $sql = "INSERT INTO felhasznalok (felhasznalonev, email, jelszo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Sikeres regisztráció!";
        }
    }
}