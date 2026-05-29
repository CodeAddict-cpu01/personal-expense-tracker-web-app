<?php
include "db.php";

$user_id = $_POST['user_id'];
$amount = $_POST['amount'];
$category = $_POST['category'];
$date = $_POST['date'];

$sql = "INSERT INTO expenses (user_id, amount, category, date)
        VALUES ('$user_id', '$amount', '$category', '$date')";

if (mysqli_query($conn, $sql)) {
    echo "Expense Added";
} else {
    echo "Error";
}
?>