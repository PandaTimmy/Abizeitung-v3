function appendAdminHTML(file) {
    document.getElementById("transition-main").innerHTML = '<h3>Lädt...</h3>';


    $.ajax({
        type: "POST",
        url: "hypertext-processor/views/"+file+".php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: {  },
        success: function(response) {

            console.log(response);

            loadComplete = true;

            if(transitionComplete) {
                document.getElementById("main").innerHTML = response;
                removeChildIds(document.getElementById("transition-main"));

                applyAutoResize();
            } else {
                document.getElementById("transition-main").innerHTML = response;
            }

        },
        error: function(error) {
            
            console.log(error);

            loadComplete = true;

            if(transitionComplete) {
                document.getElementById("main").innerHTML = 'Die Anfrage war nicht erfolgreich. Fehlercode: ' + error;
                removeChildIds(document.getElementById("transition-main"));

            } else {
                document.getElementById("transition-main").innerHTML = 'Die Anfrage war nicht erfolgreich. Fehlercode: ' + error;
            }
        }
    });
}
