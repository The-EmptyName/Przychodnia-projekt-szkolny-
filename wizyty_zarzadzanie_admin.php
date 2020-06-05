<!DOCTYPE html>
<html>
    <head>
        <title>
            Zarządzanie wizytami
        </title>
        <meta charset = "UTF-8"/>
        <link rel = "stylesheet" href = "./styles/layout.css"/>
        <link rel = "stylesheet" href = "./styles/animacje.css"/>
        <link rel = "stylesheet" href = "./styles/wizyty_zarzadzanie.css"/>
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
        <div class = "header_1">ZARZĄDZANIE WIZYTAMI</div>
        <div class = "header_2">Wymagane uprawnienia: ADMINISTRATOR/PRACOWNIK</div>
        <div class = "content">
            <form method = "post" action = "./scripts/wizyty.php">
                <table class = "wizyty">
                    <th>
                        Lekarz
                    </th>
                    <th>
                        Pacjent
                    </th>
                    <th>
                        Data i godzina
                    </th>
                    <th>
                        Typ wizyty
                    </th>
                    <th>
                        Wizyta zakończona
                    </th>
                    <th>
                        Wybierz
                    </th>
                    <?php
                        $db = mysqli_connect("localhost", "root", "", "przychodnia");
                        if ( $db ) {
                            $zap = "select id_wizyta, concat(wizyty.godzina, space(1), wizyty.data) as czas, wizyty.prywatna, wizyty.zakonczona, concat(lekarze.imie, space(1), lekarze.nazwisko) as lekarz, concat(pacjenci.imie, space(1), pacjenci.nazwisko) as pacjent from wizyty inner join lekarze using(id_lekarz) inner join pacjenci using(id_pacjent) order by data desc;";
                            $query = mysqli_query($db, $zap);
                            $n = 0;
                            while ( $result = mysqli_fetch_array($query) ) {
                                if ( $n % 2 == 0 ) {
                                    echo("<tr class = 'ciemne'>");
                                } else {
                                    echo("<tr class = 'jasne'>");
                                }
                                echo("<td>" . $result["lekarz"] . "</td>");
                                echo("<td>" . $result["pacjent"] . "</td>");
                                echo("<td>" . $result["czas"] . "</td>");
                                if ( $result["prywatna"] == 1 ) {
                                    echo("<td>Prywatna</td>");
                                } else {
                                    echo("<td>NFZ</td>");
                                }
                                if ( $result["zakonczona"] == 1 ) {
                                    echo("<td>Tak</td>");
                                } else {
                                    echo("<td>Nie</td>");
                                }
                                echo("<td><input type = 'radio' class = 'radio' name = 'wizyta' value = '" . $result["id_wizyta"] . "' required checked/>");
                                echo("</tr>");
                                $n ++;
                            }
                            mysqli_close($db);
                        }
                    ?>
                </table>
                <input class = "button" type = "submit" value = "Edytuj wybraną wizytę" name = "e"/>
                <input class = "button" type = "submit" value = "Dodaj nową wizytę" name = "d"/>
                <input class = "button" type = "submit" value = "Zakończ wybraną wizytę" name = "u"/>
            </form>
        </div>
        <div class = "empty" id = "empty_2"></div>
        <div class = "footer"><?php echo($_SESSION["email"]); ?></div>
    </body>
</html>