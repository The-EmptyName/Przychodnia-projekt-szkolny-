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
        $db = mysqli_connect("localhost", "root", "", "przychodnia");
        if ($db) {
            $zap_1 = "select haslo from lekarze where email = '" . $_POST["email"] . "';";
            $zap_2 = "select haslo from pacjenci where email = '" . $_POST["email"] . "';";
            $zap_3 = "select haslo from administratorzy where email = '" . $_POST["email"] . "';";
            $query_1 = mysqli_query($db, $zap_1);
            $query_2 = mysqli_query($db, $zap_2);
            $query_3 = mysqli_query($db, $zap_3);
            $zalogowany = false;
            while ( $result_1 = mysqli_fetch_array($query_1) ) {
                if ( password_verify($_POST["haslo"], $result_1["haslo"]) ) {
                    $_SESSION["email"] = $_POST["email"];
                    $zalogowany = true;
                } else {
                    
                }
                
            }
            while ( $result_2 = mysqli_fetch_array($query_2) ) {
                if ( password_verify($_POST["haslo"], $result_2["haslo"]) ) {
                    $_SESSION["email"] = $_POST["email"];
                    $zalogowany = true;
                }
            }
            while ( $result_3 = mysqli_fetch_array($query_3) ) {
                if ( password_verify($_POST["haslo"], $result_3["haslo"]) ) {
                    $_SESSION["email"] = $_POST["email"];
                    $zalogowany = true;
                }
            }
            mysqli_close($db);
        }
        if ( $zalogowany ) {
            echo("<p id = 'p'>s</p>");
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