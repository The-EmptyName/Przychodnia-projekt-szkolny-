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
        $db = mysqli_connect("localhost", "root", "", "przychodnia");
        if ($db) {
            $imie = $_POST["imie"];
            $nazwisko = $_POST["nazwisko"];
            $pesel = $_POST["pesel"];
            $miasto = $_POST["miasto"];
            $ulica = $_POST["ulica"];
            $dom = $_POST["dom"];
            $telefon = $_POST["telefon"];
            $email = $_POST["email"];
            $haslo = $_POST["haslo"];
            $h = str_split($haslo);
            $znaki = ["!", "@", "#", "$", "%" ,"^", "&", "*"];
            $liczby = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
            $z = false;
            $l = false;
            $p = true;
            $e = true;
            $zap_1 = "select pesel, email from pacjenci;";
            $zap_2 = "select email from lekarze;";
            $zap_2 = "select email from administratorzy;";
            $query_1 = mysqli_query($db, $zap_1);
            $query_2 = mysqli_query($db, $zap_2);
            $query_3 = mysqli_query($db, $zap_3);
            while ( $result_1 = mysqli_fetch_array($query_1) ) {
                if ( $result_1["email"] == $email ) {
                    $e = false;
                }
                if ( $result_1["pesel"] == $pesel ) {
                    $p = false;
                }
            }
            while ( $result_2 = mysqli_fetch_array($query_2) ) {
                if ( $result_2["email"] == $email ) {
                    $e = false;
                }
            }
            while ( $result_3 = mysqli_fetch_array($query_3) ) {
                if ( $result_3["email"] == $email ) {
                    $e = false;
                }
            }
            for ( $i = 0; $i < count($h); $i ++ ) {
                for ( $n = 0; $n < count($znaki); $n ++ ) {
                    if ( $h[$i] == $znaki[$n] ) {
                        $z = true;
                    }
                }
                for ( $n = 0; $n < count($liczby); $n ++ ) {
                    if ( $h[$i] == $liczby[$n] ) {
                        $l = true;
                    }
                }
            }
            if ( $z && $l && $p && $e ) {
                $haslo = password_hash($_POST["haslo"], PASSWORD_BCRYPT);
                $zap = "insert into pacjenci(imie, nazwisko, pesel, nr_telefonu, email, haslo, miasto, ulica, nr_domu) values('" . $imie . "', '" . $nazwisko . "', " . $pesel . ", " . $telefon . ", '" . $email . "', '" . $haslo . "', '" . $miasto . "', '" . $ulica . "', '" . $dom . "');";
                mysqli_query($db, $zap);
                echo("<p id = 'p'>s</p>");
            } else {
                $do_p = "";
                if ( !$z || !$l ) {
                    $do_p = $do_p . "h";
                }
                if ( !$p ) {
                    $do_p = $do_p . "p";
                }
                if ( !$e ) {
                    $do_p = $do_p . "e";
                }
                echo("<p id = 'p'>" . $do_p . "</p>");
            }
            mysqli_close($db);
        } else {
            echo("<p id = 'p'>b</p>");
        }
    ?>
</body>
<script>
    if ( document.getElementById("p").innerHTML == "s" ) {
        window.location.href = "../index.php";
    } else {
        window.location.href = "../logowanie.php#" + document.getElementById("p").innerHTML;
    }
</script>