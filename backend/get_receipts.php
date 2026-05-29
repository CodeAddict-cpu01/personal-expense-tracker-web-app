<?php

include 'db.php';

$user_id = $_GET['user_id'];

$result =
mysqli_query(
$conn,
"SELECT *
 FROM receipts
 WHERE user_id='$user_id'
 ORDER BY uploaded_at DESC"
);

$data = [];

while($row=mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);

?>