<?php
require_once '../config/config.php';



$title='inscription';



$error = null;


// test si la méthode envoyée est bien POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // test des données du formulaire posté afin de voir si username ou password sont vides
    if (!$_POST['email'] || !$_POST['password']) {
        $error = 'Identifiants invalides';
    } else {
        // sinon on enregistre notre utilisateur en base
        $query = DbConnection::getPdo()->prepare('INSERT INTO utilisateur (email, password) VALUES (:email, :password)');
        $query->bindParam('email', $_POST['email']);

        // ici pour plus de sécurité on hash notre mot de passe afin de le protéger
        // et au cas ou ne pas garder le mdp en clair dans la base en cas de vol de données
        // on vérifie un mot de passe hashé via password_verify
        // test ~ $2y$10$NlGveXH/89avQCu/Umm2jeb7IYOvEKKwTRJjBVIrz9xLGIRCzYnQ.
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $query->bindParam('password', $password);

        if (!$query->execute()) {
            $error = 'une erreur est survenue';
        } else {
            // ajout du message de succes en session pour pouvoir l'afficher sur la page de connection
            $_SESSION['success_message'] = 'Votre compte a bien été créé';

            header('Location:connexion.php');
        }
    }
}

require_once '../templates/head.php';
require_once '../templates/header.php';

?>

<div class="container">
    <h1>Créer un compte</h1>

    <!-- Ici si l'erreur est différente de false, null ou  '' on affiche un message d'alerte montrant notre erreur -->
    <?php if ($error): ?>
        <div class="alert alert-warning" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

   

    <form action="" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Identifiant</label>
            <input type="email" class="form-control" id="email" name="email" >
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="col-12">
            <button class="btn btn-primary" type="submit">Inscription</button>
        </div>
    </form>
</div>