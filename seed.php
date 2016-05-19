<?php

    include 'connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS findings (id int AUTO_INCREMENT NOT NULL,hunter_id int NOT NULL,clue_id int NOT NULL,found tinyint(1) NOT NULL DEFAULT '0', PRIMARY KEY (id));");
        $stmt->execute(array());

        $stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS hunters (id int AUTO_INCREMENT NOT NULL,first_name varchar(60) NOT NULL,last_name varchar(60) NOT NULL, PRIMARY KEY (id));");
        $stmt->execute(array());
    }
    
?>

<html>

<body>
    <form id="seed" name="seed" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="submit" value="SEED">
    </form>
</body>

</html>

<?php
    $pdo = null;
?>