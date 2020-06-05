<!DOCTYPE html>
<html>
    <head>
        <title>
            Strona główna
        </title>
        <meta charset = "UTF-8"/>
        <link rel = "stylesheet" href = "./styles/layout.css"/>
        <link rel = "stylesheet" href = "./styles/animacje.css"/>
        <script src = "./scripts/animacja.js"></script>
        <script src = "./scripts/data.js"></script>
        <script src = "./scripts/corona.js"></script>
    </head>
    <body onload = "animacja.wczytaj(); data.zacznij(); corona.wyswielt()" class = "ruchome">
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
        <div class = "header_1">Witamy na oficjalnej stronie naszej przychodni!</div>
        <div class = "header_2"></div>
        <div class = "content">
            <marquee style = "background-color: rgba(0, 0, 0, 0); color: red;" behavior = "scroll" direction = "left" loop = "" id = "info"></marquee>
            <div class = "harold"></div>
			<div class = "text" style = "width: 60%;">
                <div style = "font-size: 140%; margin-top: 4.75%;"><b>Doświadczona opieka zdrowotna, jak i wysoki standard udzielanych świadczeń zdrowotnych jest wynikiem połączenia dużych umiejętności kadry medycznej oraz osobistego podejścia do każdego pacjenta.<br><br> To właśnie zaufanie ze strony pacjenta ma dla nas największą wartość. Czujemy obowiązek do zapewnienia opieki medycznej na najwyższym szczeblu - nasza poradnia to zespół lekarzy z wieloletnim doświadczeniem.<br><br> Dzięki pełnemu profesjonalizmowi, doskonale wykwalifikowanej kadrze oraz świetnej organizacji pracy, nasza przychodnia lekarska jest jednym z wiodących centrów medyczno-diagnostycznych w Polsce.<br><br>Oferujemy wysoką jakość obrazowania cyfrowego RTG i USG przy zachowaniu najwyższych standardów bezpieczeństwa Pacjenta.</b></div>
			</div>
        </div>
        <div class = "empty" id = "empty_2"></div>
            <div class = "footer"></div>
    </body>
</html>