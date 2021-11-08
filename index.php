<?php
session_start();
require 'header.php';
require 'includes/database.inc.php';

//Get all countdowns
$sql = "SELECT CountdownTime, CountdownName FROM countdowntime";
$results = $conn->query($sql);

//Get current date
date_default_timezone_set('Europe/Kiev');
$currentDate = date("Y-m-d G:i:s", time());

// //Delete countdowns which countdown time passed
foreach ($results as $result) {
    if ($result["CountdownTime"] < $currentDate) {
        $delete = $result["CountdownTime"];
        $sqlDelete = "DELETE FROM countdowntime WHERE CountdownTime = '$delete'";
        mysqli_query($conn, $sqlDelete);
    }
}

//Get new countdowns after cleaning database
$afterDelete = "SELECT CountdownTime, CountdownName FROM countdowntime";
$countdownResults = $conn->query($afterDelete);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/styles.css">
    <title>Timer</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script>
        $(document).ready(function() {
            $("#countdownTimer").load("includes/countdown.inc.php");
            setInterval(function() {
                $("#countdownTimer").load("includes/countdown.inc.php");
            }, 1000);
        });
    </script>
</head>

<body>

    <div id="countdownTimer"></div>
    
    <div style="text-align:center; margin: 10vh;" class="selectForm">
        <span>Choose below countdown timer until...</span>

        <form method="POST">
            <select style="margin: 2vh;" name="selectCountdownName" id="selectName">
                <option value="Clear">Clear</option>
                <?php foreach ($countdownResults as $names) : ?>
                    <option value="<?= $names['CountdownName']; ?>"><?= $names['CountdownName']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <input style="margin: 0.5vh;" type="submit" name="FormSubmit">
        </form>

        <?php
        if (isset($_POST['FormSubmit'])) {
            $_SESSION['selectedValue'] = $_POST['selectCountdownName'];
        }
        ?>
    </div>
</body>

</html>