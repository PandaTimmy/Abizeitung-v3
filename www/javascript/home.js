function loadHome() {

    document.getElementById("homeDisplayName").textContent = getCookie("first_name");
    document.getElementById("homeDisplayUsername").textContent = getCookie("username");

    if (getCookie("role") == "oa") {
        document.getElementById("mod").style.display = "block";
    }
}