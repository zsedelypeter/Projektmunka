<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bengo</title>
        <link rel="stylesheet" href="rendszamlekeres_front.css">
    </head>
    <body>
        <div class="fejlec">
            <h1>Bengo</h1>
            <div class="bejelentkezes_gomb"> 
                <?php if ($_SESSION["isloggedin"]): ?> 
                <?php echo "<h3>" . $_SESSION["username"] . "</h3>" ?> 
                <a href="logout.php" class="bejelentkezes_gombja">Kijelentkezés</a> 
                <?php else: ?> 
                <a href="login.html" class="bejelentkezes_gombja">Bejelentkezés</a> 
                <?php endif; ?> </div> 
            </div> 
        </body> 
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
   
    $saved = implode([$rendszam, $alvazszam, $_SESSION["isloggedin"]]);


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
</div>
    <?php
    //Kiiratás
    if (count($all_rows) > 0) {
        $firstRow = true;
        foreach($all_rows as $row) {
            if ($row["mvdatum"] == $selected_year) {
                if ($firstRow){
                    echo "<div class='auto_adatok'>";
                    echo "<h3>Az autó specifikációi</h3>";
                    echo "<div class='row'>";
                    echo "<div class='item'><img src='img/rendszamtabla.png' alt='Rendszámtábla'> Rendszám: " . $row["rendszam"] . "</div>";
                    echo "<div class='item'><img src='img/rendszamtabla.png' alt='Alvázszám'> Alvázszám: " . $row["alvazszam"] . "</div>";
                    echo "<div class='item'><img src='img/Gyártó.png' alt='Gyártó'> Gyártó: " . $row["marka"] . "</div>";
                    echo "<div class='item'><img src='img/Típus.png' alt='Típus'> Típus: " . $row["tipus"] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='item'><img src='img/Szín.png' alt='Szín'> Szín: " . $row["szin"] . "</div>";
                    echo "<div class='item'><img src='img/gy_dátum.png' alt='Gyártás dátuma'> Gyártás dátuma: " . $row["gydatum"] . "</div>";
                    echo "<div class='item'><img src='img/Üzemanyag.png' alt='Üzemanyag'> Üzemanyag típusa: " . $row["uzema"] . "</div>";
                    echo "<div class='item'><img src='img/Motor.png' alt='Hengerűrtartalom'> Hengerűrtartalom: " . $row["hengeru"] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='item'><img src='img/Motor.png' alt='Teljesítmény'> Teljesítmény: " . $row["teljesitmeny"] . "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div/div>";
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
            dataArray.splice(0, 0, ['Dátum', 'Kilométeróra-állás']);
            const data = google.visualization.arrayToDataTable(dataArray);
            const options = {
                hAxis: {title: 'Dátum'},
                vAxis: {title: 'Kilométeróra-állás'},
                legend: 'none',
                pointSize: 15,
                backgroundColor: 'transparent',
            };

            const chart = new google.visualization.LineChart(document.getElementById("Diagram"));
            chart.draw(data, options);
        }
    </script>
                <?php $kep = 'img/' . $row["kep"];
                //Ha be van jelentkezve
                if ($_SESSION["isloggedin"]) {
                    echo "<div class='auto_adatok_bovitett'>";
                    echo "<h3>További adatok</h3>";
                    echo "<div class='row'>";
                    echo "<div class='item'><img src='img/muszaki_lejarat.png' alt='Műszaki vizsga'> Műszaki vizsga lejárata: ". $row["muszakilej"] . "</div>";
                    echo "<div class='item'><img src='img/forgalmi.png' alt='Forgalmi engedély'> Forgalmi engedély: " . $row["forgalome"] . "</div>";
                    echo "<div class='item'><img src='img/biztositas.png' alt='Biztosítás'> Biztosítás: " . $row["biztositase"] . "</div>";
                    echo "<div class='item'><img src='img/rozsda.png' alt='Rozsda'> Korrózió: " . $row["korozese"] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='item'><img src='img/tulajdonos.png' alt='Tulajdonos'> Tulajdonosok száma: " . $row["tulajdonossz"] . "</div>";
                    echo "<div class='item'><img src='img/motorkod.png' alt='Motorkód'> Motorkód: " . $row["motorkod"] . "</div>";
                    echo "<div class='item'><img src='img/euro.png' alt='Környezetvédelmi osztály'> Környézetvédelmi osztály: " . $row["kornyezetved"] . "</div>";
                    echo "<div class='item'><img src='img/jarmu_tipusa.png' alt='Gépjármű kategória'> Gépjármű kategória: " . $row["gepjkat"] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='item'><img src='img/utas.png' alt='Utasok száma'> Utasok száma: " . $row["utassz"] . "</div>";
                    echo "<div class='item'><img src='img/valto.png' alt='Váltó típus'> Váltó típus: " . $row["valtotip"] . "</div>";
                    echo "<div class='item'><img src='img/kivitel.png' alt='Kivitel'> Kivitel: " . $row["kivitel"] . "</div>";
                    echo "<div class='item'><img src='img/tomeg.png' alt='Tömeg'> Tömeg: " . $row["tomeg"] . "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='item'><img src='img/utanfuto.png' alt='Vontatott tömeg fékkel'> Vontatott tömeg fékkel: " . $row["vontattomf"] . "</div>";
                    echo "<div class='item'><img src='img/utanfuto.png' alt='Vontatott tömeg fék nélkül'> Vontatott tömeg fék nélkül: " . $row["vontattomfn"] . "</div>";
                    echo "<div class='item'><img src='img/vizsga.png' alt='Műszaki vizsga'> Műszaki vizsga dátuma: " . $row["mvdatum"] . "</div>";
                    echo "<div class='item'><img src='img/vizsga_eredmeny.png' alt='Műszaki vizsga eredménye'> Műszaki vizsga eredménye: " . $row["eredmeny"] . "</div>";
                    echo "</div>";
                    echo "<div/div>";
                }
                $firstRow = false;
                }
            }
        }
    } else {
        echo "Nincs ilyen!";
    }


    ?>
    <div class="form-container">
        <form action="rendszamlekeres.php" method="POST">
            <input type="hidden" name="rendszam" value="<?= $rendszam ?>">
            <input type="hidden" name="alvazszam" value="<?= $alvazszam ?>">
            <select id="yearselect" name="selected_year">
            </select>
        </form>
        
        <button id="ViewImageBtn" class="view-image-btn" car-image-src="<?php echo $kep; ?>">Átvizsgálás során készült képek</button>
                <div id="Modal" class="modal">
                    <span class="close">X</span>
                    <img class="modal-content" id="img01">
                </div>
                <script>
                    //Kép popup 
                    var modal = document.getElementById("Modal");
                    var modalimg = document.getElementById("img01");
                    var btn = document.getElementById("ViewImageBtn");
                    btn.onclick = function(){
                        modal.style.display = "block";
                        modalimg.src = this.getAttribute('car-image-src');
                    }
                    var span = document.getElementsByClassName("close")[0];
                    span.onclick = function(){
                        modal.style.display = "none";
                    }
                </script>
        </div>
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
    </body>
</html>