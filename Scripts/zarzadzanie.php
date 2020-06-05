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
        if ( $_SESSION["konto"] == "brak" ) {
            echo("<p id = 'p'>l</p>");
        } else if ( $_SESSION["konto"] == "pacjent" ) {
            echo("<p id = 'p'>P</p>");
        } else if ( $_SESSION["konto"] == "lekarz" ) {
            echo("<p id = 'p'>L</p>");
        } else if ( $_SESSION["konto"] == "admin" ) {
            echo("<p id = 'p'>A</p>");
        }
    ?>
</body>
<script>
    if ( document.getElementById("p").innerHTML == "l" ) {
        window.location.href = "../logowanie.php#l";
    } else if ( document.getElementById("p").innerHTML == "P" ) {
        window.location.href = "../wizyty_historia.php";
    } else if ( document.getElementById("p").innerHTML == "L" ) {
        window.location.href = "../wizyty_zarzadzanie_admin.php";
    } else if ( document.getElementById("p").innerHTML == "A" ) {
        window.location.href = "../wizyty_zarzadzanie_admin.php";
    }
    
</script>