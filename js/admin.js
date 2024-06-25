function applyChanges() {
    if (confirm("Êtes vous sûr de vouloir sauvegarder vos changements?")) {
    let formData = new FormData()
    formData.append('save', '1')
    fetch('../controllers/c_admin.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert(data.error);
            }
        })
        .catch(error => {
            alert('Une erreur s\'est produite : ' + error.message);
        });
    }
}

function cancelChanges() {
    if (confirm("Êtes vous sûr de vouloir annuler vos changements? Cette décision est irréversible")) {
        let formData = new FormData()
        formData.append('rollback', '1')
        fetch('../controllers/c_admin.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la requête');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload()
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                alert('Une erreur s\'est produite : ' + error.message);
            });
    }
}


function deleteUser(username) {
    if (confirm('Are you sure you want to delete user: ' + username + '?')) {
        let formData = new FormData()
        formData.append('delete', username)
        fetch('../controllers/c_admin.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la requête');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload()
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                alert('Une erreur s\'est produite : ' + error.message);
            });
    }
}

function updateGroup(username, group, isChecked) {
    let formData = new FormData();
    formData.append('username', username);
    formData.append('group', group);
    formData.append('update', isChecked ? '1' : '0'); // 1 pour ajouter, 0 pour supprimer

    fetch('../controllers/c_admin.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {

            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            alert('An error occurred: ' + error.message);
        });
}

function genNumber() {
    let contactField = document.getElementById('contact');
    let generatedNumber = Math.floor(Math.random() * 10000).toString().padStart(4, '0');

    fetch(`../controllers/c_admin.php?number=${generatedNumber}`)
        .then(response => {
            if (!response.ok) { 
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) { 
                contactField.value = generatedNumber;
            } else {
                genNumber();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
function searchTmpUser(input) {
    function isolate(){
        var verts = document.getElementsByClassName("table-success")
        if(verts.length>=1){
        for (var i = 0; i < verts.length; i++) {
            verts[i].classList.remove("table-success")
        }}
    }
    if (input.trim() !== '' && input.length >= 3) {
        var searchResults = document.getElementById("searchResults");
        searchResults.innerHTML = '';

        fetch('../assets/tempusers.json')
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
                        element.classList.add("table-success");
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


function genUsername() {
    let fullNameField = document.getElementById('fullname').value;
    if (fullNameField.trim() === '') {
        alert('Veuillez entrer un nom complet avant de générer un nom d\'utilisateur.');
        return;
    }
    
    let names = fullNameField.split(' ');
    if (names.length < 2) {
        alert('Veuillez entrer un prénom et un nom.');
        return;
    }

    let firstName = names[0].toLowerCase();
    let lastName = names[1].toLowerCase();
    let randomNumber = Math.floor(Math.random() * 100);
    let username = firstName + lastName + randomNumber;

    document.getElementById('username').value = username;
}

function saveUser() {
    let formData = new FormData(document.getElementById('userForm'));
    let editMode = formData.get('action');

    if (editMode === 'edit') {
        let username = document.getElementById('hiddenusr').value;
        formData.append('username', username);
    }
    fetch('../controllers/c_admin.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); 
        } else {
            Object.keys(data.errors).forEach(fieldName => {
                let errorMsg = data.errors[fieldName];
                let field = document.getElementById(fieldName);
                field.classList.add('is-invalid');
                let errorFeedback = field.nextElementSibling; 
                errorFeedback.innerText = errorMsg; 
            });
            alert('Des erreurs se sont produites. Veuillez vérifier le formulaire.');
        }
    })
    .catch(error => {
        alert('An error occurred: ' + error.message);
    });
}
function resetForm() {
    document.getElementById("currentProfilePicture").src = "../assets/pfp/default.png";
    document.getElementById('edit').value = "";
    document.getElementById("modalTitle").innerText = "";
    document.getElementById('username').disabled = false;
    document.getElementById('username').value = "";
    document.getElementById('gen').disabled = false;

    document.getElementById('fullname').value = "";
    document.getElementById('email').value = "";
    document.getElementById('contact').value = "";
    document.getElementById('birthday').value = "";

    let groupesCheckboxes = document.querySelectorAll('input[name="groupes[]"]');
    groupesCheckboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}
function editUser(username) {
    fetch(`../controllers/c_admin.php?username=${username}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                resetForm();
                let user = data.user;
                document.getElementById("currentProfilePicture").src = "../assets/pfp/"+user.pfp;
                document.getElementById('edit').value ="edit";
                document.getElementById("modalTitle").innerText = "Modifier l'utilisateur " + username;
                document.getElementById('username').disabled=true;
                document.getElementById('hiddenusr').value=username;
                document.getElementById('gen').disabled=true;

                document.getElementById('fullname').value = user.fullname;
                document.getElementById('email').value = user.email;
                document.getElementById('contact').value = user.contact;
                document.getElementById('birthday').value = user.naissance;

                let groupesCheckboxes = document.querySelectorAll('input[name="groupes[]"]');
                groupesCheckboxes.forEach(checkbox => {
                    checkbox.checked = user.groupes.includes(checkbox.id);
                });

                new bootstrap.Modal(document.getElementById('userModal')).show();
            } else {
                console.error('User data not found');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
function tryPfp(){
    let fileInput = document.getElementById('profilePicture');

    if (fileInput.files && fileInput.files[0]) {
        // Créer un objet URL pour l'image téléchargée
        const imageUrl = URL.createObjectURL(fileInput.files[0]);

        // Définir l'URL de l'image comme source de l'élément currentProfilePicture
        document.getElementById("currentProfilePicture").src = imageUrl;
    }
}
function addUser() {
    resetForm();
    document.getElementById('edit').value ="create";
    document.getElementById("currentProfilePicture").src = "../assets/pfp/default.png";
    document.getElementById("modalTitle").innerText="Ajouter un utilisateur"
    new bootstrap.Modal(document.getElementById('userModal')).show();
}

function seePassword() {
    const password = document.getElementById('password');
    password.setAttribute('type', 'text');
    
    const button = document.getElementById('togglePassword');
    button.querySelector('i').classList.remove('fa-eye');
    button.querySelector('i').classList.add('fa-eye-slash');
  }
  
  function hidePassword() {
    const password = document.getElementById('password');
    password.setAttribute('type', 'password');
    
    const button = document.getElementById('togglePassword');
    button.querySelector('i').classList.remove('fa-eye-slash');
    button.querySelector('i').classList.add('fa-eye');
  }