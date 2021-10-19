<?php
session_start();
include 'database.inc.php';

$months = 0;
$days = 0;
$hours = 0;
$minutes = 0;
$seconds = 0;
$countdownName = "Timer";

$afterDelete = "SELECT CountdownTime, CountdownName FROM countdown";
$countdownResults = $conn->query($afterDelete);

    //Get selected value from SESSION
    $selectedName = $_SESSION['selectedValue'];
    $foreachCounter = 0;
    $endTimeDate = "";

    //Get countdown time by selected countdown name and set to variable
    if ($selectedName != "Clear") {
        if ($foreachCounter == 0) {
            foreach ($countdownResults as $result) {
                if ($result["CountdownName"] == $selectedName) {
                    $endTimeDate = $result["CountdownTime"];
                    $foreachCounter++;
                }
            }
        }
    }

    if ($endTimeDate == "" || $selectedName == "" || $endTimeDate == "Clear" || $selectedName == "Clear") {

        $months = 0;
        $days = 0;
        $hours = 0;
        $minutes = 0;
        $seconds = 0;

    } else {

        //set countdown name
        $countdownName = $selectedName;
        //Set my time zone
        date_default_timezone_set('Europe/Kiev');
        //Get today date  
        $currentDate = date("Y-m-d G:i:s", time());
        //Set countdown end date;
        $countdownDate = $endTimeDate;
        //Get year month
        $currentYear = date("Y");
        //Get days in february by this year
        $daysInFebruary = cal_days_in_month(CAL_GREGORIAN, 2, $currentYear);
        //Get current month
        $currentMonth = date("m");
        //Create array with months and days
        $daysAndMonths = array(
            array(1, 31),
            array(2, $daysInFebruary),
            array(3, 31),
            array(4, 30),
            array(5, 31),
            array(6, 30),
            array(7, 31),
            array(8, 31),
            array(9, 30),
            array(10, 31),
            array(11, 30),
            array(12, 31)
        );

        //Convert string to time format
        $datetime1 = strtotime($currentDate);
        $datetime2 = strtotime($countdownDate);

        //Get seconds by subtracting two date times
        $dateDiff = $datetime2 - $datetime1;

        for ($i = 0; $i < 1; $i++) {
            for ($j = 0; $j < count($daysAndMonths); $j++) {
                //Check if current month exists in daysAndMonths array. If so change equation(divide or multiply by days in current month) by getting month and days till countdown ends
                if ($currentMonth == $daysAndMonths[$j][0]) {
                    //Get months, days, hours, minutes, seconds till countdown end
                    $months = floor($dateDiff / (60 * 60 * 24 * $daysAndMonths[$j][1]));
                    $days = floor(($dateDiff / (60 * 60 * 24)) % $daysAndMonths[$j][1]);
                    $hours = floor(($dateDiff % (60 * 60 * 24)) / (60 * 60));
                    $minutes = floor(($dateDiff % (60 * 60)) / 60);
                    $seconds = floor($dateDiff % 60);
                }
            }
        }
    }
?>

<div class="timer">
    <div class="timerName"><?php echo $countdownName; ?></div>

    <div class="countdown">
        <div class="time">
            <h2 id="months"><?php echo $months; ?></h2>
            <small>Month</small>
        </div>

        <div class="time">
            <h2 id="days"><?php echo $days; ?></h2>
            <small>Days</small>
        </div>

        <div class="time">
            <h2 id="hours"><?php echo $hours; ?></h2>
            <small>Hours</small>
        </div>

        <div class="time">
            <h2 id="minutes"><?php echo $minutes; ?></h2>
            <small>Minutes</small>
        </div>

        <div class="time">
            <h2 id="seconds"><?php echo $seconds; ?></h2>
            <small>Seconds</small>
        </div>
    </div>
</div>
