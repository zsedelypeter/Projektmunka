<?php
    session_start();
    $_SESSION["isloggedin"] = isset($_SESSION["username"]);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bengo</title>
        <link rel="icon" type="image/x-icon" href="https://www.shutterstock.com/shutterstock/videos/3558613281/thumb/12.jpg?ip=x480">
        <link rel="stylesheet" href="kezdolap.css">
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
                <?php endif; ?>
            </div>
        </div>
        <p>Tudd meg pillanatok alatt, mi rejlik a rendszám mögött!<br>
            Egy kattintás, és máris előtted a jármű múltja, adatai és értéke. Gyorsan, egyszerűen és megbízhatóan.</p>
        <form action="rendszamlekeres.php" method="POST">
            <label for="rendszam">Rendszám:</label><br>
            <input type="text" id="rendszam" name="rendszam" placeholder="ABC123"><br><br>
            <label for="alvazszam">Alvázszám:</label><br>
            <input type="text" id="alvazszam" name="alvazszam" placeholder="4Y1SL65848Z411439"><br><br>
            <input type="submit" value="Ellenőrzés">
        <div class="p2">✔ Jármű vizsgálatai során készült képek<br>
                ✔ Kilométeróra állásának az alakulása<br>
                ✔ Műszaki adatok kimutatása</div>
            </div>
        </form>
         <footer class="footer">
            <a href="https://twitter.com" target="_blank">
                <img src="img/twitter-logo.png" alt="Twitter">
            </a>
            <a href="https://facebook.com" target="_blank">
                <img src="img/facebook.png" alt="Facebook">
            </a>
             <a href="https://github.com/zsedelypeter/Projektmunka" target="_blank">
                 <img src="img/github.png" alt="GitHub">
            </a>
        </footer>
    </body>
</html>