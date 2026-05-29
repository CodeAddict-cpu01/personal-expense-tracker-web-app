<?php
include "db.php";

$user_id = $_POST['user_id'];
$amount = $_POST['amount'];
$month = date("m");
$year = date("Y");

// check if budget exists
$check = "SELECT * FROM budgets WHERE user_id='$user_id' AND month='$month' AND year='$year'";
$result = mysqli_query($conn, $check);

if (mysqli_num_rows($result) > 0) {
    // update
    $sql = "UPDATE budgets SET amount='$amount' 
            WHERE user_id='$user_id' AND month='$month' AND year='$year'";
} else {
    // insert
    $sql = "INSERT INTO budgets (user_id, amount, month, year)
            VALUES ('$user_id', '$amount', '$month', '$year')";
}

mysqli_query($conn, $sql);

echo "Budget Saved";
?>