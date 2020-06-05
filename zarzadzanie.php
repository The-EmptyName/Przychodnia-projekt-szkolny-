<!DOCTYPE html>
<html>
    <head>
        <title>
            Zarządzanie
        </title>
        <meta charset = "UTF-8"/>
        <link rel = "stylesheet" href = "./styles/layout.css"/>
        <link rel = "stylesheet" href = "./styles/animacje.css"/>
        <link rel = "stylesheet" href = "./styles/dodawanie.css"/>
        <script src = "./scripts/animacja.js"></script>
        <script src = "./scripts/data.js"></script>
    </head>
    <body onload = "animacja.wczytaj(); data.zacznij()" class = "ruchome">
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
        <div class = "header_1">ZARZĄDZANIE</div>
        <div class = "header_2"><?php echo(strtoupper($_SESSION["konto"])); ?></div>
        <div class = "content">
            <?php
                if ( $_SESSION["konto"] == "admin" ) {
                    echo("<button><a href = './wizyty_zarzadzanie_admin.php'>Zarządzanie wizytami</a></button>");
                    echo("<button><a href = './lekarze_zarzadzanie.php'>Zarządzanie lekarzami (pracownikami)</a></button>");
                    echo("<button><a href = './grafik_zarzadzanie.php'>Zarządzanie grafikiem</a></button>");
                } else if ( $_SESSION["konto"] == "lekarz" ) {
                    echo("<button><a href = './wizyty_zarzadzanie_admin.php'>Zarządzanie wizytami</a></button>");
                    echo("<button><a href = './grafik_zarzadzanie.php'>Zarządzanie grafikiem</a></button>");
                } else {
                    $db = mysqli_connect("localhost", "root", "", "przychodnia");
                    if ( $db ) {
                        $zap = "select * from pacjenci where email = '" . $_SESSION["email"] . "';";
                        $result = mysqli_fetch_array(mysqli_query($db, $zap));
                        echo("<form method = 'post' action = './scripts/profil.php'>");
                        echo("<input type = 'text' maxlength = '20' class = 'lekarz' name = 'imie' placeholder = 'Imię' required style = 'margin-left: 9%;' value = '" . $result["imie"] . "'/>");
                        echo("<input type = 'text' maxlength = '25' class = 'lekarz' name = 'nazwisko' placeholder = 'Nazwisko' required value = '" . $result["nazwisko"] . "'/>");
                        echo("<input type = 'text' maxlength = '50' class = 'lekarz' name = 'pesel' placeholder = 'Specjalizacja' pattern = '[0-9]{11}' title = 'Numer pesel (11 cyfr)' required value = '" . $result["pesel"] . "'/>");
                        echo("<input type = 'text' maxlength = '20' class = 'lekarz' name = 'miasto' placeholder = 'Imię' required style = 'margin-left: 9%;' value = '" . $result["miasto"] . "'/>");
                        echo("<input type = 'text' maxlength = '25' class = 'lekarz' name = 'ulica' placeholder = 'Nazwisko' required value = '" . $result["ulica"] . "'/>");
                        echo("<input type = 'text' maxlength = '50' class = 'lekarz' name = 'nr_domu' placeholder = 'Specjalizacja' required value = '" . $result["nr_domu"] . "'/>");
                        echo("<input type = 'text' class = 'kontakt' name = 'telefon' placeholder = 'Numer telefonu' pattern = '[0-9]{9}' title = 'Numer telefonu (9 cyfr)' required style = 'margin-left: 22%;' value = '" . $result["nr_telefonu"] . "'/>");
                        echo('<input class = "kontakt" placeholder = "Adres e-mail" type = "email" name = "email" value = "' . $result["email"] . '" style = "opacity: 0.5; pointer-events: none;"/>');
                        echo("<input type = 'password' class = 'haslo' name = 'haslo' placeholder = 'Hasło' minlength = '8' required style = 'margin-left: 35%;'/><input type = 'checkbox' name = 'zmiana_hasla'/>");
                        echo("<input type = 'submit' class = 'submit'/>");
                        echo("<button><a href = './wizyty_historia.php'>Historia wizyt</a></button>");
                        echo("</form>");
                    } else {
                        echo("<h1 style = 'text-align: center;'>Błąd połączenia z bazą danych</h1>");
                    }
                    mysqli_close($db);
                }
            ?>
        </div>
        <div class = "empty" id = "empty_2"></div>
        <div class = "footer"><?php echo($_SESSION["email"]); ?></div>
    </body>
</html>