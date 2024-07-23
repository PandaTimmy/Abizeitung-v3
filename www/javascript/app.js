adjustBottomBar();

var isShowingBigButtons = false;
var isShowingBottomBar = false;
var appstate = "home";
var lastAppStateScrollTop = 0;
var isAbleShowBottomBar = false;
var isAbleShowSmallButtons = false;


function adjustBigButtons(element1, element2, element3) {

    const bigbuttons = document.querySelectorAll('.bigbuttonnav');

    if (element1 == "none") {
        isShowingBigButtons = false;            
    } else {
        isShowingBigButtons = true;            
    }

    bigbuttons.forEach(bigbutton => {
        if(isShowingBottomBar) {
            bigbutton.style.transition = "transform .15s cubic-bezier(.44,0,.91,.81), background-color .2s ease-in-out";
        } else {
            bigbutton.style.transition = "transform 0s cubic-bezier(.44,0,.91,.81), background-color .2s ease-in-out";
        }
        bigbutton.style.transform = "scale(0)";
    });

    showBottomBar();

    
    setTimeout(() => {
        if (element1 == "none") {
            document.getElementById("bigbutton-nav-1").style.display = "none";
        } else {
            document.getElementById("bigbutton-nav-1").style.display = "block";
            document.getElementById("bigbutton-nav-1").style.backgroundImage = "url('images/icons/" + element1 + ".svg')";
        }

        if (element2 == "none") {
            document.getElementById("bigbutton-nav-2").style.display = "none";
        } else {
            document.getElementById("bigbutton-nav-2").style.display = "block";
            document.getElementById("bigbutton-nav-2").style.backgroundImage = "url('images/icons/" + element2 + ".svg')";
        }

        if (element3 == "none") {
            document.getElementById("bigbutton-nav-3").style.display = "none";
        } else {
            document.getElementById("bigbutton-nav-3").style.display = "block";
            document.getElementById("bigbutton-nav-3").style.backgroundImage = "url('images/icons/" + element3 + ".svg')";
        }

        setTimeout(() => {

            bigbuttons.forEach(bigbutton => {
                bigbutton.style.transition = "transform .3s cubic-bezier(0,.49,.35,.99), background-color .2s ease-in-out";
                bigbutton.style.transform = "scale(1)";
            });
        }, 1);

    }, 300);

}

function adjustBottomBar() {
    var viewportHeight = window.innerHeight;

    alertbox = document.getElementById("alert");

    if (isShowingBigButtons) {
        var gradientStart = 330 / viewportHeight * 100;
        var gradientEnd = 430 / viewportHeight * 100;
        alertbox.style.marginBottom = "230px";

    } else {
        var gradientStart = 250 / viewportHeight * 100;
        var gradientEnd = 300 / viewportHeight * 100;
        alertbox.style.marginBottom = "150px";

    }

    if(!isShowingBottomBar) {
        alertbox.style.marginBottom = "50px";
    }


    //document.getElementById("bottombar2").style.height = ( viewportHeight + 100 ) + "px";

    document.getElementById("bottombar").style.maskImage = "linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,1) "+gradientStart+"%, rgba(0,0,0,0) "+gradientEnd+"%)";
    //document.getElementById("bottombar").style.maskImage = "linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 100%)";

    document.getElementById("bottombar").style.height = ( viewportHeight + 100 ) + "px";
    //document.getElementById("bottombar").style.transition = "all 1s ease-in-out";
}

window.addEventListener("scroll", adjustBottomBar);

function hideBottomBar() {
    var gradientStart = 0;
    var gradientEnd = 0;
    isShowingBottomBar = false;

    //document.getElementById("bottombar").style.opacity = "0";
    document.getElementById("bottombar").style.transition = "transform .5s ease-in-out, opacity 1s ease-in-out";
    document.getElementById("bottombar").style.opacity = "0";
    document.getElementById("bottomnav").style.opacity = "0";
    document.getElementById("bottomnav").style.pointerEvents = "none";

    alertbox = document.getElementById("alert");
    alertbox.style.marginBottom = "50px";


}

function showBottomBar() {
    isShowingBottomBar = true;

    document.getElementById("bottombar").style.transition = "transform 0s ease-in-out, opacity 0s ease-in-out";
    document.getElementById("bottombar").style.opacity = "0";

    document.getElementById("bottombar").style.transition = "transform .6s cubic-bezier(.04,.53,.35,1.01), opacity .4s ease-in-out";
    document.getElementById("bottombar").style.opacity = "1";
    document.getElementById("bottomnav").style.opacity = "1";
    document.getElementById("bottomnav").style.pointerEvents = "all";

}

function hideSmallButtons() {
    document.getElementById("smallbuttons").style.display = "none";
}

function showSmallButtons() {
    document.getElementById("smallbuttons").style.display = "flex";
}

function hideAll() {

    document.getElementById("main").style.opacity = 0;

    hideBottomBar();
}

var pageY = 0;
window.addEventListener('scroll', function() {
    var scrolledDistance = window.scrollY; // oder window.pageYOffset
    if( (pageY - scrolledDistance) < -1 && scrolledDistance > 1) {
        hideBottomBar();
        pageY = scrolledDistance;
    }
    if( (pageY - scrolledDistance) > 1 || scrolledDistance < 20) {

        if(isAbleShowBottomBar) {
            showBottomBar();
            adjustBottomBar();
        }

        pageY = scrolledDistance;
    }
});


function adjustTextareaHeight(textarea) {
    textarea.style.height = 'auto';  // Setzt die Höhe zurück, um eine korrekte Messung zu ermöglichen
    textarea.style.height = textarea.scrollHeight + 'px';  // Setzt die Höhe basierend auf dem Inhalt
}

// Anwendung der Höhenanpassung auf alle Textareas mit der Klasse "auto-resize"
function applyAutoResize() {
    const textareas = document.querySelectorAll('.auto-resize');
    textareas.forEach(textarea => {
        adjustTextareaHeight(textarea);
        // Hinzufügen eines Event Listeners für jede Textarea, um auf Änderungen zu reagieren
        textarea.addEventListener('input', function() {
        adjustTextareaHeight(this);
        });
});
}

// Initialanpassung beim Laden der Seite und bei Änderungen im Inhalt
window.onload = applyAutoResize;

// Textareas anpassen, wenn sich bildschirm anpasst.
window.addEventListener('resize', applyAutoResize);