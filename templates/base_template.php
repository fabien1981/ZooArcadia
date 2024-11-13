<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Arcadia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">   
    <link rel="stylesheet" href="/811/scss/main.css">
</head>
<body>
<header>
     <!-- Navbar Bootstrap -->
     <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <img src="/811/photos/logo zoo.png" width="80" height="80" alt="logo Arcadia"> 
            <a class="navbar-brand" href="#">Arcadia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/811/homepage/home">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/811/habitats/display">Habitats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/811/services/display">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/811/contact/display">Contact</a>
                    </li>

                    <?php if (isset($_SESSION['email'])): ?>
                        <!-- Affiche le lien "Modifier le mot de passe" pour tous les utilisateurs connectés -->
                        <li class="nav-item">
                            <a class="nav-link" href="/811/modifier_mot_de_passe">Modifier le mot de passe</a>
                        </li>

                        <?php if ($_SESSION['email']['role'] === 'Vétérinaire'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/811/veterinaire/display">Espace vétérinaire</a>
                            </li>
                        <?php endif; ?>

                        <?php if ($_SESSION['email']['role'] === 'Admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/811/admin/display">Espace administrateur</a>
                            </li>
                        <?php endif; ?>

                        <?php if ($_SESSION['email']['role'] === 'Employé'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/811/employe/display">Espace employé</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/811/logout">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/811/connexion/display">Connexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
     </nav>
</header>

<main class="container">
    <?php
        // Inclure la page de contenu si elle existe
        if (isset($page) && file_exists($page)) {
            require_once $page;
        } else {
            echo "Contenu de la page introuvable.";
        }
    ?>
</main>

<!-- Footer -->
<footer class="bg-dark text-white text-center footer">
    <div class="row">
        <div class="col-6 col-lg-4">
            <h3 class="text-secondary">Nos horaires</h3>
            <div id="horaires"></div>
        </div>
        <div class="col-6 col-lg-4">
            <p>Eco Zoo Arcadia<br/>
                Forêt de Brocéliande<br/>
                France
            </p>
        </div>
        <div class="col-6 col-lg-4">
            <p>Mail</p>
        </div>
        <div class="col-12 ">
            <p>Mentions légales</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>   
<script src="/811/scripts/api.js"></script>
<script src="/811/scripts/connexion.js"></script>

</body>
</html>
