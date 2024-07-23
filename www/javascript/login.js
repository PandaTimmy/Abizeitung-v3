function login() {
    var username = document.getElementById("loginUsername").value;
    var password = document.getElementById("loginPassword").value;

    $.ajax({
        type: "POST",
        url: "hypertext-processor/login.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { username: username, password: password, groupUUID: targetGroupUUID },
        success: function(response) {

            console.log(response);

            if(response == "1") {
                internAlert("Willkommen!");
                navigate("home", "crossfade", "false");

            } else {
                internAlert("Falsche Logindaten");
            }
        },
        error: function(error) {
            
            console.log(error);
        }
    });
}