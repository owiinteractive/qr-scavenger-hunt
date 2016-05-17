<?php

    $code = $_GET['code'];

    if ($code == "JcPFvMiyqmf3cEfW") {
        Header("Location: signup.php");
    }

    $user = 'root';
    $pass = 'mysql';
    $pdo = new PDO('mysql:host=localhost;dbname=scavanger_hunt', $user, $pass);

    $fetchStmt = $pdo->prepare("SELECT * FROM hunters;");
    $fetchStmt->execute(array());
    $hunters = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);

    $messages = array();
    $messages["crif2nkrth647t0A"] = "Well done! Here is the next clue.";
    $messages["AAMWFUmNgfiPQLj6"] = "This next clue takes the shape of a challenge";
    $messages["DBIhu5CmyGkpQAaE"] = "Well done on coming this far! You are almost done.";
    $messages["sEPSsfILPBdWtolW"] = "This is the last clue!";
    $messages["Wcb4nHQ8WydYfTEZ"] = "Well done!";

    $clues = array();
    $clues["crif2nkrth647t0A"] = "Processes are followed<br> Processes are made<br> I am hidden amongst<br> The documents displayed";
    $clues["AAMWFUmNgfiPQLj6"] = "Test your mettle against the computer station<br> Reach level 5 at the programming location<br> When you are done take a photo of yourself to prove your worth<br> And present it to the lecturer with the red shirt";
    $clues["DBIhu5CmyGkpQAaE"] = "Form follows function, sometimes ...<br> Less is more, or maybe Less is a bore ...<br> Let's take a walk to A4<br> Products surround, products abound, You will now need to look around";
    $clues["sEPSsfILPBdWtolW"] = "I am hidden somewhere in the classroom<br> You just haven't looked<br> Search for me in every cranny<br> Search for me in every nook";
    $clues["Wcb4nHQ8WydYfTEZ"] = "You have reached the end of the scavenger hunt. The winner will be drawn at 13:00.";

    $ids = array();
    $ids["crif2nkrth647t0A"] = 1;
    $ids["AAMWFUmNgfiPQLj6"] = 2;
    $ids["DBIhu5CmyGkpQAaE"] = 3;
    $ids["sEPSsfILPBdWtolW"] = 4;
    $ids["Wcb4nHQ8WydYfTEZ"] = 5;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $hunter_id = $_POST["hunter-select"];
        $clue_id = $ids[$code];
        
        $updateStmt = $pdo->prepare("UPDATE findings SET found=1 WHERE hunter_id=? AND clue_id=?;");
        $updateStmt->execute(array($hunter_id, $clue_id));
    }
?>

<html>
    <head>
        <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="bootstrap.min.css">
        <link rel="stylesheet" href="main.css">
        
        <script src="jquery.js"></script>
        <script src="bootstrap.min.js"></script>
        <script src="index.js"></script>
    </head>
    <body class="container-fluid">
        <div class="middle col-xs-12">
            <h2 class="red-text">QR CODE</h2>
            <h3 class="black-text">CHALLENGE</h3>
            <?php if($_SERVER["REQUEST_METHOD"] == "GET"): ?>
                <div class='confirm'>
                    Well done!
                    Please confirm your name to record this find.
                    <form id="confirm" name="confirm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?code=$code"; ?>">
                        <select id="hunter-select" name="hunter-select">
                            <?php
                                echo "<option value=''>-- select --</option>";
                                for ($i = 0; $i < count($hunters); $i++) {
                                    $hunter_id = $hunters[$i]['id'];
                                    $hunter_first = $hunters[$i]['first_name'];
                                    $hunter_last = $hunters[$i]['last_name'];
                                    echo "<option value='$hunter_id'>$hunter_first $hunter_last</option>";
                                }
                            ?>
                        </select>
                        <input id="confirm-button" type="submit" value="CONFIRM" disabled>
                    </form>
                </div>
            <?php else: ?>
                <div class='lead'> <?php echo $messages[$code]; ?> </div>
                <div class='clue'> <?php echo $clues[$code]; ?> </div>
            <?php endif; ?>
        </div>
    </body>
</html>

<?php
    $pdo = null;
?>