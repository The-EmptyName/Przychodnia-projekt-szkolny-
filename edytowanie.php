<!DOCTYPE html>
<html>
    <head>
        <title>
            Edytowanie
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
        <div class = "header_1">EDYTOWANIE <?php echo($_SESSION["edytuj"]); ?></div>
        <div class = "header_2">Wymagane uprawnienia: ADMINISTRATOR/PRACOWNIK</div>
        <div class = "content"> 
            <form method = "post" action = "./scripts/edytuj.php">
                <?php
                    $db = mysqli_connect("localhost", "root", "", "przychodnia");
                    if ( $db ) {
                        if ( $_SESSION["edytuj"] == "WIZYTY" ) {
                            $zap_0 = "select id_lekarz, concat(specjalizacja, space(1), imie, space(1), nazwisko) as lekarz from lekarze inner join wizyty using(id_lekarz) where id_wizyta = " . $_SESSION["id"] . ";";
                            $result = mysqli_fetch_array(mysqli_query($db, $zap_0));
                            echo("<select name = 'lekarz' required><option value = '" . $result["id_lekarz"] . "'>" . $result["lekarz"] . "</option>");
                            $zap_1 = "select id_lekarz, concat(imie, space(1), nazwisko) as lekarz, specjalizacja from lekarze order by specjalizacja;";
                            $zap_2 = "select id_pacjent, concat(imie, space(1), nazwisko) as pacjent, pesel from pacjenci order by pacjent;";
                            $zap_3 = "select id_pacjent, concat(imie, space(1), nazwisko, space(1), '(', pesel, ')') as pacjent from pacjenci inner join wizyty using(id_pacjent) where id_wizyta = " . $_SESSION["id"] . ";";
                            $zap_4 = "select * from wizyty where id_wizyta = " . $_SESSION["id"] . ";";
                            $query_1 = mysqli_query($db, $zap_1);
                            $query_2 = mysqli_query($db, $zap_2);
                            $result_2 = mysqli_fetch_array(mysqli_query($db, $zap_3));
                            $result_3 = mysqli_fetch_array(mysqli_query($db, $zap_4));
                            $data = explode("-", $result_3["data"]);
                            $godz = explode(":", $result_3["godzina"]);
                            while ( $lekarz = mysqli_fetch_array($query_1) ) {
                                echo("<option value = '" . $lekarz["id_lekarz"] . "'>" . $lekarz["specjalizacja"] . " " . $lekarz["lekarz"] . "</option>");
                            }
                            echo("</select>");
                            echo("<select name = 'pacjent' required><option value = '" . $result_2["id_pacjent"] . "'>" . $result_2["pacjent"] . "</option>");
                            while ( $pacjent = mysqli_fetch_array($query_2) ) {
                                echo("<option value = '" . $pacjent["id_pacjenta"] . "'>" . $pacjent["pacjent"] . " (" . $pacjent["pesel"] . ")</option>");
                            }
                            if ( $result_3["prywatna"] == 1 ) {
                                echo("<input type = 'checkbox' name = 'prywatna' class = 'checkbox' checked/><p>Wizyta prywatna</p>");
                            } else {
                                echo("<input type = 'checkbox' name = 'prywatna' class = 'checkbox'/><p>Wizyta prywatna</p>");
                            }
                            if ( $result_3["zakonczona"] == 1 ) {
                                echo("<input type = 'checkbox' name = 'zak' class = 'checkbox' checked/><p>Zakończona</p>");
                            } else {
                                echo("<input type = 'checkbox' name = 'zak' class = 'checkbox'/><p>Zakończona</p>");
                            }
                            echo("<input type = 'text' name = 'rok' class = 'data' placeholder = 'Rok' pattern = '[0-9]{4}' required title = 'Rok (4 liczby)' style = 'margin-left: 32%;' value = '" . $data[0] . "'/>");
                            echo("<input type = 'text' name = 'mie' class = 'data' placeholder = 'Miesiąc' pattern = '[0-9]{1,2}' required title = 'Miesiąc (1-2 liczby)' value = '" . $data[1] . "'/>");
                            echo("<input type = 'text' name = 'dzi' class = 'data' placeholder = 'Dzień' pattern = '[0-9]{1,2}' required title = 'Dzien (1-2 liczby)' value = '" . $data[2] . "'/>");
                            echo("<input type = 'text' name = 'god' class = 'data' placeholder = 'Godzina' pattern = '[0-9]{1,2}' required title = 'Godzina (1-2 liczby)' style = 'margin-left: 37%;' value = '" . $godz[0] . "'/>");
                            echo("<input type = 'text' name = 'min' class = 'data' placeholder = 'Minuta' pattern = '[0-9]{1,2}' required title = 'Minuta (1-2 liczby)' value = '" . $godz[1] . "'/>");
                        } else if ( $_SESSION["edytuj"] == "LEKARZA" ) {
                            $zap = "select * from lekarze where id_lekarz = " . $_SESSION["id"] . ";";
                            $lekarz = mysqli_fetch_array(mysqli_query($db, $zap));
                            echo("<input type = 'text' maxlength = '20' class = 'lekarz' name = 'imie' placeholder = 'Imię' required style = 'margin-left: 9%;' value = '" . $lekarz["imie"] . "'/>");
                            echo("<input type = 'text' maxlength = '25' class = 'lekarz' name = 'nazwisko' placeholder = 'Nazwisko' required value = '" . $lekarz["nazwisko"] . "'/>");
                            echo("<input type = 'text' maxlength = '50' class = 'lekarz' name = 'specjalizacja' placeholder = 'Specjalizacja' required value = '" . $lekarz["specjalizacja"] . "'/>");
                            echo("<input type = 'text' class = 'kontakt' name = 'telefon' placeholder = 'Numer telefonu' pattern = '[0-9]{9}' title = 'Numer telefonu (9 cyfr)' required style = 'margin-left: 22%;' value = '" . $lekarz["nr_telefonu"] . "'/>");
                            echo('<input class = "kontakt" placeholder = "Adres e-mail" type = "email" name = "email" maxlength = "100" required pattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value = "' . $lekarz["email"] . '"/>');
                            echo("<input type = 'password' class = 'haslo' name = 'haslo' placeholder = 'Hasło' minlength = '8' required style = 'margin-left: 35%;'/><input type = 'checkbox' name = 'zmiana_hasla'/>");
                        } else if ( $_SESSION["edytuj"] == "GRAFIKU" ) {
                            $zap_0 = "select id_lekarz, concat(specjalizacja, space(1), imie, space(1), nazwisko) as lekarz from lekarze inner join grafik using(id_lekarz) where id_grafik = " . $_SESSION["id"] . ";";
                            $zap_1 = "select id_lekarz, concat(imie, space(1), nazwisko) as lekarz, specjalizacja from lekarze order by specjalizacja;";
                            $zap_2 = "select * from grafik where id_grafik = " . $_SESSION["id"] . ";";
                            $result = mysqli_fetch_array(mysqli_query($db, $zap_0));
                            $result_2 = mysqli_fetch_array(mysqli_query($db, $zap_2));
                            $query_1 = mysqli_query($db, $zap_1);
                            $godz_r = explode(":", $result_2["roz"]);
                            $godz_z = explode(":", $result_2["zak"]);
                            echo("<select name = 'lekarz' required style = 'margin-left: 26.5%'><option value = '" . $result["id_lekarz"] . "'>" . $result["lekarz"] . "</option>");
                            while ( $lekarz = mysqli_fetch_array($query_1) ) {
                                echo("<option value = '" . $lekarz["id_lekarz"] . "'>" . $lekarz["specjalizacja"] . " " . $lekarz["lekarz"] . "</option>");
                            }
                            echo("</select>");
                            echo("<input type = 'text' name = 'god_r' class = 'data' placeholder = 'Godzina rozpoczęcia' pattern = '[0-9]{1,2}' required title = 'Godzina (1-2 liczby)' style = 'margin-left: 37%;' value = '" . $godz_r[0] . "'/>");
                            echo("<input type = 'text' name = 'min_r' class = 'data' placeholder = 'Minuta rozpoczęcia' pattern = '[0-9]{1,2}' required title = 'Minuta (1-2 liczby)' value = '" . $godz_r[1] . "'/>");
                            echo("<input type = 'text' name = 'god_z' class = 'data' placeholder = 'Godzina zakończenia' pattern = '[0-9]{1,2}' required title = 'Godzina (1-2 liczby)' style = 'margin-left: 37%;' value = '" . $godz_z[0] . "'/>");
                            echo("<input type = 'text' name = 'min_z' class = 'data' placeholder = 'Minuta zakończenia' pattern = '[0-9]{1,2}' required title = 'Minuta (1-2 liczby)' value = '" . $godz_z[1] . "'/>");
                            echo("<input type = 'text' name = 'dni' class = 'data' minlength = '7' placeholder = 'Dni pracy' pattern = '[01]{7}' required title = '7 liczb (1 lub 0, gdzie 1 to dzień pracy, a 0 to dzień wolny, np. 1111100)' style = 'margin-left: 43%;' value = '" . $result_2["dni"] . "'/>");
                            echo("<input type = 'number' name = 'gabinet' class = 'data' minlength = '1' maxlength = '3' placeholder = 'Gabinet' required style = 'margin-left: 43%;' value = '" . $result_2["gabinet"] . "'/>");
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