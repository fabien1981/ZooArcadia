<?php
    require_once '../config/config.php';
   

//verification de la méthod d'accés à la page que par la méthode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
    if (!$_POST['prenom'] ||
        !$_POST['etat'] ||
        !$_POST['race'] ||
        !$_POST['image_animal']
    ){
        echo 'Un des champs est vide. Insertion impossible';
    } else {
        $query = DbConnection::getPdo()->prepare('INSERT INTO animal 
    (prenom, etat, race, image_animal)
    VALUES (
    :prenom,
    :etat,
    :race,
    :image_animal
    )
    ');
//securisation de l'insertion des données 
    $query->bindValue('prenom',DbConnection::protectDbData($_POST['prenom']));
    $query->bindValue('etat',DbConnection::protectDbData($_POST['etat']));
    $query->bindValue('race',DbConnection::protectDbData($_POST['race']));
    $query->bindValue('image_animal',DbConnection::protectDbData($_POST['image_animal']));

    $query->execute();

    header('location:habitats.php?message=animal ajouté avec succés');
    }

    
} else {
    echo 'Impossible d\'arriver sur cette page en GET';
}

?>
