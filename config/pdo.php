<?php

$host_name  = "mysql-fabien31.alwaysdata.net";
$database   = "fabien31_arcadia";
$user_name  = "fabien31_jose";
$password   = "NA3092bb@1";

try {
$pdo = new PDO('mysql:host='.$host_name.';dbname='.$database, $user_name, $password);
} catch (PDOException $e) {
print "Erreur !: " . $e->getMessage() . "<br/>";
die();
}
?>