function updatePageWithNewDate(change) {
    var currentDate = document.getElementById("date").value;
    var currentScale = parseInt(document.getElementById("scale").value);

    var dateObj = new Date(currentDate);

    var unitToAdd = 1;
    if (currentScale === 1) {
        unitToAdd = 7;
    } else if (currentScale === 2) {

        if (change === 'prev') {
            dateObj.setMonth(dateObj.getMonth() - 1);
        } else if (change === 'next') {
            dateObj.setMonth(dateObj.getMonth() + 1);
            unitToAdd = 0;
        }
    }

    if (change === 'prev') {
        dateObj.setDate(dateObj.getDate() - unitToAdd);
    } else if (change === 'next') {
        dateObj.setDate(dateObj.getDate() + unitToAdd);
    }

    // Convertir la nouvelle date en format YYYY-MM-DD
    var newDate = dateObj.toISOString().slice(0, 10);

    window.location.href = "?date=" + newDate + "&scale=" + currentScale;
}


function editActivity(id) {
    fetch('../controllers/get_activity.php?id=' + id)
        .then(response => response.json())
        .then(activity => {
            // Afficher tous les utilisateurs et groupes
            var allElements = document.getElementsByClassName("all");
            for (var i = 0; i < allElements.length; i++) {
                allElements[i].hidden = false;
            }

            document.getElementById('editActivityId').value = activity.id;
            document.getElementById('editActivityTitle').value = activity.title;
            document.getElementById('editActivityDate').value = activity.date;
            document.getElementById('editActivityStartTime').value = activity.start_time;
            document.getElementById('editActivityEndTime').value = activity.end_time;
            
            // Afficher les utilisateurs sélectionnés
            const invitedSelect = document.getElementById('editActivityInvited');
            invitedSelect.innerHTML = ''; // Nettoyer les options précédentes
            activity.invited.forEach(user => {
                console.log(document.getElementById(user).hidden);

                document.getElementById(user).hidden=true;
                console.log(document.getElementById(user).hidden);

                const option = document.createElement('option');
                option.textContent = user;
                option.value = user; 
                invitedSelect.appendChild(option);
            });

            // Afficher les groupes sélectionnés
            const invitedGrpSelect = document.getElementById('editActivityInvitedGrp');
            invitedGrpSelect.innerHTML = ''; // Nettoyer les options précédentes
            activity.invited_groups.forEach(group => {
                document.getElementById(group).hidden=true;
                const option = document.createElement('option');
                option.textContent = group;
                option.value = group; 
                invitedGrpSelect.appendChild(option);
            });

            document.getElementById('editActivityColor').value = activity.color;

            // Ajouter des écouteurs d'événements double-clic pour les options
            var userOptions = document.querySelectorAll('.user-option');
            userOptions.forEach(option => {
                option.addEventListener('dblclick', function() {
                    moveOption(option, invitedSelect);
                });
            });

            var groupOptions = document.querySelectorAll('.group-option');
            groupOptions.forEach(option => {
                option.addEventListener('dblclick', function() {
                    moveOption(option, invitedGrpSelect);
                });
            });

 
            invitedSelect.addEventListener('dblclick', function(event) {
                moveOptionBack(event.target, invitedSelect);
            });

            invitedGrpSelect.addEventListener('dblclick', function(event) {
                moveOptionBack(event.target, invitedGrpSelect);
            });

            const editModal = new bootstrap.Modal(document.getElementById("editActivityModal"));
            editModal.show();
        })
        .catch(error => console.error('Error:', error));
}

function moveOption(option, targetSelect) {
    option.remove();
    targetSelect.appendChild(option);
}

