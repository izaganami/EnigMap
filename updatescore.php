<?php
$con = new mysqli("localhost", "root", "", "MapGame");
$player = $_POST['player'];
echo $player;
$score = $_POST['score'];
echo $score;
$time = $_POST['time'];
echo $time;
$sql = mysqli_query($con, "UPDATE users SET score = $score , time= $time WHERE username = '$player' ");

##$sql = mysqli_query($con, "UPDATE 'users' SET  'score' = '$score' , 'time' = '$time' WHERE 'users'.'username' = '$player';");
echo $sql;
