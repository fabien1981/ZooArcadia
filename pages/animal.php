<?php

require_once '../config/pdo.php';

$animal_id = $_GET['animal_id'];
$query = $pdo->query('select * FROM animal where animal_id = '.$animal_id);

$animal =$query->fetch(PDO::FETCH_ASSOC);
  
?>




<?php require_once '../templates/head.php'?>


<body>
<?php require_once '../templates/header.php'?>

<main>
    <h1><?php echo $animal['prenom'].' '. $animal['race'] ?></h1>
    
    <div class="container">
    <div class="row">
                
                    <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Animal :  <?php echo $animal['race']; ?></h5>
                                    <p class="card-text">Prénom : <?php echo $animal['prenom']; ?></p>
                                    <p class="card-text">Etat : <?php echo $animal['etat']; ?></p>
                                    <img width="100" height="100" src="<?php echo $animal['image_animal']?>" alt="">
                                </div>
                            </div>
                        </div>         

    </div>
</main>



<?php require_once '../templates/footer.php'?>


</body>
</html>