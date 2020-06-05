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
        if ( $_SESSION["konto"] != "admin" && $_SESSION["konto"] != "lekarz" ) {
            echo("<p id = 'p'>u</p>");
        } else {
            $db = mysqli_connect("localhost", "root", "", "przychodnia");
            if ( $db ) {
                if ( $_SESSION["edytuj"] == "WIZYTY" ) {
                    if ( isset($_POST["prywatna"]) ) {
                        $prywatna = 1;
                    } else {
                        $prywatna = 0;
                    }
                    if ( isset($_POST["zakonczona"]) ) {
                        $zakonczona = 1;
                    } else {
                        $zakonczona = 0;
                    }
                    $zap = "update wizyty set id_lekarz = " . $_POST["lekarz"] . ", id_pacjent = " . $_POST["pacjent"] . ", prywatna = " . $prywatna . ", data = '" . $_POST["rok"] . "-" . $_POST["mie"] . "-" . $_POST["dzi"] . "', zakonczona = " . $zakonczona . ", godzina = '" . $_POST["god"] . ":" . $_POST["min"] . "' where id_wizyta = " . $_SESSION["id"] . ";";
                    mysqli_query($db, $zap);
                    echo("<p id = 'p'>w</p>");
                } else if ( $_SESSION["edytuj"] == "LEKARZA" ) {
                    $zap = "update lekarze set imie = '" . $_POST["imie"] . "', nazwisko = '" . $_POST["nazwisko"] . "', specjalizacja = '" . $_POST["specjalizacja"] . "', nr_telefonu = '" . $_POST["telefon"] . "', email = '" . $_POST["email"] . "' where id_lekarz = " . $_SESSION["id"] . ";";
                    if ( isset($_POST["zmiana_hasla"]) ) {
                        $zap_2 = "update lekarze set haslo = '" . password_hash($_POST["haslo"], PASSWORD_BCRYPT) . "' where id_lekarz = ". $_SESSION["id"] . ";";
                        mysqli_query($db, $zap_2);
                    }
                    mysqli_query($db, $zap);
                    echo("<p id = 'p'>l</p>");
                } else if ( $_SESSION["edytuj"] == "GRAFIKU" ) {
                    $zap = "update grafik set id_lekarz = " . $_POST["lekarz"] . ", roz = '" . $_POST["god_r"] . ":" . $_POST["min_r"] . "', zak = '" . $_POST["god_z"] . ":" . $_POST["min_z"] . "', dni = '" . $_POST["dni"] . "', gabinet = " . $_POST["gabinet"] . " where id_grafik = " . $_SESSION["id"] . ";";
                    mysqli_query($db, $zap);
                    echo("<p id = 'p'>g</p>");
                }
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
    } else if ( document.getElementById("p").innerHTML == "w" ) {
        window.location.href = "../wizyty_zarzadzanie_admin.php";
    } else if ( document.getElementById("p").innerHTML == "l" ) {
        window.location.href = "../lekarze_zarzadzanie.php";
    } else if ( document.getElementById("p").innerHTML == "g" ) {
        window.location.href = "../grafik_zarzadzanie.php";
    }
</script>