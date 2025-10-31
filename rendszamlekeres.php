<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kristóf</title>
        <link rel="stylesheet" href="login_front.css">
    </head>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Projekt";

        

    $rendszam = $_POST["rendszam"];
    $alvazszam = $_POST["alvazszam"];
    $selected_year = null;
    if (isset($_POST["selected_year"])){
         $selected_year = $_POST["selected_year"];
    }
   
    $saved = implode([$rendszam, $alvazszam]);


    //Ha már rákerestünk erre az autóra, akkor nem csinálunk újabb lekérdezést, hanem a régiből dolgozunk, ha pedig új autóra keresünk, elmentjük a lekérdezés eredményét emiatt
    if (!isset($_SESSION[$saved])){
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //Lekérdezés attól függően, hogy be e vagyunk jelentkezve
        if ($_SESSION["isloggedin"]){
            $sql = 'SELECT a.rendszam, a.alvazszam, a.marka, a.tipus, a.szin, a.gydatum, a.uzema, a.hengeru, a.teljesitmeny, a.kep, m.kmallas, a.muszakilej, a.forgalome, a.biztositase, a.korozese, a.tulajdonossz, a.motorkod, a.kornyezetved, a.gepjkat, a.utassz, a.valtotip, a.kivitel, a.tomeg, a.vontattomf, a.vontattomfn, m.mvdatum, m.eredmeny FROM autok a LEFT JOIN muszaki_vizsga m ON a.alvazszam = m.alvazszam WHERE a.rendszam = ? OR a.alvazszam = ? ORDER BY m.mvdatum DESC';
        } else {
            $sql = 'SELECT a.rendszam, a.alvazszam, a.marka, a.tipus, a.szin, a.gydatum, a.uzema, a.hengeru, a.teljesitmeny, a.kep, m.kmallas, m.mvdatum FROM autok a LEFT JOIN muszaki_vizsga m ON a.alvazszam = m.alvazszam WHERE a.rendszam = ? OR a.alvazszam = ? ORDER BY m.mvdatum DESC';
        }
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $rendszam, $alvazszam);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //Az év kiválasztáshoz a dátumok begyűjtése és az összes adat tárolása (ezt így kell mert máshogy nem jó, pointer egyszer átmegy az adatokon vissza nem lehet állítani)
        $dates = [];
        $all_rows = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $all_rows[] = $row;
                if ($row["mvdatum"]) {
                    $dates[] = $row["mvdatum"];
                }
            }
        }
        $_SESSION[$saved] = [
            'dates' => $dates,
            'all_rows' => $all_rows
        ];
        $conn->close();
    } else{
        $dates = $_SESSION[$saved]["dates"];
        $all_rows = $_SESSION[$saved]["all_rows"];
    }

    
    
    
    // Ha nincs kiválasztott év, akkor az első elérhető dátumot választjuk ki alapértelmezettként, így betölti az oldal az adatokat, nem pedig csak üresen hagyja az oldalt
    if ($selected_year === null) {
        $selected_year = $dates[0];
    }
    ?>
    
    <body>
        <form action="rendszamlekeres.php" method="POST">
            <input type="hidden" name="rendszam" value="<?= $rendszam ?>">
            <input type="hidden" name="alvazszam" value="<?= $alvazszam ?>">
            <select id="yearselect" name="selected_year">
            </select>
        </form>
        
        <script>
            //A dropdopwn menüben csak az autóhoz tartozó dátumok legyenek
            const selected_year = <?= json_encode($selected_year) ;?>;
            const yeardropdown = document.getElementById("yearselect");
            const yeardata = <?= json_encode($dates);?>;
            for (i=0; i<yeardata.length; i++){
                let option = document.createElement("option");
                option.setAttribute('value', yeardata[i]);
                let optionText = document.createTextNode(yeardata[i]);
                
                option.appendChild(optionText);
                if (yeardata[i] === selected_year){
                    option.selected = true;
                }
                yeardropdown.appendChild(option);
            }
            yeardropdown.dispatchEvent(new Event("change"))
            yeardropdown.addEventListener("change", autosubmit);
            let selectDate;
            function autosubmit(){
                if(this.value != "dummy"){
                    this.form.submit();
                }
            }
        </script>


    <?php
    //Kiiratás
    if (count($all_rows) > 0) {
        $firstRow = true;
        foreach($all_rows as $row) {
            if ($row["mvdatum"] == $selected_year) {
                if ($firstRow){
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
                echo "Műszaki vizsga dátuma: " . $row["mvdatum"] . "<br>";
                
                //Ha be van jelentkezve
                if ($_SESSION["isloggedin"]) {
                    echo "Műszaki lejárat: " . $row["muszakilej"] . "<br>";
                    echo "Forgalmi engedély: " . $row["forgalome"] . "<br>";
                    echo "Biztosítás: " . $row["biztositase"] . "<br>";
                    echo "Korrózió: " . $row["korozese"] . "<br>";
                    echo "Tulajdonosok száma: " . $row["tulajdonossz"] . "<br>";
                    echo "Motorkód: " . $row["motorkod"] . "<br>";
                    echo "Környézetvédelmi osztály: " . $row["kornyezetved"] . "<br>";
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
                $firstRow = false;
                }
            }
        }
    } else {
        echo "Nincs ilyen!";
    }


    ?>
    <!--Diagram-->
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <div id="Diagram"></div>
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart(){
            const all_rows = <?= json_encode($all_rows);?>;
            const dataArray = [];
            all_rows.forEach(element => {
                if (element.mvdatum && element.kmallas){
                    dataArray.push([element.mvdatum, element.kmallas]);
                }
            });
            dataArray.reverse();
            dataArray.splice(0, 0, ['Dátum', 'Kilóméteróra állása']);
            const data = google.visualization.arrayToDataTable(dataArray);
            const options = {
                title: 'Kilóméteróra állásának változása az idő során',
                hAxis: {title: 'Dátum'},
                vAxis: {title: 'Kilóméteróra állása'},
                legend: 'none',
                pointSize: 15,
            };

            const chart = new google.visualization.LineChart(document.getElementById("Diagram"));
            chart.draw(data, options);
        }
    </script>
    </body>
</html>