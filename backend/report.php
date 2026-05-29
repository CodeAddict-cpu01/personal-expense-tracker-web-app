<?php
include 'db.php';

$user_id = $_GET['user_id'];

// Total Expenses
$total_sql =
"SELECT SUM(amount) AS total
 FROM expenses
 WHERE user_id='$user_id'";

$total_result =
mysqli_query($conn,$total_sql);

$total =
mysqli_fetch_assoc($total_result)['total'] ?? 0;


// Budget
$budget_sql =
"SELECT amount
 FROM budgets
 WHERE user_id='$user_id'
 ORDER BY id DESC
 LIMIT 1";

$budget_result =
mysqli_query($conn,$budget_sql);

$budget =
mysqli_fetch_assoc($budget_result)['amount'] ?? 0;


// Remaining Budget
$remaining =
$budget - $total;


// Highest Spending Category
$category_sql =
"SELECT category,
        SUM(amount) AS total
 FROM expenses
 WHERE user_id='$user_id'
 GROUP BY category
 ORDER BY total DESC
 LIMIT 1";

$category_result =
mysqli_query($conn,$category_sql);

$category =
mysqli_fetch_assoc($category_result);


// Transaction History
$transactions_sql =
"SELECT id,
        category,
        amount,
        date
 FROM expenses
 WHERE user_id='$user_id'
 ORDER BY date DESC";

$transactions_result =
mysqli_query($conn,$transactions_sql);

$transactions = [];

while($row = mysqli_fetch_assoc($transactions_result)){
    $transactions[] = $row;
}


// Recurring Expenses
$recurring_result =
mysqli_query(
$conn,
"SELECT *
 FROM recurring_expenses
 WHERE user_id='$user_id'
 ORDER BY created_at DESC"
);

$recurring = [];

while($row = mysqli_fetch_assoc($recurring_result)){
    $recurring[] = $row;
}


// Report Generated Time
$generatedOn =
date("d M Y h:i A");


// Final JSON Response
echo json_encode([

    "expenses"=>$total,

    "budget"=>$budget,

    "remaining"=>$remaining,

    "topCategory"=>$category['category'] ?? "None",

    "topAmount"=>$category['total'] ?? 0,

    "generatedOn"=>$generatedOn,

    "transactions"=>$transactions,

    "recurring"=>$recurring

]);
?>