<?php

require_once '../config/config.php';

if(isset($_SESSION['email'])){
    unset($_SESSION['email']);

    $_SESSION['success_message'] = 'Vous avez été déconnecté';
}

header('location: ../index.php');

?>