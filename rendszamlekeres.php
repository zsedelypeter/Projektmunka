<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kristóf</title>
        <link rel="stylesheet" href="login_front.css">
    </head>
    <body>
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

    if ($_SESSION["isloggedin"]){
        $sql = 'SELECT a.rendszam, a.alvazszam, a.marka, a.tipus, a.szin, a.gydatum, a.uzema, a.hengeru, a.teljesitmeny, a.kep, m.kmallas, a.muszakilej, a.forgalome, a.biztositase, a.korozese, a.tulajdonossz, a.motorkod, a.kornyezetved, a.gepjkat, a.utassz, a.valtotip, a.kivitel, a.tomeg, a.vontattomf, a.vontattomfn, m.mvdatum, m.eredmeny FROM autok a LEFT JOIN muszaki_vizsga m ON a.alvazszam = m.alvazszam WHERE a.rendszam = ? OR a.alvazszam = ? ';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $rendszam, $alvazszam);
        $stmt->execute();
        $result = $stmt->get_result();

        /*Kiíratás*/
        if ($result->num_rows > 0) {
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
                echo "Kép: <br><div class='image_container'><img src='img/" . $row["kep"] . "' alt='" . $row["kep"] . "'></div><br>";
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
                echo "Műszaki vizsga dátuma: " . $row["mvdatum"] . "<br>";
                echo "Műszaki vizsga eredménye: " . $row["eredmeny"] . "<br>";
            }
        } else {
            echo "Nincs ilyen!";
        }
    } else {
        $sql = 'SELECT a.rendszam, a.alvazszam, a.marka, a.tipus, a.szin, a.gydatum, a.uzema, a.hengeru, a.teljesitmeny, a.kep, m.kmallas FROM autok a LEFT JOIN muszaki_vizsga m ON a.alvazszam = m.alvazszam WHERE a.rendszam = ? OR a.alvazszam = ? ';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $rendszam, $alvazszam);
        $stmt->execute();
        $result = $stmt->get_result();

        /*Kiíratás*/
        if ($result->num_rows > 0) {
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
                echo "Kép: <br><div class='image_container'><img src='img/" . $row["kep"] . "' alt='" . $row["kep"] . "'></div><br>";
                echo "Kilométeróra állás: " . $row["kmallas"] . "<br>";
            }
        } else {
            echo "Nincs ilyen!";
        }
    }

    

    $conn->close();
    ?>

    </body>
</html>