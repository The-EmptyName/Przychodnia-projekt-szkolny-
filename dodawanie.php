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
        <div class = "header_1">DODAWANIE <?php echo($_SESSION["dodaj"]); ?></div>
        <div class = "header_2">Wymagane uprawnienia: ADMINISTRATOR/PRACOWNIK</div>
        <div class = "content"> 
            <form method = "post" action = "./scripts/dodaj.php">
                <?php
                    $db = mysqli_connect("localhost", "root", "", "przychodnia");
                    if ( $db ) {
                        if ( $_SESSION["dodaj"] == "WIZYTY" ) {
                            echo("<select name = 'lekarz' required><option value = ''>---Wybierz lekarza---</option>");
                            $zap_1 = "select id_lekarz, concat(imie, space(1), nazwisko) as lekarz, specjalizacja from lekarze order by specjalizacja;";
                            $zap_2 = "select id_pacjent, concat(imie, space(1), nazwisko) as pacjent, pesel from pacjenci order by pacjent;";
                            $query_1 = mysqli_query($db, $zap_1);
                            $query_2 = mysqli_query($db, $zap_2);
                            while ( $lekarz = mysqli_fetch_array($query_1) ) {
                                echo("<option value = '" . $lekarz["id_lekarz"] . "'>" . $lekarz["specjalizacja"] . " " . $lekarz["lekarz"] . "</option>");
                            }
                            echo("</select>");
                            echo("<select name = 'pacjent' required><option value = ''>---Wybierz pacjenta---</option>");
                            while ( $pacjent = mysqli_fetch_array($query_2) ) {
                                echo("<option value = '" . $pacjent["id_pacjent"] . "'>" . $pacjent["pacjent"] . " (" . $pacjent["pesel"] . ")</option>");
                            }
                            echo("<input type = 'checkbox' name = 'prywatna' class = 'checkbox'/><p>Wizyta prywatna</p>");
                            echo("<input type = 'text' name = 'rok' class = 'data' placeholder = 'Rok' pattern = '[0-9]{4}' required title = 'Rok (4 liczby)' style = 'margin-left: 32%;'/>");
                            echo("<input type = 'text' name = 'mie' class = 'data' placeholder = 'Miesiąc' pattern = '[0-9]{1,2}' required title = 'Miesiąc (1-2 liczby)'/>");
                            echo("<input type = 'text' name = 'dzi' class = 'data' placeholder = 'Dzień' pattern = '[0-9]{1,2}' required title = 'Dzien (1-2 liczby)'/>");
                            echo("<input type = 'text' name = 'god' class = 'data' placeholder = 'Godzina' pattern = '[0-9]{1,2}' required title = 'Godzina (1-2 liczby)' style = 'margin-left: 37%;'/>");
                            echo("<input type = 'text' name = 'min' class = 'data' placeholder = 'Minuta' pattern = '[0-9]{1,2}' required title = 'Minuta (1-2 liczby)'/>");
                        }
                        if ( $_SESSION["dodaj"] == "LEKARZA" ) {
                            echo("<input type = 'text' maxlength = '20' class = 'lekarz' name = 'imie' placeholder = 'Imię' required style = 'margin-left: 9%;'/>");
                            echo("<input type = 'text' maxlength = '25' class = 'lekarz' name = 'nazwisko' placeholder = 'Nazwisko' required/>");
                            echo("<input type = 'text' maxlength = '50' class = 'lekarz' name = 'specjalizacja' placeholder = 'Specjalizacja' required/>");
                            echo("<input type = 'text' class = 'kontakt' name = 'telefon' placeholder = 'Numer telefonu' pattern = '[0-9]{9}' title = 'Numer telefonu (9 cyfr)' required style = 'margin-left: 22%;'/>");
                            echo('<input class = "kontakt" placeholder = "Adres e-mail" type = "email" name = "email" maxlength = "100" required pattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/>');
                            echo("<input type = 'password' class = 'haslo' name = 'haslo' placeholder = 'Hasło' minlength = '8' required style = 'margin-left: 35%;'/>");
                        } else if ( $_SESSION["dodaj"] == "GRAFIKU" ) {
                            echo("<select name = 'lekarz' required style = 'margin-left: 26.5%'><option value = ''>---Wybierz lekarza---</option>");
                            $zap_1 = "select id_lekarz, concat(imie, space(1), nazwisko) as lekarz, specjalizacja from lekarze order by specjalizacja;";
                            $query_1 = mysqli_query($db, $zap_1);
                            while ( $lekarz = mysqli_fetch_array($query_1) ) {
                                echo("<option value = '" . $lekarz["id_lekarz"] . "'>" . $lekarz["specjalizacja"] . " " . $lekarz["lekarz"] . "</option>");
                            }
                            echo("</select>");
                            echo("<input type = 'text' name = 'god_r' class = 'data' placeholder = 'Godzina rozpoczęcia' pattern = '[0-9]{1,2}' required title = 'Godzina (1-2 liczby)' style = 'margin-left: 37%;'/>");
                            echo("<input type = 'text' name = 'min_r' class = 'data' placeholder = 'Minuta rozpoczęcia' pattern = '[0-9]{1,2}' required title = 'Minuta (1-2 liczby)'/>");
                            echo("<input type = 'text' name = 'god_z' class = 'data' placeholder = 'Godzina zakończenia' pattern = '[0-9]{1,2}' required title = 'Godzina (1-2 liczby)' style = 'margin-left: 37%;'/>");
                            echo("<input type = 'text' name = 'min_z' class = 'data' placeholder = 'Minuta zakończenia' pattern = '[0-9]{1,2}' required title = 'Minuta (1-2 liczby)'/>");
                            echo("<input type = 'text' name = 'dni' class = 'data' minlength = '7' placeholder = 'Dni pracy' pattern = '[01]{7}' required title = '7 liczb (1 lub 0, gdzie 1 to dzień pracy, a 0 to dzień wolny, np. 1111100)' style = 'margin-left: 43%;'/>");
                            echo("<input type = 'number' name = 'gabinet' class = 'data' minlength = '1' maxlength = '3' placeholder = 'Gabinet' required style = 'margin-left: 43%;'/>");
                        }
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