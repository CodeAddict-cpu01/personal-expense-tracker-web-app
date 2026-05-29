<?php
include 'db.php';

$user_id = $_GET['user_id'];

$month = date("m");
$year = date("Y");

// budget
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

// spent
$expense_sql = "
SELECT SUM(amount) AS total
FROM expenses
WHERE user_id='$user_id'
";

$expense_result = mysqli_query($conn,$expense_sql);
$expense_row = mysqli_fetch_assoc($expense_result);

$spent = $expense_row['total'] ?? 0;

$remaining = $budget - $spent;

// Budget usage score
$usagePercent = ($budget > 0)
? ($spent / $budget) * 100
: 0;

if($usagePercent <= 50){
    $score1 = 40;
}
elseif($usagePercent <= 80){
    $score1 = 30;
}
elseif($usagePercent <= 100){
    $score1 = 20;
}
else{
    $score1 = 0;
}

// Remaining score
if($remaining > ($budget * 0.5)){
    $score2 = 40;
}
elseif($remaining > ($budget * 0.2)){
    $score2 = 30;
}
elseif($remaining > 0){
    $score2 = 20;
}
else{
    $score2 = 0;
}

// Consistency
$score3 = 20;

$healthScore = $score1 + $score2 + $score3;

if($healthScore >= 80){
    $status = "Excellent";
}
elseif($healthScore >= 60){
    $status = "Good";
}
elseif($healthScore >= 40){
    $status = "Average";
}
else{
    $status = "Needs Improvement";
}

echo json_encode([
    "score"=>$healthScore,
    "status"=>$status,
    "remaining"=>$remaining
]);
?>