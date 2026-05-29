<?php
include 'db.php';

$user_id = $_GET['user_id'];

$expense_sql =
"SELECT SUM(amount) AS total
 FROM expenses
 WHERE user_id='$user_id'";

$expense =
mysqli_fetch_assoc(
mysqli_query($conn,$expense_sql)
);

$total =
$expense['total'] ?? 0;


$category_sql =
"SELECT category,
        SUM(amount) AS total
 FROM expenses
 WHERE user_id='$user_id'
 GROUP BY category
 ORDER BY total DESC
 LIMIT 1";

$category =
mysqli_fetch_assoc(
mysqli_query($conn,$category_sql)
);

$topCategory =
$category['category'] ?? 'None';

$topAmount =
$category['total'] ?? 0;


$percentage =
$total > 0
?
round(($topAmount/$total)*100)
:
0;

$tips = [];

if($percentage > 40){

    $tips[] =
    "⚠️ ".$topCategory.
    " spending accounts for ".
    $percentage.
    "% of your expenses.";

}

if($percentage > 60){

    $tips[] =
    "💡 Consider reducing spending in ".
    $topCategory.".";
}

$tips[] =
"✅ Keep monitoring your expenses regularly.";

echo json_encode([
    "tips"=>$tips
]);
?>