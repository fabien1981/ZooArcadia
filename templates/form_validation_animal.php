<?php

use App\Database\Dbutils;

 require_once __DIR__ . '/../src/Database/Dbutils.php';

 if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
     if (!$_POST['prenom'] || !$_POST['etat'] || !$_POST['race'] || !$_POST['image_animal']) {
         echo 'Un des champs est vide. Insertion impossible';
     } else {
         $pdo = Dbutils::getPdo();
         $query = $pdo->prepare('INSERT INTO animal (prenom, etat, race, image_animal, habitat) VALUES (:prenom, :etat, :race, :image_animal, :habitat)');
         
         // Sécurisation des données (si nécessaire)
         $query->bindValue(':prenom', $_POST['prenom']);
         $query->bindValue(':etat', $_POST['etat']);
         $query->bindValue(':race', $_POST['race']);
         $query->bindValue(':image_animal', $_POST['image_animal']);
         $query->bindValue(':habitat', $_POST['habitat']);
         
         $query->execute();
         header('Location: habitats.php?message=animal ajouté avec succès');
     }
 } else {
     echo 'Impossible d\'arriver sur cette page en GET';
 }


?>
