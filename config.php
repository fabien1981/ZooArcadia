<?php
// Si une variable d'environnement BASE_URL est définie, utilisez-la, sinon utilisez une valeur par défaut.
define('BASE_URL', getenv('BASE_URL') ?: '/ZooArcadia');
