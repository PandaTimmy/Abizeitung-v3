function afterHTMLloadFunction() {

    if (appstate == "group-select") {
        displayData();
        loadGroups();
    }

    if (appstate == "facility-select") {
        loadFacilities();
    }

    if (appstate == "group-create-result") {
        displayResults();
    }

    if (appstate == "home") {
        loadHome();
    }

    if (appstate == "ua-overview") {
        uaLoadAll();
    }

    if (appstate == "ua-edit") {
        uaLoad();
    }

    if (appstate == "loginlink") {
        startChat();
        loadLoginLinkText();
    }

}