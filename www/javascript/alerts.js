var alerts = [];
var ongoingAlert = false;

function internAlert(prompt) {

    if (prompt != "___no_alert___") {
        alerts.push(prompt);
    }

    if (!ongoingAlert) {

        ongoingAlert = true;
        
        document.getElementById("alert-message").textContent = alerts[0];
        showAlert();

        setTimeout(function() {

            hideAlert();
            alerts.shift();

            setTimeout(function() {

                ongoingAlert = false;

                if (alerts.length > 0) {

                    internAlert("___no_alert___");
                }

            }, 410);
    
        }, 2500);
    }
}

function showAlert() {

    console.log("Displaying Alert!");

    document.getElementById("alert-container").style.display = "flex";
    document.getElementById("alert-container").style.transition = "all .0s cubic-bezier(.69,-0.01,.23,.98)";
    document.getElementById("alert-message").style.transition = "all .0s cubic-bezier(.69,-0.01,.23,.98)";
    document.getElementById("alert-container").style.opacity = 0;
    document.getElementById("alert-container").style.maxHeight = "none";
    document.getElementById("alert-container").style.maxWidth = "none";
    document.getElementById("alert-container").style.height = "auto";
    document.getElementById("alert-container").style.width = "auto";
    document.getElementById("alert-message").style.paddingRight = "18px";
    document.getElementById("alert-message").style.minHeight = "min-content";
    document.getElementById("alert-message").style.minWidth = "min-content";
    document.getElementById("alert-message").style.height = "auto";
    document.getElementById("alert-message").style.width = "auto";

    var computedStyleContainer = window.getComputedStyle(document.getElementById("alert-container"));
    var computedStyleMessage = window.getComputedStyle(document.getElementById("alert-message"));

    const containerWidth = computedStyleContainer.width;
    const containerHeight = computedStyleContainer.height;

    const messageWidth = computedStyleMessage.width;
    const messageHeight = computedStyleMessage.height;
        
    document.getElementById("alert-container").style.maxWidth = "60px";
    document.getElementById("alert-container").style.maxHeight = "60px";

    document.getElementById("alert-message").style.minWidth = messageWidth;
    document.getElementById("alert-message").style.minHeight = messageHeight;

    setTimeout(function() {

        document.getElementById("alert-container").style.transition = "all .6s cubic-bezier(.4,-0.01,.42,1), opacity .4s cubic-bezier(.69,-0.01,.23,.98)";
        document.getElementById("alert-container").style.opacity = 1;
    }, 10);


    setTimeout(function() {

        document.getElementById("alert-container").style.opacity = 1;
        document.getElementById("alert-container").style.maxHeight = containerHeight;
        document.getElementById("alert-container").style.maxWidth = containerWidth;
        document.getElementById("alert-message").style.paddingRight = "18px";

    }, 300);

    setTimeout(function() {

        document.getElementById("alert-container").style.maxHeight = "none";
        document.getElementById("alert-container").style.maxWidth = "none";
        document.getElementById("alert-container").style.height = "auto";
        document.getElementById("alert-container").style.width = "auto";
        document.getElementById("alert-message").style.minHeight = "min-content";
        document.getElementById("alert-message").style.minWidth = "min-content";
        document.getElementById("alert-message").style.height = "auto";
        document.getElementById("alert-message").style.width = "auto";


    }, 901);

}

function hideAlert() {
    var computedStyleContainer = window.getComputedStyle(document.getElementById("alert-container"));
    var computedStyleMessage = window.getComputedStyle(document.getElementById("alert-message"));

    document.getElementById("alert-container").style.maxWidth = computedStyleContainer.width;
    document.getElementById("alert-container").style.maxHeight = computedStyleContainer.height;
    document.getElementById("alert-container").style.width = computedStyleContainer.width;
    document.getElementById("alert-container").style.height = computedStyleContainer.height;
    document.getElementById("alert-container").style.transition = "all .3s cubic-bezier(.69,-0.01,.23,.98)";

    document.getElementById("alert-message").style.minWidth = computedStyleMessage.width;
    document.getElementById("alert-message").style.minHeight = computedStyleMessage.height;
    document.getElementById("alert-message").style.width = computedStyleMessage.width;
    document.getElementById("alert-message").style.transition = "all .3s cubic-bezier(.69,-0.01,.23,.98)";

    setTimeout(function() {

        document.getElementById("alert-container").style.maxWidth = "60px";
        document.getElementById("alert-container").style.opacity = 0;
        document.getElementById("alert-container").style.maxHeight = "60px";
        document.getElementById("alert-message").style.paddingRight = "0px";

    }, 100);

    setTimeout(function() {

        document.getElementById("alert-container").style.display = "none";


    }, 400);


}