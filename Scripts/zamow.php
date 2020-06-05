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
                $zap_0 = "select id_pacjent from pacjenci where email = '" . $_SESSION["email"] . "';";
                $result = mysqli_fetch_array(mysqli_query($db, $zap_0));
                $zap = "insert into wizyty(id_lekarz, id_pacjent, prywatna, data, godzina) values(" . $_POST["lekarz"] . ", " . $result["id_pacjent"] . ", " . $_POST["prywatna"] . ", '" . $_POST["rok"] . "-" . $_POST["mie"] . "-" . $_POST["dzi"] . "', '" . $_POST["god"] . ":" . $_POST["min"] . "');";
                echo($zap);
                mysqli_query($db, $zap);
                echo("<p id = 'p'>w</p>");
            }
            mysqli_close($db);
        }
    ?>
</body>
<script>
    if ( document.getElementById("p").innerHTML == "u" ) {
        window.location.href = "../logowanie.php#u";
    } else if ( document.getElementById("p").innerHTML == "w" ) {
        window.location.href = "../wizyty_historia.php";
    }
</script>