function moveOptionBack(option, targetSelect) {
    option.remove();
    const allSelect = document.getElementById(targetSelect.id === 'editActivityInvited' ? 'allUsers' : 'allGroups');
    allSelect.appendChild(option);
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("editActivityForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

        // Récupérer les utilisateurs sélectionnés
        var selectedUsers = document.getElementById("editActivityInvited");
        var selectedValues = [];
        for (var i = 0; i < selectedUsers.options.length; i++) {
                selectedValues.push(selectedUsers.options[i].value);
            
        }
        
        // Récupérer toutes les options du select group, sélectionnées ou non
        var selectedGroups = document.getElementById("editActivityInvitedGrp");
        var selectedValues2 = [];
        for (var i = 0; i < selectedGroups.options.length; i++) {
            selectedValues2.push(selectedGroups.options[i].value);
        }
        
        // Créer un objet FormData et y ajouter les valeurs
        var formData = new FormData(this);
        formData.append('invited', JSON.stringify(selectedValues));
        formData.append('invited_grp', JSON.stringify(selectedValues2));

        fetch("../controllers/timetable_controller.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response data:", data);
            if (data.error) {
                document.getElementById("errorResult").hidden = false;
                document.getElementById("errorResult").innerText = data.error;
            } else {

                var currentScale = document.getElementById("scale").value;
                var currentDate = document.getElementById("date").value;
                var currentUser = document.getElementById("username").value;
                document.location = "../controllers/timetable_controller.php?date=" + currentDate + "&scale=" + currentScale + "&username=" + currentUser;

            }
        })
        .catch(error => {
            console.error("Une erreur s'est produite:", error);
            document.getElementById("errorResult").hidden = false;
            document.getElementById("errorResult").innerText = "Une erreur s'est produite lors de l'envoi du formulaire.";
        });
    });
});

/*
CREATION D'ACTIVITE

*/

function createActivity() {
            const invitedSelect = document.getElementById('createActivityInvited');
            invitedSelect.innerHTML = ''; 

            const invitedGrpSelect = document.getElementById('createActivityInvitedGrp');
            invitedGrpSelect.innerHTML = '';

            // Ajouter des écouteurs d'événements double-clic pour les options
            var userOptions = document.querySelectorAll('.user-option');
            userOptions.forEach(option => {
                option.addEventListener('dblclick', function() {
                    moveOption(option, invitedSelect);
                });
            });

            var groupOptions = document.querySelectorAll('.group-option');
            groupOptions.forEach(option => {
                option.addEventListener('dblclick', function() {
                    moveOption_(option, invitedGrpSelect);
                });
            });

 
            invitedSelect.addEventListener('dblclick', function(event) {
                moveOptionBack_(event.target, invitedSelect);
            });

            invitedGrpSelect.addEventListener('dblclick', function(event) {
                moveOptionBack_(event.target, invitedGrpSelect);
            });

            const editModal = new bootstrap.Modal(document.getElementById("createActivityModal"));
            editModal.show();
}

function moveOption_(option, targetSelect) {
    option.remove();
    targetSelect.appendChild(option);
}

function moveOptionBack_(option, targetSelect) {
    option.remove();
    const allSelect = document.getElementById(targetSelect.id === 'createActivityInvited' ? 'allUsers' : 'allGroups');
    allSelect.appendChild(option);
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("createActivityForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

        // Récupérer les utilisateurs sélectionnés
        var selectedUsers = document.getElementById("createActivityInvited");
        var selectedValues = [];
        for (var i = 0; i < selectedUsers.options.length; i++) {
                selectedValues.push(selectedUsers.options[i].value);
            
        }
        
        // Récupérer toutes les options du select group, sélectionnées ou non
        var selectedGroups = document.getElementById("createActivityInvitedGrp");
        var selectedValues2 = [];
        for (var i = 0; i < selectedGroups.options.length; i++) {
            selectedValues2.push(selectedGroups.options[i].value);
        }
        
        // Créer un objet FormData et y ajouter les valeurs
        var formData = new FormData(this);
        formData.append('invited', JSON.stringify(selectedValues));
        formData.append('invited_grp', JSON.stringify(selectedValues2));

        fetch("../controllers/timetable_controller.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response data:", data);
            if (data.error) {
                document.getElementById("errorResult").hidden = false;
                document.getElementById("errorResult").innerText = data.error;
            } else {

                var currentScale = document.getElementById("scale").value;
                var currentDate = document.getElementById("date").value;
                var currentUser = document.getElementById("username").value;
                document.location = "../controllers/timetable_controller.php?date=" + currentDate + "&scale=" + currentScale + "&username=" + currentUser;

            }
        })
        .catch(error => {
            console.error("Une erreur s'est produite:", error);
            document.getElementById("errorResult").hidden = false;
            document.getElementById("errorResult").innerText = "Une erreur s'est produite lors de l'envoi du formulaire.";
        });
    });
});


