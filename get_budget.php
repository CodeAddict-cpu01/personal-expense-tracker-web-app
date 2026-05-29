<?php
include "db.php";

$user_id = $_GET['user_id'];
$month = date("m");
$year = date("Y");

// get budget
$budgetQuery = "SELECT amount FROM budgets 
                WHERE user_id='$user_id' AND month='$month' AND year='$year'";
$budgetResult = mysqli_query($conn, $budgetQuery);
$budgetRow = mysqli_fetch_assoc($budgetResult);

// get expense
$expenseQuery = "SELECT SUM(amount) as total FROM expenses 
                 WHERE user_id='$user_id' AND MONTH(date)='$month'";
$expenseResult = mysqli_query($conn, $expenseQuery);
$expenseRow = mysqli_fetch_assoc($expenseResult);

$budget = $budgetRow['amount'] ?? 0;
$spent = $expenseRow['total'] ?? 0;

$remaining = $budget - $spent;

echo json_encode([
    "budget" => $budget,
    "spent" => $spent,
    "remaining" => $remaining
]);
?>