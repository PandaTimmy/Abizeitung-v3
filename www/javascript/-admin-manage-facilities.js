function saveFacilityEdits(facilityUUID) {

    var facilityName = document.getElementById("-admin-manage-facility-name").value;
    var facilityAddress = document.getElementById("-admin-manage-facility-address").value;

    $.ajax({
        type: "POST",
        url: "hypertext-processor/facility_update.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { facilityName: facilityName, facilityAddress: facilityAddress, facilityUUID: facilityUUID },
        success: function(response) {

            console.log(response);

            if(response == "1") {
                internAlert("Änderungen gespeichert");
            } else if(response == "-1") {
                internAlert("Sitzung Abgelaufen");
                navigate("admin-login", "crossfade", false);
            } else {
                internAlert("Speichern fehlgeschlagen");
            }
        },
        error: function(error) {
            
            console.log(error);

            internAlert(error);

        }
    });
}

function addFacility() {
    var facilityName = document.getElementById("-admin-add-facility-name").value;
    var facilityAddress = document.getElementById("-admin-add-facility-address").value;

    $.ajax({
        type: "POST",
        url: "hypertext-processor/facility_add.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { facilityName: facilityName, facilityAddress: facilityAddress },
        success: function(response) {

            console.log(response);

            if(response == "1") {
                internAlert("Einrichtung erstellt");
                navigate("-admin-facilities-overview", "crossfade", false);

            } else if(response == "-1") {
                internAlert("Sitzung Abgelaufen");
                navigate("admin-login", "crossfade", false);
            } else {
                internAlert("Erstellen fehlgeschlagen");
            }
        },
        error: function(error) {
            
            console.log(error);

            internAlert(error);

        }
    });
}


function deleteFacility(facilityUUID) {

    $.ajax({
        type: "POST",
        url: "hypertext-processor/facility_delete.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { facilityUUID: facilityUUID },
        success: function(response) {

            console.log(response);

            if(response == "1") {
                internAlert("Einrichtung gelöscht");
                navigate("-admin-facilities-overview", "crossfade", false);

            } else if(response == "-1") {
                internAlert("Sitzung Abgelaufen");
                navigate("admin-login", "crossfade", false);
            } else {
                internAlert("Löschen fehlgeschlagen");
            }
        },
        error: function(error) {
            
            console.log(error);

            internAlert(error);

        }
    });
}