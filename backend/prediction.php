<?php
include 'db.php';

$user_id = $_GET['user_id'];

$month = date("m");
$year = date("Y");

$budget_sql = "
SELECT amount
FROM budgets
WHERE user_id='$user_id'
AND month='$month'
AND year='$year'
";

$budget_result = mysqli_query($conn,$budget_sql);
$budget_row = mysqli_fetch_assoc($budget_result);

$budget = $budget_row['amount'] ?? 0;

$expense_sql = "
SELECT SUM(amount) AS total
FROM expenses
WHERE user_id='$user_id'
";

$expense_result = mysqli_query($conn,$expense_sql);
$expense_row = mysqli_fetch_assoc($expense_result);

$spent = $expense_row['total'] ?? 0;

$daysPassed = date("d");
$daysInMonth = date("t");

$avgDaily = ($daysPassed > 0)
    ? ($spent / $daysPassed)
    : 0;

$prediction = round($avgDaily * $daysInMonth,2);

$remainingForecast = $budget - $prediction;

$usagePercent = ($budget > 0)
    ? round(($spent / $budget) * 100)
    : 0;

if($prediction > $budget){

    $status =
    "⚠️ You may exceed your budget";

    $deficit =
    $prediction - $budget;

}else{

    $status =
    "✅ You are likely to stay within budget";

    $deficit = 0;
}

echo json_encode([
    "budget"=>$budget,
    "spent"=>$spent,
    "prediction"=>$prediction,
    "remainingForecast"=>$remainingForecast,
    "usagePercent"=>$usagePercent,
    "avgDaily"=>round($avgDaily,2),
    "daysPassed"=>$daysPassed,
    "daysInMonth"=>$daysInMonth,
    "deficit"=>$deficit,
    "status"=>$status
]);
?>