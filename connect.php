<?php

    $dburl = getenv('DATABASE_URL');

    if ($dburl == null) {
        $user = 'root';
        $pass = 'mysql';
        $host = 'localhost';
        $dbname = 'scavenger_hunt';
        $dns = "mysql:host=$host;dbname=$dbname";
    } else {
        $user = getenv('DATABASE_USER');
        $pass = getenv('DATABASE_PASSWORD');
        $host = getenv('DATABASE_HOST');
        $dbname = getenv('DATABASE_NAME');
        $dns = "mysql:host=$host;dbname=$dbname";   
    }
        
    try {
        $pdo = new PDO($dns, $user, $pass);
    } catch (PDOException $e) {
        echo "dns: " . $dns . "<br>";
        echo 'Connection failed: ' . $e->getMessage();
    }

?>