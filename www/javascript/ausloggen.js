function ausloggen() {

    customConfirm('Ausloggen', 'Ja', 'Abbrechen', function(confirmed) {
        if (confirmed) {

            deleteCookie("accessToken");
            deleteCookie("refreshToken");
            deleteCookie("first_name");
            deleteCookie("last_name");
            deleteCookie("role");
            deleteCookie("username");
        
            navigate("facility-select", "crossfade", false);
        
            internAlert("Erfolgreich ausgeloggt")
        } else {

        }
    });


}