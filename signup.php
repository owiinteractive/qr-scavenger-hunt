<?php
        $last_name = $first_name = "";

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }

        $user = 'root';
        $pass = 'mysql';
        $pdo = new PDO('mysql:host=localhost;dbname=scavanger_hunt', $user, $pass);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {            
            $first_name = test_input($_POST["first_name"]);
            $last_name = test_input($_POST["last_name"]);
            
            $valid = true;
            if ($first_name == "" || $last_name == "") {
                $valid = false;
                $error = "Please try again. Note that both fields are required.";
            } else {
                $fetchStmt = $pdo->prepare("SELECT * FROM hunters WHERE first_name=? AND last_name=?;");
                $fetchStmt->execute(array($first_name, $last_name));
                $result = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($result) > 0) {
                    $valid = false;
                    $id = $result[0]["id"];
                    $error = "This name has already been registered to scavenger number $id.";
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
            }
        }
?>

<html>
    <head></head>
    <body>
        <h3>Open Window Scavenger Hunt</h3>
        <div>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && !$valid) {
                    echo "<div class='error'>$error</div>";
                }
            ?>
            <?php if($_SERVER["REQUEST_METHOD"] == "POST" && $valid): ?>
                <div class="lead">
                    <?php
                        echo "Thank you for signing up $first_name $last_name <br>
                        Your scavenger number is $id. <br>
                        Here is your first clue. Good luck!";
                    ?>
                </div>
                <div class="clue">
                    Blood, sweat, toil and tears<br>
                    All this work is a culmination of years<br>
                    I am hidden amongst pages<br>
                    Of all the student work throughout the ages<br>
                </div>
            <?php else: ?>
                <div class='intro'>Please enter your name so we can track which codes you find.</div>
                <form id="signup" name="signup" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <label for="first_name">First Name:</label>
                    <input name="first_name" type="text">
                    <label for="last_name">Last Name:</label>
                    <input name="last_name" type="text">
                    <input type="submit" value="START">
                </form>
            <?php endif; ?>
        </div>
    </body>
</html>

<?php
    $pdo = null;
?>