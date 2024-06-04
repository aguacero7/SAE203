function searchUser(input) {
    function isolate(){
        var verts = document.getElementsByClassName("border-success")
        for (var i = 0; i < verts.length; i++) {
            verts[i].classList.remove("border-success")
        }
    }
    if (input.trim() !== '' && input.length >= 3) {
        var searchResults = document.getElementById("searchResults");
        searchResults.innerHTML = '';

        fetch('../assets/utilisateurs.json')
            .then(response => response.json())
            .then(users => {
                console.log(users);
                var usersArray = Object.values(users);

                var filteredUsers = usersArray.filter(user => user.fullname.toLowerCase().includes(input.toLowerCase()));

                filteredUsers.forEach(user => {
                    var resultItem = document.createElement("button");
                    resultItem.classList.add("btn", "mb-2");
                    resultItem.textContent = user.fullname;
                    resultItem.onclick = function () {
                        isolate();
                        window.location.href = "#" + user.fullname;
                        var element = document.getElementById(user.fullname);
                        element.classList.add("border-success");
                    }
                    searchResults.appendChild(resultItem);

                });
            });
    }
    else {
        var searchResults = document.getElementById("searchResults");
        searchResults.innerHTML = '';
        isolate();

    }
}

function makeRequest(url, method, data, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open(method, url);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                callback(JSON.parse(xhr.responseText));
            }
        }
    };
    xhr.send(JSON.stringify(data));
}








