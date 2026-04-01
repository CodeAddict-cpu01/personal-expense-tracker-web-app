<?php
include "db.php";

$user_id = $_GET['user_id'];

// Total expense
$totalQuery = "SELECT SUM(amount) as total FROM expenses WHERE user_id='$user_id'";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);

// Count expenses
$countQuery = "SELECT COUNT(*) as count FROM expenses WHERE user_id='$user_id'";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);

echo json_encode([
    "total" => $totalRow['total'] ? $totalRow['total'] : 0,
    "count" => $countRow['count']
]);
?>