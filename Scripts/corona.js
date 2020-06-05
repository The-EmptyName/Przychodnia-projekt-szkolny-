var corona = {
    wyswielt: function() {
        setTimeout(function(){
            var dane;
            fetch("https://api.thevirustracker.com/free-api?countryTimeline=PL")
                .then( (resp) => resp.json() )
                .then( function(data) {
                    dane = data["timelineitems"][data["timelineitems"].length -1];
                    var przyp_1 = Object.values(dane)[Object.values(dane).length-2]["total_cases"];
            var przyp_2 = Object.values(dane)[Object.values(dane).length-2]["new_daily_cases"];
            var smier_1 = Object.values(dane)[Object.values(dane).length-2]["total_deaths"];
            var smier_2 = Object.values(dane)[Object.values(dane).length-2]["new_daily_deaths"];
            var rec = Object.values(dane)[Object.values(dane).length-2]["total_recoveries"];
            document.getElementById("info").innerText = "COVID-19 w Polsce: Zarażeni: " + przyp_1 + " (+" + przyp_2 + ") Śmierci: " + smier_1 + " (+" + smier_2 + ")";
            })},100);
    }
}