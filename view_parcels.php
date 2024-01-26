<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION["user_id"];

// Fetch parcels with additional information
$query = "SELECT p.*, b.BranchName, b.ContactNumber AS BranchContactNumber 
          FROM Parcels p 
          LEFT JOIN Branches b ON p.ReceiverBranchID = b.BranchID 
          WHERE UserID = $userID";
$result = mysqli_query($conn, $query);

// Handle parcel deletion if the delete button is clicked
if (isset($_GET['delete_id'])) {
    $deleteID = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM Parcels WHERE ParcelID = $deleteID";
    
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Parcel deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting parcel');</script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Parcels</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<?php
include('navbar.php');
?>
<div class="container mt-5">
    <h2 class="text-center">View Parcels</h2>

    <!-- Display parcels in a responsive table -->
    <div class="table-responsive">
        <table class="table">
            <a class="m-2 btn btn-outline-success float-right" href="add_parcel.php">Add New Parcel</a>

            <thead>
                <tr>
                    <th>ParcelID</th>
                    <th>Sender Name</th>
                    <th>Sender Email</th>
                    <th>Sender Phone</th>
                    <th>Sender Address</th>
                    <th>Recipient Name</th>
                    <th>Recipient Email</th>
                    <th>Recipient Phone</th>
                    <th>Recipient Address</th>
                    <th>Weight</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Estimated Delivery Time (Days)</th>
                    <th>Delivery Requested</th>
                    <th>Recipient Branch</th>
                    <th>Branch Contact Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['ParcelID']}</td>";
                    echo "<td>{$row['SenderName']}</td>";
                    echo "<td>{$row['SenderEmail']}</td>";
                    echo "<td>{$row['SenderPhone']}</td>";
                    echo "<td>{$row['SenderAddress']}</td>";
                    echo "<td>{$row['RecipientName']}</td>";
                    echo "<td>{$row['RecipientEmail']}</td>";
                    echo "<td>{$row['ReceiverPhone']}</td>";
                    echo "<td>{$row['RecipientAddress']}</td>";
                    echo "<td>{$row['Weight']}</td>";
                    echo "<td>{$row['Date']}</td>";
                    echo "<td>{$row['Time']}</td>";
                    echo "<td>{$row['Amount']}</td>";
                    echo "<td>{$row['Status']}</td>";
                    echo "<td>{$row['EstimatedDeliveryTime']}</td>";
                    echo "<td>{$row['DeliveryRequested']}</td>";
                    echo "<td>{$row['BranchName']}</td>";
                    echo "<td>{$row['BranchContactNumber']}</td>";
                    echo "<td>
                            <a href='edit_parcel.php?id={$row['ParcelID']}' class='mb-2 btn btn-primary'>Edit</a>
                            <a href='view_parcels.php?delete_id={$row['ParcelID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this parcel?\")'>Delete</a>
                            <a href='generatepdf.php?parcel_id={$row['ParcelID']}' class='mt-2 btn btn-info' >PDF</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
