<?php
include 'header.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/styles.css">
    <title>New Timer</title>
</head>
<body>

    <h1 class="heading">Fill the form to start countdown</h1>

    <?php 
          //Handling error and show them on screen not in url
          if (isset($_GET['error'])) {
              if ($_GET['error'] == "emptyfields") {
                  echo '<p class="error">Fill in all fields!</p>';
              }
                else if ($_GET['error'] == "countdownnametaken") {
                  echo '<p class="error">Countdown name already taken!</p>';
              }
          }
      ?>

    <div class = "formDiv">
        <form action="includes/newCountdownTimer.inc.php" method="POST">

        <?php
                    //Get username or email from url if there was something wrong during sign up proccess and leave them in textbox if they were correct 
                        if (isset($_GET['endTimeDate'])) {
                            $endTimeDate = $_GET['endTimeDate'];
                            echo '<span>Choose date: </span><input type="date" name="endTimeDate" value="'.$endTimeDate.'"><br>';
                        } 
                        else {
                            echo '<span>Choose date: </span><input type="date" name="endTimeDate"><br>';
                        }

                        if (isset($_GET['hours'])) {
                            $hours = $_GET['hours'];
                            echo '<span>Enter hours: </span><input type="number" name="hours" min="0" max="24" placeholder="0" value="'.$hours.'"><br>';
                        } 
                        else {
                            echo '<span>Enter hours: </span><input type="number" name="hours" min="0" max="24" placeholder="0"><br>';
                        }

                        if (isset($_GET['minutes'])) {
                            $minutes = $_GET['minutes'];
                            echo '<span>Enter minutes: </span><input type="number" name="minutes" min="0" max="59" placeholder="0-59" value="'.$minutes.'"><br>';
                        } 
                        else {
                            echo '<span>Enter minutes: </span><input type="number" name="minutes" min="0" max="59" placeholder="0-59"><br>';
                        }

                        if (isset($_GET['seconds'])) {
                            $seconds = $_GET['seconds'];
                            echo '<span>Enter seconds: </span><input type="number" name="seconds" min="0" max="60" placeholder="0-60" value="'.$seconds.'"><br>';
                        } 
                        else {
                            echo '<span>Enter seconds: </span><input type="number" name="seconds" min="0" max="60" placeholder="0-60"><br>';
                        }

                        if (isset($_GET['timerName'])) {
                            $timerName = $_GET['timerName'];
                            echo ' <span>Enter countdown name: </span><input type="text" name="timerName" value="'.$timerName.'"><br>';
                        } 
                        else {
                            echo ' <span>Enter countdown name: </span><input type="text" name="timerName"><br>';
                        }
                    ?>
            <input class="button" type="submit" name="timer-submit">
        </form>
    </div>

</body>
</html>