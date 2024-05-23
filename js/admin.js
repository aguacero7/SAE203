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
function editUser(username) {
    
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

    fetch('../controllers/c_admin.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();  // Recharger la page
        } else {
        }
    })
    .catch(error => {
        alert('An error occurred: ' + error.message);
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
                let user = data.user;
                document.getElementById("currentProfilePicture").src = "../assets/pfp/"+user.pfp;
                document.getElementById('edit').value ="edit";
                document.getElementById("modalTitle").innerText = "Modifier l'utilisateur " + username;
                document.getElementById('username').value = user.username;
                document.getElementById('fullname').value = user.fullname;
                document.getElementById('email').value = user.email;
                document.getElementById('pfp').value = user.pfp;
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
    document.getElementById('edit').value ="create";

    if (fileInput.files && fileInput.files[0]) {
        // Créer un objet URL pour l'image téléchargée
        const imageUrl = URL.createObjectURL(fileInput.files[0]);

        // Définir l'URL de l'image comme source de l'élément currentProfilePicture
        document.getElementById("currentProfilePicture").src = imageUrl;
    }
}
function addUser() {
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