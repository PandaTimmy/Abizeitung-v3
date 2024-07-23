var schoolNames = [];
var schoolAdresses = [];
var schoolUUIDs = [];

var targetFacilityName = "";
var targetFacilityAddress = "";
var targetFacilityUUID = "";

function initializeSchoolSearch() {
    var searchBoxSchools = document.getElementById("search-results-school");
    searchBoxSchools.innerHTML = "";

    var htmlquery = "";

    var searchBoxSearching = document.getElementById("searchBoxSchools").value.toLowerCase();

    let results = 0;

    for (let i = 0; i < schoolNames.length; i++) {

        let searchContent = schoolNames[i] + " " + schoolAdresses[i];

        searchContent = searchContent.toLowerCase().split(/[\s\-_]+/);
        searchContent.push(schoolNames[i].toLowerCase());
        searchContent.push(schoolAdresses[i].toLowerCase());

        if(searchContent.some(element => element.includes(searchBoxSearching))) {

            results++;

            htmlquery += '<div class="button-icon" onmouseup="targetFacilityName = \''+schoolNames[i]+'\'; targetFacilityAddress = \''+schoolAdresses[i]+'\'; targetFacilityUUID = \''+schoolUUIDs[i]+'\'; navigate(\'group-select\', \'crossfade\', false);"><div class="button-textcontent" style="padding-left: 0;"><div class="button-title">' + schoolNames[i] + '</div><div class="button-subtitle">' + schoolAdresses[i] + '</div></div></div>'

        }
    }

    if (results === 0) {
        htmlquery = '<div class="button-icon" ><div class="button-textcontent" style="padding-left: 0;"><div class="button-title">Keine Einrichtung gefunden</div><div class="button-subtitle">Füge eine neue Einrichtung hinzu!</div></div></div>'+'<div class="space74"></div><div class="default-button" onclick="internAlert(\'Funktion noch nicht verfügbar\')">Einrichtung hinzufügen</div>'
    } else {
        htmlquery = "<div class='button-icon-container'>" + htmlquery + "</div>";
    }

    searchBoxSchools.innerHTML = htmlquery;

}


function loadFacilities() {



    $.ajax({
        type: "POST",
        url: "hypertext-processor/facilities_load.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: {  },
        success: function(response) {

            response = response.split("<|>").slice(0, -1);

            schoolNames = [];
            schoolAdresses = [];
            schoolUUIDs = [];

            for (let i = 0; i < response.length; i++) {

                elements = response[i].split("<¦>");

                schoolNames.push(elements[0]);
                schoolAdresses.push(elements[1]);
                schoolUUIDs.push(elements[2]);
            }

            initializeSchoolSearch();

        },
        error: function(error) {
            
            console.log(error);
        }
    });

}
