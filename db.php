<?php
$conn = mysqli_connect("localhost", "root", "", "expense_tracker", 3307);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>