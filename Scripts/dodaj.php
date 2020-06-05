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
                if ( $_SESSION["dodaj"] == "WIZYTY" ) {
                    if ( isset($_POST["prywatna"]) ) {
                        $prywatna = 1;
                    } else {
                        $prywatna = 0;
                    }
                    echo($_SESSION["dodaj"]);
                    $zap = "insert into wizyty(id_lekarz, id_pacjent, prywatna, data, godzina) values(" . $_POST["lekarz"] . ", " . $_POST["pacjent"] . ", " . $prywatna . ", '" . $_POST["rok"] . "-" . $_POST["mie"] . "-" . $_POST["dzi"] . "', '" . $_POST["god"] . ":" . $_POST["min"] . "');";
                    mysqli_query($db, $zap);
                    echo("<p id = 'p'>w</p>");
                } else if ( $_SESSION["dodaj"] == "LEKARZA" ) {
                    $zap = "insert into lekarze(imie, nazwisko, specjalizacja, nr_telefonu, email, haslo) values('" . $_POST["imie"] . "', '" . $_POST["nazwisko"] . "', '" . $_POST["specjalizacja"] . "', '" . $_POST["telefon"] . "', '" . $_POST["email"] . "', '" . password_hash($_POST["haslo"], PASSWORD_BCRYPT) . "');";
                    echo($zap);
                    mysqli_query($db, $zap);
                    echo("<p id = 'p'>l</p>");
                } else if ( $_SESSION["dodaj"] == "GRAFIKU" ) {
                    $zap = "insert into grafik(id_lekarz, roz, zak, dni, gabinet) values(" . $_POST["lekarz"] . ", '" . $_POST["god_r"] . ":" . $_POST["min_r"] . "', '" . $_POST["god_z"] . ":" . $_POST["min_z"] . "', '" . $_POST["dni"] . "', " . $_POST["gabinet"] . ");";
                    mysqli_query($db, $zap);
                    echo("<p id = 'p'>g</p>");
                }
                mysqli_close($db);
            }
        }
        unset($_SESSION["dodaj"]);
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