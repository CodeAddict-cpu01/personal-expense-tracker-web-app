<?php
include 'db.php';

$user_id = $_POST['user_id'];
$name = $_POST['name'];
$amount = $_POST['amount'];
$category = $_POST['category'];
$frequency = $_POST['frequency'];

mysqli_query(
$conn,
"INSERT INTO recurring_expenses
(user_id,expense_name,amount,category,frequency)
VALUES
('$user_id','$name','$amount','$category','$frequency')"
);

echo "Recurring Expense Saved";
?>