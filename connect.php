<?php

    $dburl = getenv('DATABASE_URL');

    if ($dburl == null) {
        $user = 'root';
        $pass = 'mysql';
        $pdo = new PDO('mysql:host=localhost;dbname=scavanger_hunt', $user, $pass);
    } else {
        $pdo = new PDO($dburl);
    }

?>