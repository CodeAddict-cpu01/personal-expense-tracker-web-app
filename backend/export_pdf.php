<?php

require('fpdf/fpdf.php');
include 'db.php';

$user_id = $_GET['user_id'];

// Total Expenses
$total_sql =
"SELECT SUM(amount) AS total
 FROM expenses
 WHERE user_id='$user_id'";

$total =
mysqli_fetch_assoc(
    mysqli_query($conn,$total_sql)
)['total'] ?? 0;


// Budget
$budget_sql =
"SELECT amount
 FROM budgets
 WHERE user_id='$user_id'
 ORDER BY id DESC
 LIMIT 1";

$budget =
mysqli_fetch_assoc(
    mysqli_query($conn,$budget_sql)
)['amount'] ?? 0;

$remaining = $budget - $total;


// Top Category
$category_sql =
"SELECT category,
        SUM(amount) AS total
 FROM expenses
 WHERE user_id='$user_id'
 GROUP BY category
 ORDER BY total DESC
 LIMIT 1";

$category =
mysqli_fetch_assoc(
    mysqli_query($conn,$category_sql)
);


// Transactions
$transactions_sql =
"SELECT date,
        category,
        amount
 FROM expenses
 WHERE user_id='$user_id'
 ORDER BY date DESC";

$transactions =
mysqli_query($conn,$transactions_sql);


// PDF
$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

$pdf->Cell(
    0,
    10,
    'Monthly Financial Report',
    0,
    1,
    'C'
);

$pdf->Ln(5);

$pdf->SetFont('Arial','',11);

$pdf->Cell(0,10,'Generated On: '.date("d M Y h:i A"),0,1);

$pdf->Ln(2);

$pdf->Cell(0,10,'Total Expenses: Rs '.$total,0,1);

$pdf->Cell(0,10,'Budget: Rs '.$budget,0,1);

$pdf->Cell(0,10,'Remaining Budget: Rs '.$remaining,0,1);

$pdf->Cell(
    0,
    10,
    'Top Category: '
    .($category['category'] ?? 'None')
    .' (Rs '.($category['total'] ?? 0).')',
    0,
    1
);

$pdf->Ln(5);


// Transaction Table Header

$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,10,'S.No',1);

$pdf->Cell(40,10,'Date',1);

$pdf->Cell(80,10,'Category',1);

$pdf->Cell(40,10,'Amount',1);

$pdf->Ln();


// Transaction Rows

$pdf->SetFont('Arial','',10);

$sr = 1;

while($row = mysqli_fetch_assoc($transactions)){

    $pdf->Cell(15,10,$sr++,1);

    $pdf->Cell(40,10,$row['date'],1);

    $pdf->Cell(80,10,$row['category'],1);

    $pdf->Cell(40,10,'Rs '.$row['amount'],1);

    $pdf->Ln();

}

$pdf->Ln(10);

$pdf->SetFont('Arial','B',12);

$pdf->Cell(
    0,
    10,
    'Total Transactions: '.($sr-1),
    0,
    1
);


$pdf->Output();

?>