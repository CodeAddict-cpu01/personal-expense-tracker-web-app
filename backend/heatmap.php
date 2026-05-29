<?php

include 'db.php';

$user_id = $_GET['user_id'];

$sql =
"SELECT date,
        SUM(amount) AS total
 FROM expenses
 WHERE user_id='$user_id'
 GROUP BY date
 ORDER BY date DESC";

$result =
mysqli_query($conn,$sql);

$data = [];

while($row=mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);

?>