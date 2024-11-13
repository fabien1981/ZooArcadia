
<?php

use App\Database\Dbutils;

$query = Dbutils::getPdo()->query('select * FROM animal');

$animaux =$query->fetchAll(PDO::FETCH_ASSOC);

?>







<body>

<main>
 
    <div class="alert alert-success" role="alert">
      <?php if (isset($_GET['message'])); ?>
    </div>

<p>Bienvenue dans l'habitat de la savane ! Ici, vous découvrirez l'incroyable diversité de la savane africaine,
  un vaste écosystème où cohabitent de nombreuses espèces emblématiques.
   Avec ses grandes étendues herbeuses parsemées d’acacias et de baobabs,
    la savane est un lieu de vie dynamique, rythmé par la chaleur et les saisons.

Dans cet espace, observez de près des animaux fascinants comme les lions majestueux,
 les éléphants puissants, les girafes élancées et les zèbres rayés.
  Chaque espèce joue un rôle essentiel dans cet équilibre naturel,
   et cet habitat recréé vise à sensibiliser les visiteurs à la préservation de la faune et de la flore de ces paysages uniques.
    Profitez de cette immersion au cœur de la savane pour mieux comprendre et apprécier la beauté sauvage de l'Afrique.</p>
<div class="container">
                <div class="row">
                  <?php foreach ($animaux as $prenom =>$animal){  ?>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Animal :  <?php echo $animal['race']; ?></h5>
                                    <p class="card-text">Prénom : <?php echo $animal['prenom']; ?></p>
                  <!-- ajout du paramétre animal_id dans l'url pour pouvoir récupérer les animaux  un par un-->
                                    <a href="animal.php?animal_id=<?php echo $animal['animal_id'] ?>" class="btn btn-primary">Voir en détail</a>
                                    <img width="100" height="100" src="<?php echo $animal['image_animal']?>" alt="">
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                        
                 
                </div>

            </div>
</main>

<h1>Zoo arcadia</h1>


<div class="hero-scene text-center text-white ">
    <div class="hero-scene-content  ">
        <p>Nos habitats</p>
    </div>
    </div>

<div class="container">
    <div class="row row-cols-1 row-cols-lg-3">
        <div class="col p-3">
            <div class="image-card text-white">
              <img src="../assets/photos/savane.jpeg" class="rounded w-100"/>
              <p class="titre-image">Savane</p>  
            </div>
        </div>
        <div class="col p-3 w-30 " >
            <div class="image-card text-dark ">
                <p>Notre zoo est composé de 3 principaux  habitats:
                    Les marais, la jungle ainsi que la savane.</p>
            </div>
        </div>
        <div class="col p-3"></div>
            <div class="image-card text-white">
              <img src="../assets/photos/marais.jpeg" class="rounded w-100"/>
              <p class="titre-image">Marais</p>  
            </div>
        </div>
        <div class="col p-3"></div>
            <div class="image-card text-white">
              <img src="../assets/photos/jungle.jpg" class="rounded w-100"/>
              <p class="titre-image">titre</p>  
            </div>
        </div>
        
        
    </div>


</div>

</body>
</html>