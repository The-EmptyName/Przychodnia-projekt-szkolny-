<!DOCTYPE html>
<html>
    <head>
        <title>
            Logowanie
        </title>
        <meta charset = "UTF-8"/>
        <link rel = "stylesheet" href = "./styles/layout.css"/>
        <link rel = "stylesheet" href = "./styles/logowanie.css"/>
        <link rel = "stylesheet" href = "./styles/animacje.css"/>
        <script src = "./scripts/animacja.js"></script>
        <script src = "./scripts/blad.js"></script>
        <script src = "./scripts/data.js"></script>
    </head>
    <body onload = "animacja.wczytaj(); blad.wykonaj(); data.zacznij()" class = "ruchome">
        <div class = "top">
            <a href = "./index.php"><img src = "./images/logo_2.png" alt = "Przeglądarka nie obsługuje elementu." class = "logo"/></a>
            <div class = "link_container"><a onclick = "animacja.rozwin_wizyty()" class = "link">WIZYTY</a></div>
            <div class = "link_container"><a href = "./kontakt.php" class = "link">KONTAKT</a></div>
            <div class = "link_container"><a href = "./lekarze.php" class = "link">LEKARZE</a></div>
            <div class = "link_container"><a href = "./ofirmie.php" class = "link">O FIRMIE</a></div>
        </div>
        <div class = "empty" id = "empty_1"></div>
        <div class = "header_1">Zaloguj się lub zarejestruj nowe konto pacjenta</div>
        <div class = "header_2"></div>
        <div class = "content">
            <div class = "form">
                <div class = "header_3">
                    Rejestracja
                </div>
                <form class = "rejestracja_form" action = "./scripts/rejestracja.php" method = "post">
                    <input class = "rejestracja_input" placeholder = "Imię" type = "text" name = "imie" maxlength = "20" required/>
                    <input class = "rejestracja_input" placeholder = "Nazwisko" type = "text" name = "nazwisko" maxlength = "25" required/>
                    <input class = "rejestracja_input" placeholder = "PESEL" type = "number" name = "pesel" min = "10000000000" max = "99999999999" required/>
                    <input class = "rejestracja_input" placeholder = "Miasto" type = "text" name = "miasto" maxlength = "50" required/>
                    <input class = "rejestracja_input" placeholder = "Ulica" type = "text" name = "ulica" maxlength = "50" required/>
                    <input class = "rejestracja_input" placeholder = "Numer domu" type = "text" name = "dom" maxlength = "10" required/>
                    <input class = "rejestracja_input" placeholder = "Numer telefonu" type = "number" name = "telefon" min = "100000000" max = "999999999" required/>
                    <input class = "rejestracja_input" placeholder = "Adres e-mail" type = "email" name = "email" maxlength = "100" required pattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/>
                    <input class = "rejestracja_input" placeholder = "Hasło" type = "password" name = "haslo" maxlength = "50" minlength = "8" required/>
                    <input class = "rejestracja_input przycisk" type = "submit" value = "Utwórz konto"/>
                    <input class = "rejestracja_input przycisk" type = "reset" value = "Usuń dane"/>
                </form>
            </div>
            <div class = "rozdzielacz"></div>
            <div class = "form">
                <div class = "header_3">
                    Logowanie
                </div>
                <form class = "rejestracja_form" action = "./scripts/logowanie.php" method = "post">
                    <input class = "logowanie_input" placeholder = "Adres e-mail" type = "email" name = "email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/>
                    <input class = "logowanie_input" placeholder = "Hasło" type = "password" name = "haslo" title = "Pole musi zawierać minimum 8 znaków, w tym przynajmniej jedną cyfrę i znak specjalny (np. !@#$%^&*?)."/>
                    <input class = "logowanie_input przycisk" type = "submit" value = "Zaloguj"/>
                    <input class = "logowanie_input przycisk" type = "reset" value = "Usuń dane"/>
                </form>
            </div>
        </div>
        <div class = "empty" id = "empty_2"></div>
        <div class = "footer"></div>
    </body>
</html>