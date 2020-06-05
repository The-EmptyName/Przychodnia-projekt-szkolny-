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
                if ( isset($_POST["u"]) ) {
                    $zap = "delete from grafik where id_grafik = " . $_POST["grafik"] . ";";
                    mysqli_query($db, $zap);
                    echo("<p id = 'p'>L</p>");
                }
                if ( isset($_POST["d"]) ) {
                    $_SESSION["dodaj"] = "GRAFIKU";
                    echo("<p id = 'p'>d</p>");
                }
                if ( isset($_POST["e"]) ) {
                    $_SESSION["edytuj"] = "GRAFIKU";
                    $_SESSION["id"] = $_POST["grafik"];
                    echo("<p id = 'p'>e</p>");
                }
                mysqli_close($db);
            }
        }
    ?>
</body>
<script>
    if ( document.getElementById("p").innerHTML == "u" ) {
        window.location.href = "../grafik_zarzadzanie.php#u";
    } else if ( document.getElementById("p").innerHTML == "L" ) {
        window.location.href = "../grafik_zarzadzanie.php#g";
    } else if ( document.getElementById("p").innerHTML == "d" ) {
        window.location.href = "../dodawanie.php";
    } else if ( document.getElementById("p").innerHTML == "e" ) {
        window.location.href = "../edytowanie.php";
    }
</script>