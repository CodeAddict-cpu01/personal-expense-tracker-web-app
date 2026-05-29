<?php
include 'db.php';

$user_id = $_GET['user_id'];

// Total expenses
$total_sql = "SELECT SUM(amount) AS total
              FROM expenses
              WHERE user_id='$user_id'";

$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);

$total = $total_row['total'] ?? 0;

// Highest category
$category_sql = "
SELECT category,
       SUM(amount) AS category_total
FROM expenses
WHERE user_id='$user_id'
GROUP BY category
ORDER BY category_total DESC
LIMIT 1
";

$category_result = mysqli_query($conn, $category_sql);

if(mysqli_num_rows($category_result) > 0){

    $row = mysqli_fetch_assoc($category_result);

    $category = $row['category'];
    $category_total = $row['category_total'];

    $percentage = $total > 0
        ? round(($category_total / $total) * 100, 2)
        : 0;

} else {

    $category = "No Data";
    $category_total = 0;
    $percentage = 0;
}

echo json_encode([
    "category" => $category,
    "amount" => $category_total,
    "percentage" => $percentage
]);
?>