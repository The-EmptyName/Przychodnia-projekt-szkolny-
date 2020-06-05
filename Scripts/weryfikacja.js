"use strict";
var w = {
    haslo: function(element) {
        var haslo = element.value;
        var znaki = "!@#$%^&*";
        var liczby = "0123456789"
        var prawidlowe = 0;
        for ( var i = 0; i < haslo.length; i ++ ) {
            for ( var n = 0; n < znaki.length; n ++ ) {
                if ( haslo[i] == znaki[n] ) {
                    prawidlowe ++;
                    break;
                }
            }
            for ( var n = 0; n < liczby.length; n ++ ) {
                if ( haslo[i] == liczby[n] ) {
                    prawidlowe ++;
                    break;
                }
            }
        }
        if ( prawidlowe >= 2 ) {
            document.getElementById("s").click;
        }
        element.style.border = "1px solid red";
    }
}