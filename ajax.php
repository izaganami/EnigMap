
<?php
// connect to database
$con = new mysqli("localhost", "root", "", "MapGame");
$sql = mysqli_query($con, "SELECT  * FROM objects ");
$sql2=mysqli_query($con,"SELECT username,score,time FROM `users` ORDER BY score DESC LIMIT 2");
$rows = array();
while ($row = mysqli_fetch_assoc($sql)) {
    $rows[] = $row;
}
while ($row2 = mysqli_fetch_assoc($sql2)) {
    array_push($rows,$row2) ;
}


if ($_SERVER['REQUEST_METHOD'] == "GET")
{
    echo json_encode($rows,JSON_NUMERIC_CHECK);
}


