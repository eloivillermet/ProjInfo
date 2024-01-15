<?php

*if(isset($_POST['nouveau_mot_de_passe'])) {
    $nouveauMotDePasse = $_POST['nouveau_mot_de_passe'];
    $confirmationMotDePasse = $_POST['confirmation_mot_de_passe'];

    // Vérifier si les champs du mot de passe correspondent
    if($nouveauMotDePasse === $confirmationMotDePasse) {
        // Mettre à jour le mot de passe de l'utilisateur dans la base de données
        // Supprimer le token utilisé pour la réinitialisation du mot de passe
        // Rediriger l'utilisateur vers la page de connexion ou afficher un message de succès
    } else {
        // Afficher un message d'erreur si les mots de passe ne correspondent pas
    }
}

?>