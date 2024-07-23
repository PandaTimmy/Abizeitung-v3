function adminLogin() {
    var username = document.getElementById("adminLoginUsername").value;
    var password = document.getElementById("adminLoginPassword").value;

    $.ajax({
        type: "POST",
        url: "hypertext-processor/admin_login.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { aaUsername: username, aaPassword: password },
        success: function(response) {

            if(response == "1") {
                navigate("-admin-overview", "crossfade", true);
            } else {
                internAlert("Falsche Logindaten");

            }
        },
        error: function(error) {
            
            console.log(error);
        }
    });
}