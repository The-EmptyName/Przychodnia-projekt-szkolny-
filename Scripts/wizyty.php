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
            if ( $_SESSION["konto"] != "pacjent" ) {
                echo("<p id = 'p'>u</p>");
            } else {
                $db = mysqli_connect("localhost", "root", "", "przychodnia");
                $zap = "update wizyty set zakonczona = 1 where id_wizyta = " . $_POST["wizyta"] . ";";
                mysqli_query($db, $zap);
                echo("<p id = 'p'>o</p>");
                mysqli_close($db);
            }
        } else {
            $db = mysqli_connect("localhost", "root", "", "przychodnia");
            if ( $db ) {
                if ( isset($_POST["u"]) ) {
                    $zap = "update wizyty set zakonczona = 1 where id_wizyta = " . $_POST["wizyta"] . ";";
                    mysqli_query($db, $zap);
                    echo("<p id = 'p'>z</p>");
                }
                if ( isset($_POST["d"]) ) {
                    $_SESSION["dodaj"] = "WIZYTY";
                    echo("<p id = 'p'>d</p>");
                }
                if ( isset($_POST["e"]) ) {
                    $_SESSION["edytuj"] = "WIZYTY";
                    $_SESSION["id"] = $_POST["wizyta"];
                    echo("<p id = 'p'>e</p>");
                }
                mysqli_close($db);
            }
        }
    ?>
</body>
<script>
    if ( document.getElementById("p").innerHTML == "u" ) {
        window.location.href = "../wizyty_zarzadzanie_admin.php#u";
    } else if ( document.getElementById("p").innerHTML == "z" ) {
        window.location.href = "../wizyty_zarzadzanie_admin.php#z";
    } else if ( document.getElementById("p").innerHTML == "d" ) {
        window.location.href = "../dodawanie.php";
    } else if ( document.getElementById("p").innerHTML == "e" ) {
        window.location.href = "../edytowanie.php";
    } else if ( document.getElementById("p").innerHTML == "o" ) {
        window.location.href = "../wizyty_historia.php#z";
    }
</script>