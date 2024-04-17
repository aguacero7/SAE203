function verifyConnexion(){
    console.log("mama");
    id=getElementById("loginID").value;
    pass=getElementById("loginPassword").value;
    fetch("../controllers/connexion_treatment.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: '{"id": '+id+',"pass":'+pass+'}'
    });
}
document.getElementById("loginSubmit").addEventListener("click", verifyConnexion());