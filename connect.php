<?php

    $dburl = getenv('DATABASE_URL');

    if ($dburl == null) {
        $user = 'root';
        $pass = 'mysql';
        $pdo = new PDO('mysql:host=localhost;dbname=scavanger_hunt', $user, $pass);
    } else {
        try {
            $pdo = new PDO($dburl);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

?>