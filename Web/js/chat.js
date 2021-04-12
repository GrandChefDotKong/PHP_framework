$('#envoi').click(function(e){
    e.preventDefault(); // on empêche le bouton d'envoyer le formulaire

    var pseudo = $('#pseudo').val(); // on sécurise les données
    var message = $('#message').val();

    if(pseudo !== "" && message !== ""){ // on vérifie que les variables ne sont pas vides
        $.ajax({
            url : "/chat-add.html", // on donne l'URL du fichier de traitement
            type : "POST", // la requête est de type POST
            data : "auteur=" + pseudo + "&contenu=" + message // et on envoie nos données
        });
    }
});

function charger(){

    var premierID = $('#messages div:last').attr('id'); // on récupère l'id le plus récent
    if(premierID === undefined) { premierID = 0; }

    $.ajax({
        url : "/chat-get-" + premierID + ".html", // on passe l'id le plus récent au fichier de chargement
        type : "GET",
        success : function(html){
            $('#messages').append(html);
            var element = document.getElementById("messages");
            element.scrollTop = element.scrollHeight - element.clientHeight;
        }
    });

    setTimeout(function onTick() { charger(); }, 5000);
}

charger();

