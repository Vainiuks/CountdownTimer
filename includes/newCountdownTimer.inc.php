<?php

require 'database.inc.php';

if (isset($_POST['timer-submit'])) {
    $countdownTime = $_POST['endTimeDate'];
    $countdownHours = $_POST['hours'];
    $countdownMinutes = $_POST['minutes'];
    $countdownSeconds = $_POST['seconds'];
    $countdownName = $_POST['timerName'];

    $countdownDateAndTime = $countdownTime . " " . $countdownHours . ":" . $countdownMinutes . ":" . $countdownSeconds;

    if (empty($countdownTime) || empty($countdownName) or empty($countdownHours) or empty($countdownMinutes) or empty($countdownSeconds)) {
        header("Location: ../newTimerForm.php?error=emptyfields&endTimeDate=" . $countdownTime."&hours=".$countdownHours."&minutes=".$countdownMinutes."&seconds=".$countdownSeconds."&timerName=".$countdownName);
        exit();
    } else {
        $sql = "SELECT CountdownName FROM countdown WHERE CountdownName=?";
        $statement = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            header("Location: ../newTimerForm.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($statement, "s", $countdownName);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $countdownNameCheck = mysqli_stmt_num_rows($statement);
        if ($countdownNameCheck > 0) {
            header("Location: ../newTimerForm.php?error=countdownnametaken&endTimeDate=" . $countdownTime."&hours=".$countdownHours."&minutes=".$countdownMinutes."&seconds=".$countdownSeconds);
            exit();
        } else {

            //Using prepared statement inserst user into database also hash the password
            $sql = "INSERT INTO countdown (CountdownTime, CountdownName ) VALUES (?, ?)";
            $statement = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($statement, $sql)) {
                header("Location: ../newTimerForm.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($statement, "ss", $countdownDateAndTime, $countdownName);
                mysqli_stmt_execute($statement);
                header("Location: ../index.php?newcountdown=success");
                exit();
            }
        }
    }

    //End prepared statement process
    mysqli_stmt_close($statement);
    //Close db connection
    mysqli_close($conn);

} else {
header("Location: ../newTimerForm.php");
exit();
}
