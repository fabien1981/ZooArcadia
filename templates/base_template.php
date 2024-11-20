<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Arcadia</title>
    
    <!-- Fonts Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">   

    <!-- Bootstrap CSS (via CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
   


    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="/ZooArcadia/css/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">



    
    <!-- CSS compilé -->
    <link rel="stylesheet" href="/ZooArcadia/scss/main.css">

    <!-- Favicon -->
    <link rel="icon" href="/ZooArcadia/favicon.ico" type="image/x-icon">
</head>

<body>
<header>
     <!-- Navbar Bootstrap -->
     <nav class="navbar navbar-expand-lg bg-primary navbar-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <img src="/ZooArcadia/photos/logo zoo.png" width="80" height="80" alt="logo Arcadia"> 
            <a class="navbar-brand" href="#">Arcadia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/ZooArcadia/homepage/home">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ZooArcadia/habitats/display">Habitats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ZooArcadia/services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ZooArcadia/contact/display">Contact</a>
                    </li>

                    <?php if (isset($_SESSION['email'])): ?>
                        <!-- Affiche le lien "Modifier le mot de passe" pour tous les utilisateurs connectés -->
                        <li class="nav-item">
                        <a href="/ZooArcadia/modifier_mot_de_passe/display" class="nav-link">Modifier le mot de passe</a>

                        </li>

                        <?php if ($_SESSION['email']['role'] === 'Vétérinaire'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/ZooArcadia/veterinaire/display">Espace vétérinaire</a>
                            </li>
                        <?php endif; ?>

                        <?php if ($_SESSION['email']['role'] === 'Admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/ZooArcadia/admin/display">Espace administrateur</a>
                            </li>
                        <?php endif; ?>

                        <?php if ($_SESSION['email']['role'] === 'Employé'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/ZooArcadia/employe/display">Espace employé</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/ZooArcadia/logout">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/ZooArcadia/connexion/display">Connexion</a>
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
<footer class="bg-primary text-white text-center footer">
    <div class="row">
        <div class="col-6 col-lg-4">
            
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
        <div class="col-12">
            <p>Mentions légales</p>
        </div>
    </div>
</footer>
<!-- JavaScript Bootstrap (via CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>