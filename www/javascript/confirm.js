function showConfirm() {

    var confirm = document.getElementById("confirm");
    var confirmContainer = document.getElementById("confirm-container");

    confirm.style.opacity = 0;
    confirm.style.display = "flex";
    confirmContainer.style.pointerEvents = "none";
    confirmContainer.style.transform = "scale(0.7)";

    setTimeout(function() {

        confirm.style.transition = "opacity .5s ease-in-out";
        confirm.style.opacity = 1;
        confirmContainer.style.transition = "all .6s cubic-bezier(.17,.67,.32,1)";
        confirmContainer.style.transform = "scale(1)";
        confirmContainer.style.opacity = 1;

    }, 10);

    setTimeout(function() {

        confirmContainer.style.pointerEvents = "all";    

    }, 500);

}

function hideConfirm() {

    var confirm = document.getElementById("confirm");
    var confirmContainer = document.getElementById("confirm-container");
    
    confirmContainer.style.pointerEvents = "none";

    setTimeout(function() {

        confirm.style.transition = "opacity .5s ease-in-out";
        confirm.style.opacity = 0;
        confirmContainer.style.transition = "all .3s cubic-bezier(.37,.2,.73,.51)";
        confirmContainer.style.transform = "scale(.6)";
        confirmContainer.style.opacity = 0;

    }, 10);

    setTimeout(function() {

        confirm.style.display = "none";
    

    }, 500);

}

function customConfirm(message, confirm, decline, callback) {
    // Dialog und Nachricht setzen
    var confirmTitle = document.getElementById('confirm-title');
    var confirmConfirm = document.getElementById('confirm-confirm');
    var confirmDecline = document.getElementById('confirm-decline');

    confirmTitle.textContent = message;
    confirmConfirm.textContent = confirm;
    confirmDecline.textContent = decline;
    
    showConfirm();

    // Funktionsdefinitionen für die Bestätigungslogik
    window.confirmYes = function() {
        hideConfirm();

        setTimeout(function() {

            callback(true);

        }, 500);

    }

    window.confirmNo = function() {
        hideConfirm();

        setTimeout(function() {

            callback(false);

        }, 500);
    }
}

// Beispiel für die Verwendung der customConfirm-Funktion
function handleDelete() {
    customConfirm("Sind Sie sicher, dass Sie löschen möchten?", "Ja", "Abbrechen", function(confirmed) {
        if (confirmed) {
            console.log("Benutzer hat gelöscht.");
            handleDelete();
            // Führe Logik zum Löschen hier durch
        } else {
            console.log("Benutzer hat das Löschen abgebrochen.");
        }
    });
}