<?php
session_name("ADMIN_SESSION");
session_start();
require('../FPDF/fpdf.php');
require '../connection.php';
// file to not allow admin to directly access admin panel until they are login
include('Check_token.php');

// Get the selected category and processor from the form submission
$category = isset($_GET['category']) ? $_GET['category'] : '';
$processor = isset($_GET['processor']) ? $_GET['processor'] : '';
$person_name = isset($_GET['person_name']) ? $_GET['person_name'] : '';

// Construct the SQL query with filtering
$sql = "SELECT * FROM laptops WHERE 1";
$currentDate = date('d, M Y');

if (!empty($category)) {
    $sql .= " AND category = '" . mysqli_real_escape_string($con, $category) . "'";
}

if (!empty($processor)) {
    $sql .= " AND processor = '" . mysqli_real_escape_string($con, $processor) . "'";
}
if (!empty($person_name)) {
    $sql .= " AND person_name = '" . mysqli_real_escape_string($con, $person_name) . "'";
}

$result = $con->query($sql);

// Create PDF
$pdf = new FPDF();
$pdf->AddPage('L');

// Title
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 10, 'Inventory Report', 0, 1, 'C');
$pdf->Ln(10);

// Header Section
$pdf->SetFont('Arial', 'B', 14);
$pdf->cell(10, 5, '', 0, 0);
$pdf->Cell(80, 5, 'Corporate Profile.', 0, 0);
$pdf->Cell(80, 5, '', 0, 0);
$pdf->Cell(80, 5, 'Overall Details', 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 10);
$pdf->cell(10, 5, '', 0, 0);
$pdf->Cell(160, 5, 'Company: PTPL', 0, 0);
$pdf->Cell(25, 5, 'Category:', 0, 0);
$pdf->Cell(34, 5, (!empty($category) ? $category : 'All'), 0, 1);

$pdf->cell(10, 5, '', 0, 0);

$pdf->Cell(160, 5, 'Location: Lahore, Gulberg lll', 0, 0);
$pdf->Cell(25, 5, 'Invoice Date:', 0, 0);
$pdf->Cell(34, 5, $currentDate, 0, 1);


$pdf->Ln(12);

// Table Header Section
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(180, 180, 180);
$pdf->Cell(280, 10, (!empty($category) && !empty($processor) ? ucfirst($processor) . " " . ucfirst($category) . " Inventory (2017 To 2025)" : 'Overall Inventory (2016 To 2025)'), 0, 1, 'C', true);

// Product Information Table Header
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230); // Light Gray Background

// Adjusted widths for the landscape layout
$widths = [
    10,
    40,
    30,
    30,
    30,
    30,
    30,
    20,
    20,
    20,
    20,
    20
];

$headers = [
    'S-N',
    'Brand',
    'Serial No.',
    'Delivery Date',
    'Age',
    'Designation',
    'Person',
    'Status',
    'Price',
    'Quantity',
    'Total'
];

// Generate header
foreach ($headers as $key => $header) {
    $pdf->Cell($widths[$key], 10, $header, 1, 0, 'C', true);
}
$pdf->Ln();

// Example Product Data from Database
$pdf->SetFont('Arial', '', 10);
$totalSum = 0;
$Sr = 1;

if ($result->num_rows > 0) {
    // Output each laptop product record
    while ($row = $result->fetch_assoc()) {
        $total = $row['price'] * $row['quantity'];
        $totalSum += $total;

        $data = [
            $Sr,
            $row['brand'],
            $row['serialNumber'],
            $row['delivery_date'],
            $row['total_age'],
            $row['designation'],
            $row['person_name'],
            $row['status'],
            $row['price'],
            $row['quantity'],
            $total
        ];

        foreach ($data as $key => $value) {
            $pdf->Cell($widths[$key], 10, $value, 1, 0, 'C');
        }
        $pdf->Ln();
        $Sr++;
    }
} else {
    $pdf->Cell(array_sum($widths), 10, 'No data available', 1, 1, 'C');
}

// Display Total Sum
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(array_sum($widths) - 50, 10, 'Subtotal: ', 0, 0, 'R');
$pdf->Cell(30, 10, number_format($totalSum), 1, 1, 'C');

// Footer Section
$pdf->SetY(-40);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Generated by Inventory Management System', 0, 1, 'C');

$pdf->Output();
