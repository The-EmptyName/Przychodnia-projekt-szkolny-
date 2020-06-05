var data = {
    wyswietl: function() {
        var element = document.getElementsByClassName("footer")[0];
        var teraz = new Date();
        var godz = teraz.getHours();
        var min = teraz.getMinutes();
        var sek = teraz.getSeconds();
        if ( String(sek).length == 1 ) {
            sek = "0" + sek;
        }
        if ( String(min).length == 1 ) {
            min = "0" + min;
        }
        if ( String(godz).length == 1 ) {
            godz = "0" + godz;
        }
        element.innerText = godz + ":" + min + ":" + sek;
    },
    zacznij: function() {
        setInterval(data.wyswietl, 1000);
    }
}