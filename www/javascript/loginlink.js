function isUUIDv4(uuid) {
    const uuidv4Pattern = /^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i;
    return uuidv4Pattern.test(uuid);
}

var logincode = "";

function getLoginCode() {
    logincode = window.location.hash.slice(1);

    if (!logincode) {
        if (isUUIDv4(getCookie("logincode"))) {
            logincode = getCookie("logincode");
        }
    }

    if ((logincode && isUUIDv4(logincode))) {

            console.log(logincode);
            //window.location.hash = '';
            navigate("loginlink");
            setCookie("logincode", logincode, 0.0417);
            
    } else {
        navigate("home");
    }
}

function resetChat(number) {
    element = document.getElementById("chat"+number);

    element.style.opacity = 0;
}

function startChatNum(number, side) {
    element = document.getElementById("chat"+number);

    if(side == 1) {
        element.style.transformOrigin = "200% 50%";
    } else {
        element.style.transformOrigin = "-100% 50%";
    }

    element.style.transform = "scale(.5)";

    setTimeout(function() {

        element.style.transition = "1s all cubic-bezier(.26,.63,.66,1)";
        element.style.transform = "scale(1)";
        element.style.opacity = 1;

    }, 10);


    // setTimeout(function() {

    //     element.style.transition = "1s all ease-in-out";
    //     element.style.transform = "scale(.95)";
    //     element.style.opacity = .66;

    // }, 3000);

}

function startChat() {
    resetChat(0);
    resetChat(1);
    resetChat(2);
    resetChat(3);
    resetChat(4);
    resetChat(5);
    //resetChat(6);

    

    let i = 0;
    var side = [0,0,1,0,1,0,1,0];

    setTimeout(startAnimation, 300);
    
    function startAnimation() {
        if (i <= 5) {
            startChatNum(i, side[i]);
            i++;
            setTimeout(startAnimation, 300); // 4 Sekunden Pause
        }
    }
}

function loadLoginLinkText() {



    $.ajax({
        type: "POST",
        url: "hypertext-processor/load_loginlink_data.php", // Hier den Pfad zu deinem PHP-Skript angeben
        data: { logincode: logincode },
        success: function(response) {

            console.log(response);
            response = response.split("<|>");

            if(response[0] == "1") {

                var firstName = document.getElementById("loginlink_first_name");
                var title = document.getElementById("loginlink_title");
                var info = document.getElementById("loginlink_info");
                
                firstName.textContent = response[3];
                title.textContent = response[5];
                info.textContent = response[6];

                if(response[7] != "") {
                    document.getElementById("hidden").innerHTML = response[7];
                    document.getElementById("hidden").style.display = "block";
                }
            }

        },
        error: function(error) {
            
            console.log(error);
        }

    });

}

function continueToStep2() {
    customConfirm('Stimmst du der Datenschutzrichtlinie zu?', 'Ja, Fortfahren', 'Abbrechen', function(confirmed) {
        if (confirmed) {

            navigate("loginlink-step2");
        }
    });
}