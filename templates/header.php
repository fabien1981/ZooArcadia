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
                    <a class="nav-link" href="../pages/ajout_animal.php">Espace administrateur</a>
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