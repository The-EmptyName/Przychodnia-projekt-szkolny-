"use strict";
var blad = {
    kody: function() {
        var href = window.location.href.split("#");
        if ( href.length > 1 ) {
            href.shift();
            href = href[0].split("");
            return href;
        }
    },
    tekst: function(kod) {
        if ( kod == "h" ) {
            return "Hasło musi zawierać minimum 8 znaków, w tym przynajmniej jedną cyfrę i znak specjalny (np. !@#$%^&*?).\n";
        } else if ( kod == "p" ) {
            return "Istnieje już pacjent z podanym numerem PESEL.\n";
        } else if ( kod == "e" ) {
            return "Adres e-mail jest zajęty.\n";
        } else if ( kod == "b" ) {
            return "Wprowadzono błędne dane.\n";
        } else if ( kod == "l" ) {
            return "By zarządzać wizytami musisz się zalogować.\n";
        } else if ( kod == "u" ) {
            return "Twoje konto nie posiada odpowiednich uprawnień.\n";
        } else if ( kod == "d" ) {
            return "Rekord usunięty.\n";
        } else if ( kod == "z" ) {
            return "Wizyta zakończona.\n";
        } else if ( kod == "L" ) {
            return "Lekarz usunięty.\n";
        } else if ( kod == "g" ) {
            return "Wpis usunięty.\n";
        }
    },
    wypisz: function(kody) {
        if ( typeof(kody) == "undefined" ) {
            return false;
        }
        var do_wypisania = "";
        for ( var i = 0; i < kody.length; i ++ ) {
            do_wypisania += ((i + 1) +". " + this.tekst(kody[i]));
        }
        alert(do_wypisania);
    },
    wykonaj: function() {
        this.wypisz(this.kody());
    }
}