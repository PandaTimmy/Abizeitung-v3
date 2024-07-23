var createGroupOAusername = "";
var createGroupOApassword = "";
var gcrGroupTitle = "";
var gcrGroupInfo = "";
var gcrOAname = "";
var gcrGroupFacility = "";
var gcrGroupFacilityUUID = "";


function confirmAddGroupData() {
    
    var gruppenTitel = document.getElementById("group-add-title").value;
    var gruppenBeschreibung = document.getElementById("group-add-info").value;
    var oaVorname = document.getElementById("group-add-oa-first-name").value;
    var oaNachname = document.getElementById("group-add-oa-last-name").value;
    var oaEmail = document.getElementById("group-add-oa-email-address").value;

    var groupFacilityUUID = targetFacilityUUID;


    if(gruppenTitel == "" || gruppenBeschreibung == "" || oaVorname == "" || oaNachname == "" || oaEmail == "" ) {
        internAlert("Alle Felder müssen ausgefüllt sein")
    } else {
        customConfirm('Sicher, dass du die Gruppe "'+gruppenTitel+'" erstellen willst?', 'Gruppe Erstellen', 'Abbrechen', function(confirmed) {
            if (confirmed) {

                $.ajax({
                    type: "POST",
                    url: "hypertext-processor/group_create.php", // Hier den Pfad zu deinem PHP-Skript angeben
                    data: { groupTitle: gruppenTitel, groupInfo: gruppenBeschreibung, groupFacilityUUID: groupFacilityUUID, oaFirstName: oaVorname, oaLastName: oaNachname, oaContactEmail: oaEmail },
                    success: function(response) {
            
                        console.log(response);

                        response = response.split("<|>");
            
                        if(response[0] == "1") {
                            internAlert("Erfolgreich Gruppe erstellt");

                            createGroupOApassword = response[1];
                            createGroupOAusername = response[2];
                            gcrGroupTitle = gruppenTitel;
                            gcrGroupInfo = gruppenBeschreibung;
                            gcrOAname = oaVorname + " " + oaNachname;
                            gcrGroupFacility = targetFacilityName;
                            gcrGroupFacilityUUID = targetFacilityUUID;

                            navigate("group-create-result", "crossfade", false)

                        } else if(response[0] == "-1") {
                            internAlert("Fehler"+response[1]);

                        } else {

                            if(response[1] == "Interner Fehler") {
                                navigate("facility-select", "crossfade", false);
                            }
                            internAlert(response[1]);
                        }
                    },
                    error: function(error) {
                        
                        console.log(error);
            
                        internAlert(error);
            
                    }
                });

            } else {

            }
        });
    }
}

function displayData() {
    document.getElementById("display-facility-name").textContent = targetFacilityName;
    document.getElementById("display-facility-address").textContent = targetFacilityAddress;
}

function displayResults() {
    document.getElementById("gcr-group-title").textContent = gcrGroupTitle;
    document.getElementById("gcr-group-info").textContent = gcrGroupInfo;
    document.getElementById("gcr-group-owner").textContent = gcrOAname;
    document.getElementById("gcr-facility-name").textContent = gcrGroupFacility;
    document.getElementById("gcr-oa-username").textContent = createGroupOAusername;
    document.getElementById("gcr-oa-password").textContent = createGroupOApassword;
}