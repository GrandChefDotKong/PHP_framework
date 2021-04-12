// Vérification de la longueur du mot de passe saisi
document.getElementById("password").addEventListener("input", function (e) {
	
    var password = e.target.value; // Valeur saisie dans le champ mdp
    var longueurMdp = "weak";
    var couleurMsg = "red"; // Longueur faible => couleur rouge
    if (password.length >= 8) {
        longueurMdp = "strong";
        couleurMsg = "green"; // Longueur suffisante => couleur verte
    } 
	else if (password.length >= 4) {
        longueurMdp = "good";
        couleurMsg = "orange"; // Longueur moyenne => couleur orange
    }
	
    var aideMdpElt = document.getElementById("aidepassword");
    aideMdpElt.textContent = longueurMdp; // Texte de l'aide
    aideMdpElt.style.color = couleurMsg; // Couleur du texte de l'aide
});



document.getElementById("mailAddress").addEventListener("input", function (e) {
	
    var mailAddress = e.target.value; // Valeur saisie dans le champ mdp
	var regex = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
	
	var aideMailElt = document.getElementById("aidemailAddress");
	
	if(!regex.test(mailAddress)) {
		aideMailElt.textContent = "Invalid mail address !";
		aideMailElt.style.color = "red"; // Couleur du texte de l'aide
		// ...
	} else {
		aideMdpElt.textContent = "";
	}
});


