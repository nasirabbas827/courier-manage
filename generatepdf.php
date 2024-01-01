<?php
require('./fpdf/fpdf.php');
include('config.php');

if (isset($_GET['parcel_id'])) {
    $parcelID = $_GET['parcel_id'];

    // Fetch parcel data based on the parcel_id
    $query = "SELECT * FROM Parcels WHERE ParcelID = $parcelID";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Create a new PDF instance
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial', 'B', 16);

        // Add content to the PDF
        $pdf->Cell(40, 10, 'Parcel Information');

        // Set font for the data
        $pdf->SetFont('Arial', '', 12);

        // Add data to the PDF
        $pdf->Ln(10); // Add a line break
        $pdf->Cell(40, 10, 'ParcelID: ' . $row['ParcelID']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Sender Name: ' . $row['SenderName']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Sender Email: ' . $row['SenderEmail']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Sender Address: ' . $row['SenderAddress']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Recipient Name: ' . $row['RecipientName']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Recipient Email: ' . $row['RecipientEmail']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Recipient Address: ' . $row['RecipientAddress']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Weight: ' . $row['Weight']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Date: ' . $row['Date']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Time: ' . $row['Time']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Amount: ' . $row['Amount']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Status: ' . $row['Status']);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Estimated Delivery Time ( Days ): ' . $row['EstimatedDeliveryTime']);
        
        // Output the PDF as a file (force download)
        $pdf->Output('ParcelInformation.pdf', 'D');
    } else {
        echo "Parcel not found.";
    }
} else {
    echo "Parcel ID not provided.";
}
?>
