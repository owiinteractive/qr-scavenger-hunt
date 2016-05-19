<?php

    $sessionCookieExpireTime=8*60*60;
    session_set_cookie_params($sessionCookieExpireTime);
    session_start();

    $code = $_GET['code'];

    if ($code == "JcPFvMiyqmf3cEfW") {
        Header("Location: signup.php");
    }

    include 'connect.php';

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
    $clues["AAMWFUmNgfiPQLj6"] = "Test your mettle against the computer station<br> Reach level 5 at the programming location<br> When you are done take a photo of yourself to prove your worth<br>And present it to the lecturer with the red tie and black shirt.";
    $clues["DBIhu5CmyGkpQAaE"] = "Form follows function, sometimes ...<br> Less is more, or maybe Less is a bore ...<br> Let's take a walk to A4<br> Products surround, products abound,<br> You will now need to look around";
    $clues["sEPSsfILPBdWtolW"] = "I am hidden somewhere in the classroom from whence you came<br> You just haven't looked<br> Search for me in every cranny<br> Search for me in every nook";
    $clues["Wcb4nHQ8WydYfTEZ"] = "You have reached the end of the scavenger hunt. If you found all the QR codes, your name has been entered into the prize draw. The winner will be drawn at 13:00.";

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
        
        $_SESSION["scavenger_id"] = $hunter_id;
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
        <script src="index.js"></script>
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
        <?php if($_SERVER["REQUEST_METHOD"] == "GET"): ?>
            <div class='container-fluid lead card'>
                <div class="col-xs-12">
                    <h4>Well done!</h4>
                    <h4>Please confirm your name to record this find and get the next clue.</h4>
                </div>
            </div>
            <div class='container-fluid info'>
                <div class="col-xs-12">
                    <form id="confirm" name="confirm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?code=$code"; ?>">
                        <select id="hunter-select" name="hunter-select">
                            <?php
                                echo "<option value=''>-- select --</option>";
                                for ($i = 0; $i < count($hunters); $i++) {
                                    $hunter_id = $hunters[$i]['id'];
                                    $hunter_first = $hunters[$i]['first_name'];
                                    $hunter_last = $hunters[$i]['last_name'];
                                    if ($_SESSION["scavenger_id"] != null && $_SESSION["scavenger_id"] == $hunter_id) {
                                        echo "<option value='$hunter_id' selected='selected'>$hunter_first $hunter_last</option>";
                                    } else {
                                        echo "<option value='$hunter_id'>$hunter_first $hunter_last</option>";
                                    }
                                }
                            ?>
                        </select>
                        <input id="confirm-button" type="submit" value="CONFIRM" disabled>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class='container-fluid lead card'><div class="col-xs-12"> <?php echo $messages[$code]; ?> </div></div>
            <div class='container-fluid clue'><div class="col-xs-12"> <?php echo $clues[$code]; ?> </div></div>
        <?php endif; ?>
    </body>
</html>

<?php
    $pdo = null;
?>