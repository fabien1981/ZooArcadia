<?php
require_once '../config/session.php';
 $title = 'Ajouter un animal' ;
?>




<?php require_once '../templates/head.php'?>


<body>
<?php require_once '../templates/header.php'?>

<main>
    <div class="container">
        <h1>Ajouter un animal</h1>

    <form action="../pages/form_validation_animal.php" method="post">
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom de l'animal</label>
            <input type="text" class="form-control" id="prenom" name="prenom">
        </div>
        <div class="mb-3">
            <label for="race" class="form-label">Race de l'animal</label>
            <input type="text" class="form-control" id="race" name="race">
        </div>
        <div class="mb-3">
            <label for="etat" class="form-label">Etat de forme de l'animal</label>
            <select name="etat" id="etat" class="form-select" aria-label="Selection de l'état de forme">
                <option value=""></option>
                <option value="Fatigué">Fatigué</option>
                <option value="Correct">Correct</option>
                <option value="Bon">Bon</option>
                <option value="En super forme">En super forme</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="habitat" class="form-label">Habitat de l'animal</label>
            <select name="habitat" id="habitat" class="form-select" aria-label="Selection de l'habitat">
                <option value=""></option>
                <option value="Savane">Savane</option>
                <option value="Jungle">Jungle</option>
                <option value="Marais">Marais</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image_animal" class="form-label">Photo de l'animal</label>
            <input type="text" class="form-control" id="image_animal" name="image_animal" >
        </div>
        <div class="col-12">
    <button class="btn btn-primary" type="submit">Envoyer</button>
  </div>
  </form>
    </div>
</main>



<?php require_once '../templates/footer.php'?>


</body>
</html>