




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcadia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">   
   
        <!-- Lien vers le fichier style css -->
        <link rel="stylesheet" href="scss/main.css">
</head>


<body>
<header>
     <!--Ajout de la navbar bootstrap responsive lg est le breakpoint -->
     <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
                <img src="/assets/photos/logo zoo.png" width="80" height="80" alt="logo Arcadia"> 
              <a class="navbar-brand" href="#">Arcadia</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link"  href="/">Accueil</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/pages/habitats.php">Habitats</a>
                  </li>
                  
                  <li class="nav-item">
                    <a class="nav-link" href="/services">Services</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                  </li>
                  <li class="nav-item" data-show="employe">
                    <a class="nav-link" href="/employe">Espace employé</a>
                  </li>
                  <li class="nav-item" data-show="admin">
                    <a class="nav-link" href="/admin">Espace administrateur</a>
                  </li>
                  <li class="nav-item" data-show="veterinaire">
                    <a class="nav-link" href="/veterinaire">Espace vétérinaire</a>
                  </li>
                  <li class="nav-item" data-show="disconnected">
                    <a class="nav-link" href="/signin">Connexion</a>
                  </li>
                  <li class="nav-item" data-show="connected">
                  <button class="nav-link" id="signout-btn">Déconnexion</button>
                  </li>
                </ul>
               
              </div>
            </div>
          </nav>
          </header>

<main>

</main>

<h1>Zoo arcadia</h1>

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
</body>
</html>