<?php

require_once '../config/session.php';
require_once '../config/DbConnection.php';

$query = DbConnection::getPdo()->query('select * FROM animal');

$animaux =$query->fetchAll(PDO::FETCH_ASSOC);
  
?>




<?php require_once '../templates/head.php'?>


<body>
<?php require_once '../templates/header.php'?>
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

<?php require_once '../templates/footer.php'?>


</body>
</html>