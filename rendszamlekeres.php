<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Projekt";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

$rendszam = $_POST["rendszam"];
$alvazszam = $_POST["alvazszam"];

$sql = 'SELECT rendszam, alvazszam, marka, tipus, szin, gydatum, uzema, hengeru, teljesitmeny, kep, kmallas, muszakilej, forgalome, biztositase, korozese, tulajdonossz, motorkod, kornyezetved, gepjkat, utassz, valtotip, kivitel, tomeg, vontattomf, vontattomfn FROM autok WHERE rendszam = ? OR alvazszam = ? ';
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $rendszam, $alvazszam);
$stmt->execute();
$result = $stmt->get_result();

/*Kiíratás*/
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<h3>Autó adatok:</h3>";
        echo "Rendszám: " . $row["rendszam"] . "<br>";
        echo "Alvázszám: " . $row["alvazszam"] . "<br>";
        echo "Márka: " . $row["marka"] . "<br>";
        echo "Típus: " . $row["tipus"] . "<br>";
        echo "Szín: " . $row["szin"] . "<br>";
        echo "Gyártási dátum: " . $row["gydatum"] . "<br>";
        echo "Üzemanyag: " . $row["uzema"] . "<br>";
        echo "Hengerűrtartalom: " . $row["hengeru"] . "<br>";
        echo "Teljesítmény: " . $row["teljesitmeny"] . "<br>";
        echo "Kép: " . $row["kep"] . "<br>";
        echo "Kilométeróra állás: " . $row["kmallas"] . "<br>";
        echo "Műszaki lejárat: " . $row["muszakilej"] . "<br>";
        echo "Forgalmi engedély: " . $row["forgalome"] . "<br>";
        echo "Biztosítás: " . $row["biztositase"] . "<br>";
        echo "Korrózió: " . $row["korozese"] . "<br>";
        echo "Tulajdonosok száma: " . $row["tulajdonossz"] . "<br>";
        echo "Motorkód: " . $row["motorkod"] . "<br>";
        echo "Környezetvédelmi osztály: " . $row["kornyezetved"] . "<br>";
        echo "Gépjármű kategória: " . $row["gepjkat"] . "<br>";
        echo "Utasok száma: " . $row["utassz"] . "<br>";
        echo "Váltó típus: " . $row["valtotip"] . "<br>";
        echo "Kivitel: " . $row["kivitel"] . "<br>";
        echo "Tömeg: " . $row["tomeg"] . "<br>";
        echo "Vontatott tömeg fékkel: " . $row["vontattomf"] . "<br>";
        echo "Vontatott tömeg fék nélkül: " . $row["vontattomfn"] . "<br>";
    }
} else {
    echo "Nincs ilyen!";
}

// Closing connection
$conn->close();
?>