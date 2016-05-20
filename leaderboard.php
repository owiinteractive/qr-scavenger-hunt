<?php

    $required = $_GET["required"];
    if ($required == null) {
        $required = 5;
    }

    class Hunter {
        
        public $id;
        public $firstName;
        public $lastName;
        public $findingsMap;
        
        public function codesFound() {
            $count = 0;
            foreach($this->findingsMap as $key => $value) {
                if ($value != 0) {
                    $count = $count+1;
                }
            }
            return $count;
        }
        
    }

    include 'connect.php';

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
        <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="bootstrap.min.css">
        <link rel="stylesheet" href="main.css">
        
        <script src="jquery.js"></script>
        <script src="bootstrap.min.js"></script>
        <script src="leaderboard.js"></script>
    </head>
    <body class="middle">
        <div class="container-fluid card">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img class="logo" src="school.png"></div>
            <div class="col-xs-0 col-sm-4 col-md-6 col-lg-8"></div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><img class="logo" src="logo.png"></div>
            <div class="col-xs-12">
                <h2 class="red-text">QR CODE</h2>
                <h3 class="black-text">CHALLENGE</h3>
            </div>
        </div>
        <div class="col-xs-12">
            <table>
                <thead>
                    <tr>
                        <th class="long">Scavenger</th>
                        <th class="long">First Name</th>
                        <th class="long">Last Name</th>
                        <th class="short">QR1</th>
                        <th class="short">QR2</th>
                        <th class="short">QR3</th>
                        <th class="short">QR4</th>
                        <th class="short">QR5</th>
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
            <div class="card">
                <div class="draw-pool">
                    <h3><?php echo $required . " QR code finds are required to be eligible." ?></h3>
                    <h3>The following scavengers are eligible to win the grand prize.</h3>
                    <br>
                    <?php foreach($hunters as $hunter): ?>
                        <?php if($hunter->codesFound() >= $required): ?>
                            <h4 class="eligible"> <?php echo $hunter->firstName . " " . $hunter->lastName . " (" . $hunter->id . ") " ?> </h4>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <button class="draw-btn">DRAW PRIZE!</button>
                <h2 class="winner"></h2>
            </div>
        </div>
    </body>
</html>

<?php
    $pdo = null;
?>