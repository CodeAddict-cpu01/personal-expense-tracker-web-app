<?php

include 'db.php';

if(
    !isset($_POST['user_id']) ||
    !isset($_FILES['receipt'])
){
    die("Access through application only");
}

$user_id = $_POST['user_id'];

$file = $_FILES['receipt'];

$fileName =
time() . "_" . basename($file['name']);

move_uploaded_file(
    $file['tmp_name'],
    "../uploads/" . $fileName
);

mysqli_query(
    $conn,
    "INSERT INTO receipts
    (user_id,file_name)
    VALUES
    ('$user_id','$fileName')"
);

echo "Receipt Uploaded Successfully";

?>