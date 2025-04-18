<?php
session_name("ADMIN_SESSION");
session_start();
require('../FPDF/fpdf.php');
require '../connection.php';
include('Check_token.php');

class PDF extends FPDF
{
    // Custom Footer method
    function Footer()
    {
        $this->SetY(-15); // 15 mm from bottom
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Generated by STOCKSYNC - Inventory & File Management Sys.', 0, 0, 'C');
    }
}

// Get filters
$category = $_GET['category'] ?? '';
$processor = $_GET['processor'] ?? '';
$person_name = $_GET['person_name'] ?? '';
$currentDate = date('d, M Y');

// Build SQL
$sql = "SELECT * FROM laptops WHERE 1";
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
$pdf = new PDF();
$pdf->AddPage('L');

// Title
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 10, 'Inventory Report', 0, 1, 'C');
$pdf->Ln(10);

// Header Section
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(80, 5, 'Corporate Profile.', 0, 0);
$pdf->Cell(80, 5, '', 0, 0);
$pdf->Cell(80, 5, 'Overall Details', 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(160, 5, 'Company: PTPL', 0, 0);
$pdf->Cell(25, 5, 'Category:', 0, 0);
$pdf->Cell(34, 5, (!empty($category) ? $category : 'All'), 0, 1);

$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(160, 5, 'Location: Lahore, Gulberg lll', 0, 0);
$pdf->Cell(25, 5, 'Invoice Date:', 0, 0);
$pdf->Cell(34, 5, $currentDate, 0, 1);
$pdf->Ln(12);

// Table Heading
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(180, 180, 180);
$title = (!empty($category) && !empty($processor))
    ? ucfirst($processor) . " " . ucfirst($category) . " Inventory (2017 To 2025)"
    : 'Overall Inventory (2016 To 2025)';
$pdf->Cell(280, 10, $title, 0, 1, 'C', true);

// Table Headers
$headers = [
    'S-N',
    'Brand',
    'Model',
    'Processor',
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

$widths = [
    10,   // S-N
    30,   // Brand
    22,   // Model
    22,   // Processor
    25,   // Serial No.
    25,   // Delivery Date
    18,   // Age
    22,   // Designation
    25,   // Person
    20,   // Status
    20,   // Price
    18,   // Quantity
    24    // Total
];

$pdf->SetFillColor(230, 230, 230);
foreach ($headers as $key => $header) {
    $pdf->Cell($widths[$key], 10, $header, 1, 0, 'C', true);
}
$pdf->Ln();

// Table Body
$pdf->SetFont('Arial', '', 10);
$totalSum = 0;
$Sr = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total = $row['price'] * $row['quantity'];
        $totalSum += $total;
        $data = [
            $Sr,
            $row['brand'],
            $row['model'],
            $row['processor'],
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

// Total Sum
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(array_sum($widths) - 30, 10, 'Subtotal: ', 0, 0, 'R');
$pdf->Cell(30, 10, number_format($totalSum), 1, 1, 'C');

// Output PDF
$pdf->Output();
