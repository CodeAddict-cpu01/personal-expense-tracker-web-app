<?php
include "db.php";

$user_id = $_GET['user_id'];

$sql = "SELECT category, SUM(amount) as total 
        FROM expenses 
        WHERE user_id='$user_id' 
        GROUP BY category";

$result = mysqli_query($conn, $sql);

$categories = [];
$amounts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['category'];
    $amounts[] = $row['total'];
}

echo json_encode([
    "categories" => $categories,
    "amounts" => $amounts
]);
?>