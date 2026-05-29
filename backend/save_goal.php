<?php
include 'db.php';

$user_id = $_POST['user_id'];
$goal_name = $_POST['goal_name'];
$target_amount = $_POST['target_amount'];

$check = mysqli_query(
    $conn,
    "SELECT * FROM savings_goals WHERE user_id='$user_id'"
);

if(mysqli_num_rows($check)>0){

    mysqli_query(
        $conn,
        "UPDATE savings_goals
         SET goal_name='$goal_name',
             target_amount='$target_amount'
         WHERE user_id='$user_id'"
    );

}else{

    mysqli_query(
        $conn,
        "INSERT INTO savings_goals
        (user_id,goal_name,target_amount)
        VALUES
        ('$user_id','$goal_name','$target_amount')"
    );

}

echo "Goal Saved";
?>