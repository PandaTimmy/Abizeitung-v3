
function bigbuttonNav1() {
    if (appstate == "quotes") {
        navigate("home", "crossfade", true);
    }
    if (appstate == "group-select") {
        navigate("facility-select", "crossfade", true);
    }
    if (appstate == "group-add") {
        navigate("group-select", "crossfade", true);
    }
    if (appstate == "login") {
        navigate("group-select", "crossfade", true);
    }
    if (appstate == "loginlink-step2") {
        navigate("loginlink", "crossfade", false);
    }
    if (appstate == "loginlink-step3") {
        navigate("loginlink-step2", "crossfade", false);
    }
    if (appstate == "datenschutzrichtlinie" || appstate == "privatsphäre") {
        navigate("loginlink", "crossfade", false);
    }
    if (appstate == "ua-overview") {
        navigate("home", "crossfade", true);
    }
    if (appstate == "ua-add") {
        navigate("ua-overview", "crossfade", true);
    }
    if (appstate == "ua-edit") {
        navigate("ua-overview", "crossfade", true);
    }

    if (appstate == "admin-login") {
        navigate("select-facility", "crossfade", false);
    }
    if (appstate == "-admin-facilities-overview") {
        navigate("-admin-overview", "crossfade", false);
    }
    if (appstate == "-admin-facilities-edit") {
        navigate("-admin-facilities-overview", "crossfade", true);
    }
    if (appstate == "-admin-facilities-add") {
        navigate("-admin-facilities-overview", "crossfade", true);
    }
    if (appstate == "-admin-group-add") {
        navigate("-admin-group-overview", "crossfade", true);
    }

}

function bigbuttonNav2() {
    if (appstate == "admin-login") {
        adminLogin();
    }

    if (appstate == "login") {
        login();
    }

    if (appstate == "ua-overview") {
        navigate("ua-add", "crossfade", true);
    }

    if (appstate == "ua-add") {
        uaAdd();
    }

    if (appstate == "loginlink-step2") {
        navigate("loginlink-step3","crossfade",false);
    }
}

var transitionComplete = true;
var loadComplete = true;


var future_ShowBottombar = false;


function navigate(target, transitiontype, scrollback) {

    appstate = target;

    transitionComplete = false;
    loadComplete = false;

    const main = document.getElementById("main");
    transitionMain = document.getElementById("transition-main");

    var lastAppStateScrollTopCache = lastAppStateScrollTop;
    lastAppStateScrollTop = window.scrollY;

    main.style.transition = "opacity .3s ease-in-out";
    main.style.opacity = 0;
    main.style.pointerEvents = "none";


    
    
    removeChildIds(main);


    setTimeout(function() {
        main.style.opacity = 1;
        transitionComplete = true;
        loadComplete = true;

        if (loadComplete) {
            main.innerHTML = transitionMain.innerHTML;
            removeChildIds(transitionMain);
            applyAutoResize();
            afterHTMLloadFunction();
        }

        adjustBottomBar()

        if(scrollback) {
            window.scrollTo(0, lastAppStateScrollTopCache);
        } else {
            window.scrollTo(0, 0);
        }


    }, 300);

    setTimeout(function() { main.style.pointerEvents = "all"; }, 600);

    if (target == "loginlink") {
        adjustBigButtons("none", "none", "none");
        appendHTML("loginlink.html");
        isAbleShowBottomBar = false;
        isAbleShowSmallButtons = false;
        hideBottomBar();

    }

    if (target == "loginlink-step2") {
        adjustBigButtons("back", "continue", "none");
        appendHTML("loginlink-step2.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;

    }

    if (target == "loginlink-step3") {
        adjustBigButtons("back", "none", "none");
        appendHTML("loginlink-step3.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;

    }

    if (target == "datenschutzrichtlinie") {
        adjustBigButtons("back", "none", "none");
        appendHTML("datenschutzrichtlinie.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if (target == "privatsphäre") {
        adjustBigButtons("back", "none", "none");
        appendHTML("privatsphäre.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }


    if (target == "quotes") {
        adjustBigButtons("back", "submit", "none");
        appendHTML("quotes.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = true;
    }
    
    if (target == "home") {
        adjustBigButtons("none", "none", "none");
        appendHTML("home.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = true;
    }

    if (target == "facility-select") {
        schoolNames = [];
        schoolAdresses = [];
        schoolUUIDs = [];

        adjustBigButtons("none", "none", "none");

        appendHTML("facility-select.html");
        isAbleShowBottomBar = false;
        isAbleShowSmallButtons = false;
        hideBottomBar();
    }

    if (target == "group-select") {
        adjustBigButtons("back", "none", "none");
        showBottomBar();
        appendHTML("group-select.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if (target == "group-add") {
        adjustBigButtons("back", "none", "none");
        showBottomBar();
        appendHTML("group-add.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if (target == "group-create-result") {
        adjustBigButtons("none", "none", "none");
        hideBottomBar();
        appendHTML("group-create-result.html");
        isAbleShowBottomBar = false;
        isAbleShowSmallButtons = false;
    }

    if (target == "login") {
        adjustBigButtons("back", "continue", "none");
        showBottomBar();
        appendHTML("login.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if (target == "ua-overview") {
        adjustBigButtons("back", "add", "none");
        showBottomBar();
        appendHTML("ua-overview.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = true;
    }

    if (target == "ua-add") {
        adjustBigButtons("back", "confirm", "none");
        showBottomBar();
        appendHTML("ua-add.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = true;
    }

    if (target == "ua-edit") {
        adjustBigButtons("back", "none", "none");
        showBottomBar();
        appendHTML("ua-edit.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = true;
    }

    if (target == "-admin-overview") {
        adjustBigButtons("none", "none", "none");
        showBottomBar();
        appendAdminHTML("-admin-overview");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if (target == "-admin-facilities-overview") {
        adjustBigButtons("back", "none", "none");
        showBottomBar();
        appendAdminHTML("-admin-facilities-overview");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if (target == "-admin-facilities-edit") {
        adjustBigButtons("back", "none", "none");
        showBottomBar();
        appendAdminHTML("-admin-facilities-edit");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if (target == "-admin-facilities-add") {
        adjustBigButtons("back", "none", "none");
        showBottomBar();
        appendAdminHTML("-admin-facilities-add");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if (target == "-admin-group-add") {
        adjustBigButtons("back", "none", "none");
        showBottomBar();
        appendAdminHTML("-admin-group-add");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if (target == "admin-login") {
        adjustBigButtons("back", "continue", "none");
        showBottomBar();
        appendHTML("admin-login.html");
        isAbleShowBottomBar = true;
        isAbleShowSmallButtons = false;
    }

    if(isAbleShowSmallButtons) {
        showSmallButtons();
    } else {
        hideSmallButtons();
    }

}

function removeAllIds(element) {
    // Entferne die ID vom aktuellen Element
    element.removeAttribute('id');

    // Rekursiv für alle Kinder des aktuellen Elements aufrufen
    for (let child of element.children) {
        removeAllIds(child);
    }
}

function removeChildIds(parentId) {
    var parentElement = parentId;

    // Sicherstellen, dass das Elternelement existiert, bevor weitergemacht wird
    if (parentElement) {
        // Auswahl aller Kinderelemente des Elternelements
        var children = parentElement.querySelectorAll('*');

        // Durchlaufen aller Kinderelemente und Entfernen ihrer ID
        children.forEach(function(child) {
            child.removeAttribute('id');
        });

    } else {
        console.log('Elternelement mit der ID ' + parentId + ' wurde nicht gefunden.');
    }
}