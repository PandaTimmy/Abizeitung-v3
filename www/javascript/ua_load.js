function uaLoadAll() {

    $.ajax({
        type: "POST",
        url: "hypertext-processor/ua_load_all.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { },
        success: function(response) {

            console.log(response);

            response = response.split("<|>");

            if(response[0] == "1") {
                document.getElementById("ua-container").innerHTML = response[1];

            } else if (response[0] == "-1"){
                internAlert("Sitzung abgelaufen");
                navigate("facility-select", "crossfade", false);
            }
            else {
                internAlert("Fehler beim Laden der Benutzer");
                console.log(response);
            }
        },
        error: function(error) {
            
            console.log(error);

            internAlert(error);

        }
    });
}

function uaAdd() {

    var uaAddFirstName = document.getElementById("uaAddFirstName").value;
    var uaAddLastName = document.getElementById("uaAddLastName").value;

    $.ajax({
        type: "POST",
        url: "hypertext-processor/ua_add.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { uaAddFirstName: uaAddFirstName, uaAddLastName: uaAddLastName },
        success: function(response) {

            console.log(response);

            response = response.split("<|>");

            if(response[0] == "1") {
                internAlert("Erfolgreich Benutzerkonto erstellt");

                navigate("ua-overview", "crossfade", false)

            } else if(response[0] == "-1") {
                internAlert(response[1]);
                navigate("facility-select", "crossfade", false);

            } else if(response[0] == "0") {
                internAlert(response[1]);
            }
        },
        error: function(error) {
            
            console.log(error);

            internAlert(error);

        }
    });
}

var uauuidToLoad = "";

function uaLoad() {

    $.ajax({
        type: "POST",
        url: "hypertext-processor/ua_edit_load.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { uauuid: uauuidToLoad },
        success: function(response) {

            console.log(response);

            response = response.split("<|>");

            if(response[0] == "1") {
                document.getElementById("main").innerHTML = response[1];

            } else if (response[0] == "-1"){
                internAlert("Sitzung abgelaufen");
                navigate("facility-select", "crossfade", false);
            }
            else {
                internAlert(response[1]);
                console.log(response);
            }
        },
        error: function(error) {
            
            console.log(error);

            internAlert(error);

        }
    });
}