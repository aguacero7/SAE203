function askLogin(){
    var loginID = document.getElementById("loginID").value;
    var loginPassword = document.getElementById("loginPassword").value;

    var xhr = new XMLHttpRequest();
    var url = "../controllers/login_treatment.php";
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = "../models/index.php";
                } else {
                    var loginFeedback = document.getElementById("loginFeedback");
                    loginFeedback.textContent = response.error;
                    loginFeedback.parentElement.removeAttribute("hidden");
                }
            }
        }
    };

    var data = JSON.stringify({
        loginId: loginID,
        loginPass: loginPassword
    });
    xhr.send(data);
}


document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("loginButton").addEventListener("click", function() {
        askLogin();
    });

    document.getElementById("loginPassword").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            askLogin();
        }
    });
});
