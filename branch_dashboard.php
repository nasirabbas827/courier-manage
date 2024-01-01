<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Fetch and display the branch dashboard based on $_SESSION['branch_id']
$branchID = $_SESSION['branch_id'];

// Query to fetch branch details
$queryBranch = "SELECT * FROM Branches WHERE BranchID = $branchID";
$resultBranch = mysqli_query($conn, $queryBranch);
$rowBranch = mysqli_fetch_assoc($resultBranch);

// Query to fetch total parcels for the branch
$queryTotalParcels = "SELECT COUNT(*) AS totalParcels FROM Parcels WHERE BranchID = $branchID";
$resultTotalParcels = mysqli_query($conn, $queryTotalParcels);
$rowTotalParcels = mysqli_fetch_assoc($resultTotalParcels);
$totalParcels = $rowTotalParcels['totalParcels'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Branch Dashboard</title>
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
    <h2 class="text-center">Branch Dashboard</h2>

    <!-- Display branch details -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title"><?php echo $rowBranch['BranchName']; ?></h5>
            <p class="card-text">Location: <?php echo $rowBranch['Location']; ?></p>
            <p class="card-text">Contact Person: <?php echo $rowBranch['ContactPerson']; ?></p>
            <p class="card-text">Contact Number: <?php echo $rowBranch['ContactNumber']; ?></p>
        </div>
    </div>

    <!-- Display total parcels card -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Total Parcels</h5>
            <p class="card-text"><?php echo $totalParcels; ?></p>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
