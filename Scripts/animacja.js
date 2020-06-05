var animacja = {
    rozwin_wizyty: function() {
        document.getElementsByTagName("body")[0].innerHTML += "<div class = 'wizyty_rozwijane' id = 'menu'></div>";
        document.getElementById("menu").innerHTML += "<div class = 'wizyty_pole'><a href = './zamawianie.php' id = '_1' style = 'animation: pokazanie 0.2s ease-in;' class = 'link'>ZAMÓW</a></div>";
        document.getElementById("menu").innerHTML += "<div class = 'wizyty_pole'><a href = './scripts/zarzadzanie.php' id = '_2' style = 'animation: pokazanie 0.2s ease-in 0.2s; opacity: 0;' class = 'link'>ZARZĄDZAJ</a></div>";
        setTimeout(function(){
            document.getElementById("_2").style.opacity = "1";
        }, 400);
        setTimeout(function(){
            animacja.zwin_wizyty();
        }, 3000);
    },
    zwin_wizyty: function() {
        var opacity = 1;
        document.getElementById("menu").style.pointerEvents = "none";
        var inter = setInterval(function(){
            opacity -= 0.04;
            try {
                document.getElementById("menu").style.opacity = opacity;
                if ( opacity <= 0 ) {
                    clearInterval(inter);
                    document.getElementById("menu").parentNode.removeChild(document.getElementById("menu"));
                }
            }
            catch (TypeError) {
                clearInterval(inter);
            }
        }, 10);
    },
    wczytaj: function() {
        var blur = 50;
        var html = document.getElementsByTagName("html")[0];
        var inter = setInterval(function(){
            if ( blur > 0 ) {
                html.style.filter = "blur(" + blur + "px)";
                blur --;
            } else {
                html.style.filter = "initial";
            }
        }, 1000/500)
    }
}