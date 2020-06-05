<!DOCTYPE html>
<html>
    <head>
        <title>
            Lekarze
        </title>
        <meta charset = "UTF-8"/>
        <link rel = "stylesheet" href = "./styles/layout.css"/>
        <link rel = "stylesheet" href = "./styles/lekarze.css"/>
        <link rel = "stylesheet" href = "./styles/animacje.css"/>
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
        <div class = "header_1">LEKARZE</div>
        <div class = "header_2">Grafik dla poszczególnych lekarzy</div>
        <div class = "content">
            <div class = "grafik">
                <div class = "wpis">
                    <div class = "pole">
                        <b>Imię</b>
                    </div>
                    <div class = "pole">
                        <b>Nazwisko</b>
                    </div>
                    <div class = "pole">
                        <b>Specjalizacja</b>
                    </div>
                    <div class = "pole">
                        <b>Gabinet</b>
                    </div>
                    <div class = "pole">
                        <b>Dni pracy</b>
                    </div>
                    <div class = "pole">
                        <b>Godzina rozpoczęcia</b>
                    </div>
                    <div class = "pole">
                        <b>Godzina zakończenia</b>
                    </div>
                </div>
                <?php
                    $db = mysqli_connect("localhost", "root", "", "przychodnia");
                    if ( $db ) {
                        $zap = "select grafik.roz, grafik.zak, grafik.dni, grafik.gabinet, lekarze.imie, lekarze.nazwisko, lekarze.specjalizacja from grafik inner join lekarze using(id_lekarz);";
                        $query = mysqli_query($db, $zap);
                        while ( $result = mysqli_fetch_array($query) ) {
                            echo('<div class = "wpis"><div class = "pole">' . $result["imie"] . '</div>');
                            echo('<div class = "pole">' . $result["nazwisko"] . '</div>');
                            echo('<div class = "pole">' . $result["specjalizacja"] . '</div>');
                            echo('<div class = "pole">' . $result["gabinet"] . '</div>');
                            $dni = str_split($result["dni"]);
                            $tydzien = ["pon.", "wt.", "śr.", "czw.", "pt.", "sob.", "niedz."];
                            $wypisz = "";
                            for ( $i = 0; $i < count($dni); $i ++ ) {
                                if ( $dni[$i] == 1 ) {
                                    $wypisz = $wypisz . $tydzien[$i] . " ";
                                }
                            }
                            echo('<div class = "pole">' . $wypisz . '</div>');
                            echo('<div class = "pole">' . $result["roz"] . '</div>');
                            echo('<div class = "pole">' . $result["zak"] . '</div></div>');
                        }
                        mysqli_close($db);
                    }
                ?>
            </div>
        </div>
        <div class = "empty" id = "empty_2"></div>
        <div class = "footer"><?php echo($_SESSION["email"]); ?></div>
    </body>
</html>