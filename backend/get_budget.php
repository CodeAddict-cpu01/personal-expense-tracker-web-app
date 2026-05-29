<?php
include 'db.php';

$user_id = $_GET['user_id'];

// get budget
$budget_sql = "SELECT amount FROM budgets WHERE user_id='$user_id'";
$budget_result = $conn->query($budget_sql);
$budget_row = $budget_result->fetch_assoc();
$budget = $budget_row['amount'] ?? 0;

// FIX: sum all expenses
$expense_sql = "SELECT SUM(amount) as total FROM expenses WHERE user_id='$user_id'";
$expense_result = $conn->query($expense_sql);
$expense_row = $expense_result->fetch_assoc();

$spent = $expense_row['total'] ?? 0;

$remaining = $budget - $spent;

echo json_encode([
    "budget" => $budget,
    "spent" => $spent,
    "remaining" => $remaining
]);
?>