<?php

    $sessionCookieExpireTime=8*60*60;
    session_set_cookie_params($sessionCookieExpireTime);
    session_start();

    $last_name = $first_name = "";

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    include 'connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {            
        $first_name = test_input($_POST["first_name"]);
        $last_name = test_input($_POST["last_name"]);

        $valid = true;
        if ($first_name == "" || $last_name == "") {
            $valid = false;
            $error = "<img src='error.png'>Please try again. Note that both fields are required.";
        } else {
            $fetchStmt = $pdo->prepare("SELECT * FROM hunters WHERE first_name=? AND last_name=?;");
            $fetchStmt->execute(array($first_name, $last_name));
            $result = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                $valid = false;
                $id = $result[0]["id"];
                $error = "<img src='error.png'>This name has already been registered to scavenger number $id.";
            }
        }

        if ($valid) {
            $insertStmt = $pdo->prepare("INSERT INTO hunters(first_name, last_name) VALUES (?, ?);");
            $insertStmt->execute(array($first_name, $last_name));

            $fetchStmt = $pdo->prepare("SELECT * FROM hunters WHERE first_name=? AND last_name=?;");
            $fetchStmt->execute(array($first_name, $last_name));
            $result = $fetchStmt->fetch(PDO::FETCH_ASSOC);

            $id = $result['id'];

            $insertStmt = $pdo->prepare("INSERT INTO findings(hunter_id, clue_id, found) VALUES (?, ?, 0);");
            $insertStmt->execute(array($id, 1));
            $insertStmt->execute(array($id, 2));
            $insertStmt->execute(array($id, 3));
            $insertStmt->execute(array($id, 4));
            $insertStmt->execute(array($id, 5));
            
            $_SESSION["scavenger_id"] = $id;
        }
    }
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="bootstrap.min.css">
        <link rel="stylesheet" href="main.css">
        
        <script src="jquery.js"></script>
        <script src="bootstrap.min.js"></script>
    </head>
    <body class="middle">
        <div class="container-fluid card">
            <div class="col-xs-6"><img class="logo" src="school.png"></div>
            <div class="col-xs-6"><img class="logo" src="logo.png"></div>
            <h2 class="red-text">QR CODE</h2>
            <h3 class="black-text">CHALLENGE</h3>
        </div>
        <?php if($_SERVER["REQUEST_METHOD"] == "POST" && $valid): ?>
            <div class="container-fluid lead">
                <?php
                    echo "Thank you for signing up $first_name $last_name <br>
                    Your scavenger number is $id. <br>
                    Here is your first clue. Good luck!";
                ?>
            </div>
            <div class="container-fluid clue">
                Blood, sweat, toil and tears<br>
                All this work is a culmination of years<br>
                I am hidden amongst pages<br>
                Of all the student work throughout the ages<br>
            </div>
        <?php else: ?>
            <div class='container-fluid info'>
                <h4>Please enter your name so we can track which codes you find.</h4>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && !$valid) {
                        echo "<h4 class='error'>$error</h4>";
                    }
                ?>
                <form id="signup" name="signup" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="col-xs-6">
                        <label for="first_name">First Name:</label>
                    </div>
                    <div class="col-xs-6">
                        <input name="first_name" type="text" value="<?php echo $first_name; ?>">
                    </div>
                    <div class="col-xs-6">
                        <label for="last_name">Last Name:</label>
                    </div>
                    <div class="col-xs-6">
                        <input name="last_name" type="text" value="<?php echo $last_name; ?>">
                    </div>
                    <div class="padtop col-xs-12">
                        <input type="submit" value="START!">
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </body>
</html>

<?php
    $pdo = null;
?>