<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch total branches count
$queryBranches = "SELECT COUNT(*) AS totalBranches FROM Branches";
$resultBranches = mysqli_query($conn, $queryBranches);
$rowBranches = mysqli_fetch_assoc($resultBranches);
$totalBranches = $rowBranches['totalBranches'];

// Fetch total users count
$queryUsers = "SELECT COUNT(*) AS totalUsers FROM Users";
$resultUsers = mysqli_query($conn, $queryUsers);
$rowUsers = mysqli_fetch_assoc($resultUsers);
$totalUsers = $rowUsers['totalUsers'];

// Fetch total parcels count
$queryParcels = "SELECT COUNT(*) AS totalParcels FROM Parcels";
$resultParcels = mysqli_query($conn, $queryParcels);
$rowParcels = mysqli_fetch_assoc($resultParcels);
$totalParcels = $rowParcels['totalParcels'];

// Fetch total messages count
$queryMessages = "SELECT COUNT(*) AS totalMessages FROM Messages";
$resultMessages = mysqli_query($conn, $queryMessages);
$rowMessages = mysqli_fetch_assoc($resultMessages);
$totalMessages = $rowMessages['totalMessages'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
include('admin_navbar.php');
?>
<div class="container mt-5">
    <h2 class="text-center">Admin Dashboard</h2>

    <div class="row">
        <!-- Display total branches card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Branches</h5>
                    <p class="card-text"><?php echo $totalBranches; ?></p>
                </div>
            </div>
        </div>

        <!-- Display total users card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text"><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </div>

        <!-- Display total parcels card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Parcels</h5>
                    <p class="card-text"><?php echo $totalParcels; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Display total messages card -->
    <div class="row mt-4">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Messages</h5>
                    <p class="card-text"><?php echo $totalMessages; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
