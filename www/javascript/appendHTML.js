function appendHTML(file) {
    document.getElementById("transition-main").innerHTML = '<div class="loadbar"></div>';

    var xhr = new XMLHttpRequest();
    xhr.open('GET', "views/"+file, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            setTimeout(function() {

                loadComplete = true;

                if(transitionComplete) {
                    document.getElementById("main").innerHTML = xhr.responseText;
                    removeChildIds(document.getElementById("transition-main"));

                    applyAutoResize();
                    afterHTMLloadFunction();
                } else {
                    document.getElementById("transition-main").innerHTML = xhr.responseText;
                }

            }, 0);

        } else {

            // error

            loadComplete = true;

            if(transitionComplete) {
                document.getElementById("main").innerHTML = 'Die Anfrage war nicht erfolgreich. Fehlercode: ' + xhr.status;
                removeChildIds(document.getElementById("transition-main"));

            } else {
                document.getElementById("transition-main").innerHTML = 'Die Anfrage war nicht erfolgreich. Fehlercode: ' + xhr.status;
            }
        }
    };

    xhr.send();

}
