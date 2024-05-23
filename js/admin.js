function applyChanges() {
    let formData=new FormData()
    formData.append('save','1')
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

function cancelChanges(){
    let formData=new FormData()
    formData.append('rollback','1')
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
function editUser(username) {
    alert('Edit user: ' + username);
}

function deleteUser(username) {
    if (confirm('Are you sure you want to delete user: ' + username + '?')) {
        let formData=new FormData()
    formData.append('delete',username)
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