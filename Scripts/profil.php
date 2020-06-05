<style>
    body {
        height: 100%;
        animation: ladowanie 2s infinite;
    }
    #p {
        visibility: hidden;
    }
    @keyframes ladowanie {
        0% {
            background-color: rgb(178, 236, 178);
        }
        50% {
            background-color: rgb(47, 236, 47);
        }
        100% {
            background-color: rgb(178, 236, 178);
        }
    }
</style>
<body>
    <?php
        session_start();
        if ( $_SESSION["konto"] != "pacjent" ) {
            echo("<p id = 'p'>u</p>");
        } else {
            $db = mysqli_connect("localhost", "root", "", "przychodnia");
            if ( $db ) {
                $zap = "update pacjenci set imie = '" . $_POST["imie"] . "', nazwisko = '" . $_POST["nazwisko"] . "', pesel = '" . $_POST["pesel"] . "', miasto = '" . $_POST["miasto"] . "', ulica = '" . $_POST["ulica"] . "', nr_domu = '" . $_POST["nr_domu"] . "', nr_telefonu = '" . $_POST["telefon"] . "' where email = '" . $_SESSION["email"] . "';";
                if ( isset($_POST["zmiana_hasla"]) ) {
                    $zap_2 = "update pacjenci set haslo = '" . password_hash($_POST["haslo"], PASSWORD_BCRYPT) . "' where email = '". $_SESSION["email"] . "';";
                    mysqli_query($db, $zap_2);
                }
                mysqli_query($db, $zap);
                echo("<p id = 'p'>l</p>");
                mysqli_close($db);
            }
        }
        unset($_SESSION["id"]);
        unset($_SESSION["edytuj"]);
    ?>
</body>
<script>
    if ( document.getElementById("p").innerHTML == "u" ) {
        window.location.href = "../logowanie.php#u";
    } else if ( document.getElementById("p").innerHTML == "l" ) {
        window.location.href = "../zarzadzanie.php";
    }
</script>