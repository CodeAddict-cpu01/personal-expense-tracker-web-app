<?php
include 'db.php';

$user_id = $_GET['user_id'];

$goal_sql =
"SELECT * FROM savings_goals
 WHERE user_id='$user_id'";

$goal_result =
mysqli_query($conn,$goal_sql);

$goal =
mysqli_fetch_assoc($goal_result);

$goal_name =
$goal['goal_name'] ?? "No Goal";

$target =
$goal['target_amount'] ?? 0;

$expense_sql =
"SELECT SUM(amount) AS total
 FROM expenses
 WHERE user_id='$user_id'";

$expense_result =
mysqli_query($conn,$expense_sql);

$expense =
mysqli_fetch_assoc($expense_result);

$spent =
$expense['total'] ?? 0;

$budget_sql =
"SELECT amount
 FROM budgets
 WHERE user_id='$user_id'
 ORDER BY id DESC
 LIMIT 1";

$budget_result =
mysqli_query($conn,$budget_sql);

$budget =
mysqli_fetch_assoc($budget_result);

$currentBudget =
$budget['amount'] ?? 0;

$savings =
$currentBudget - $spent;

$percentage =
($target > 0)
?
round(($savings/$target)*100,2)
:
0;

echo json_encode([
    "goal"=>$goal_name,
    "target"=>$target,
    "savings"=>$savings,
    "percentage"=>$percentage
]);
?>