var groupTitles = [];
var groupInfos = [];
var groupUUIDs = [];

var targetGroupUUID = "";

function loadGroups() {

    groupTitles = [];
    groupInfos = [];
    groupUUIDs = [];

    $.ajax({
        type: "POST",
        url: "hypertext-processor/groups_load.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { targetFacilityUUID: targetFacilityUUID },
        success: function(response) {

            console.log(response);

            response = response.split("<|>").slice(0, -1);


            for (let i = 0; i < response.length; i++) {

                elements = response[i].split("<¦>");

                groupTitles.push(elements[0]);
                groupInfos.push(elements[1]);
                groupUUIDs.push(elements[2]);
            }

            showGroupLoadResults();

        },
        error: function(error) {
            
            console.log(error);
        }
    });

}

function showGroupLoadResults() {
    var groupLoadResults = document.getElementById("groupLoadResults");
    groupLoadResults.innerHTML = "";

    var results = 0;

    for (let i = 0; i < groupTitles.length; i++) {

        results++;
        groupLoadResults.innerHTML += '<div class="button-icon" onmouseup="targetGroupUUID = \''+groupUUIDs[i]+'\'; navigate(\'login\', \'crossfade\', true);"><img class="button-image" src="images/icons/group_selected.svg" alt=""><div class="button-textcontent"><div class="button-title">' + groupTitles[i] + '</div><div class="button-subtitle">' + groupInfos[i] + '</div></div></div>'

    }

    if (results === 0) {
        groupLoadResults.innerHTML += '<div class="button-icon" ><div class="button-textcontent" style="padding-left: 0;"><div class="button-title">Keine Gruppe gefunden</div><div class="button-subtitle">Füge eine neue Gruppe hinzu!</div></div></div>'

    }

}