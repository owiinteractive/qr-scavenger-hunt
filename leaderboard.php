<?php

    class Hunter {
        
        public $id;
        public $firstName;
        public $lastName;
        public $findingsMap;
        
        public function getFindingByClue($clue_id) {
            if ($findingsMap[$clue_id] === 0) {
                return "no";
            } else {
                return "yes";
            }
        }
    }

    $user = 'root';
    $pass = 'mysql';
    $pdo = new PDO('mysql:host=localhost;dbname=scavanger_hunt', $user, $pass);

    $hunterStmt = $pdo->prepare("SELECT * FROM hunters;");
    $hunterStmt->execute(array());
    $hunters = array();

    foreach ($hunterStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $hunter = new Hunter();
        $hunter->id = $row["id"];
        $hunter->firstName = $row["first_name"];
        $hunter->lastName = $row["last_name"];
        $hunter->findingsMap = array();
        
        $findingStmt = $pdo->prepare("SELECT * FROM findings where hunter_id=?;");
        $findingStmt->execute(array($hunter->id));
        $result = $findingStmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($result as $finding) {
            $hunter->findingsMap[$finding["clue_id"]] = $finding["found"];
        }
        $hunters[$hunter->id] = $hunter;
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <h3>Open Window Scavenger Hunt</h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Scavenger</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>QR1</th>
                        <th>QR2</th>
                        <th>QR3</th>
                        <th>QR4</th>
                        <th>QR5</th>
                    </tr>
                </thead>
                <?php foreach($hunters as $hunter): ?>
                <tr>
                    <td><?php echo $hunter->id; ?></td>
                    <td><?php echo $hunter->firstName; ?></td>
                    <td><?php echo $hunter->lastName; ?></td>
                    <?php
                        foreach($hunter->findingsMap as $key => $value) {
                            if ($value == 1) {
                                echo "<td class='yes'></td>";
                            } else {
                                echo "<td class='no'></td>";
                            }
                        }
                    ?>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html>