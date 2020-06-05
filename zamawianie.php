<!DOCTYPE html>
<html>
    <head>
        <title>
            Dodawanie
        </title>
        <meta charset = "UTF-8"/>
        <link rel = "stylesheet" href = "./styles/layout.css"/>
        <link rel = "stylesheet" href = "./styles/animacje.css"/>
        <link rel = "stylesheet" href = "./styles/dodawanie.css"/>
        <script src = "./scripts/animacja.js"></script>
        <script src = "./scripts/blad.js"></script>
        <script src = "./scripts/data.js"></script>
    </head>
    <body onload = "animacja.wczytaj(); blad.wykonaj(); data.zacznij()" class = "ruchome">
        <?php
            session_start();
            if ( !isset($_SESSION["email"]) ) {
                $_SESSION["email"] = "brak";
            }
        ?>
        <div class = "top">
            <a href = "./index.php"><img src = "./images/logo_2.png" alt = "Przeglądarka nie obsługuje elementu." class = "logo"/></a>
            <div class = "link_container"><a onclick = "animacja.rozwin_wizyty()" class = "link">WIZYTY</a></div>
            <div class = "link_container"><a href = "./kontakt.php" class = "link">KONTAKT</a></div>
            <div class = "link_container"><a href = "./lekarze.php" class = "link">LEKARZE</a></div>
            <div class = "link_container"><a href = "./ofirmie.php" class = "link">O FIRMIE</a></div>
            <?php
                $db = mysqli_connect("localhost", "root", "", "przychodnia");
                if ( $db ) {
                    $zap_1 = "select * from lekarze where email = '" . $_SESSION["email"] . "';";
                    $zap_2 = "select * from pacjenci where email = '" . $_SESSION["email"] . "';";
                    $zap_3 = "select * from administratorzy where email = '" . $_SESSION["email"] . "';";
                    $query_1 = mysqli_query($db, $zap_1);
                    $query_2 = mysqli_query($db, $zap_2);
                    $query_3 = mysqli_query($db, $zap_3);
                    if ( mysqli_fetch_array($query_1) ) {
                        $_SESSION["konto"] = "lekarz";
                        echo('<div class = "link_container"><a href = "./zarzadzanie.php" class = "link">ZARZĄDZAJ</a></div>');
                        echo('<div class = "link_container"><a href = "./scripts/wylogowanie.php" class = "link">WYLOGUJ</a></div>');
                    } else if ( mysqli_fetch_array($query_2) ) {
                        $_SESSION["konto"] = "pacjent";
                        echo('<div class = "link_container"><a href = "./zarzadzanie.php" class = "link">PROFIL</a></div>');
                        echo('<div class = "link_container"><a href = "./scripts/wylogowanie.php" class = "link">WYLOGUJ</a></div>');
                    } else if ( mysqli_fetch_array($query_3) ) {
                        $_SESSION["konto"] = "admin";
                        echo('<div class = "link_container"><a href = "./zarzadzanie.php" class = "link">ZARZĄDZAJ</a></div>');
                        echo('<div class = "link_container"><a href = "./scripts/wylogowanie.php" class = "link">WYLOGUJ</a></div>');
                    } else {
                        $_SESSION["konto"] = "brak";
                        echo('<div class = "link_container" style = "width: 20%;"><a href = "./logowanie.php" class = "link">LOGOWANIE</a></div>');
                    }
                    mysqli_close($db);
                }
            ?>
        </div>
        <div class = "empty" id = "empty_1"></div>
        <div class = "header_1">ZAMAWIANIE WIZYTY</div>
        <div class = "header_2">Wymagane uprawnienia: PACJENT</div>
        <div class = "content"> 
            <form method = "post" action = "./scripts/zamow.php">
                <?php
                    $db = mysqli_connect("localhost", "root", "", "przychodnia");
                    if ( $db ) {
                        echo("<select name = 'lekarz' required style = 'margin-left: 26.5%; margin-right: 26.5%;'><option value = ''>---Wybierz lekarza---</option>");
                        $zap_1 = "select id_lekarz, concat(imie, space(1), nazwisko) as lekarz, specjalizacja from lekarze order by specjalizacja;";
                        $query_1 = mysqli_query($db, $zap_1);
                        while ( $lekarz = mysqli_fetch_array($query_1) ) {
                            echo("<option value = '" . $lekarz["id_lekarz"] . "'>" . $lekarz["specjalizacja"] . " " . $lekarz["lekarz"] . "</option>");
                        }
                        echo("</select>");
                        echo("<input type = 'radio' name = 'prywatna' value = '1' class = 'checkbox' required/><p>Wizyta prywatna</p>");
                        echo("<input type = 'radio' name = 'prywatna' value = '0' class = 'checkbox' required/><p>Wizyta na koszt NFZ</p>");
                        echo("<input type = 'text' name = 'rok' class = 'data' placeholder = 'Rok' pattern = '[0-9]{4}' required title = 'Rok (4 liczby)' style = 'margin-left: 32%;'/>");
                        echo("<input type = 'text' name = 'mie' class = 'data' placeholder = 'Miesiąc' pattern = '[0-9]{1,2}' required title = 'Miesiąc (1-2 liczby)'/>");
                        echo("<input type = 'text' name = 'dzi' class = 'data' placeholder = 'Dzień' pattern = '[0-9]{1,2}' required title = 'Dzien (1-2 liczby)'/>");
                        echo("<input type = 'text' name = 'god' class = 'data' placeholder = 'Godzina' pattern = '[0-9]{1,2}' required title = 'Godzina (1-2 liczby)' style = 'margin-left: 37%;'/>");
                        echo("<input type = 'text' name = 'min' class = 'data' placeholder = 'Minuta' pattern = '[0-9]{1,2}' required title = 'Minuta (1-2 liczby)'/>");
                    }
                    mysqli_close($db);
                ?>
                <input type = "submit" class = "submit"/>
            </form>
        </div>
        <div class = "empty" id = "empty_2"></div>
        <div class = "footer"><?php echo($_SESSION["email"]); ?></div>
    </body>
</html>