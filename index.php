<?php
include('config.php');


// Initialize variables
$parcelData = [];
$errorMessage = '';

// Handle parcel tracking if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parcelID = $_POST["parcelID"];

    // Fetch parcel data based on the ParcelID
    $query = "SELECT SenderName, SenderEmail, RecipientName, RecipientEmail, Date, Status FROM Parcels WHERE ParcelID = $parcelID";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $parcelData = $row;
    } else {
        $errorMessage = "Parcel not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Courier Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
.jumbotron {
            height: 550px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('./images/hotel.jpg');
            background-size: cover;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .jumbotron h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .jumbotron p {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

<?php
include('navbar.php');
?>

<div class="jumbotron text-center">
    <h1>Welcome to Online Courier Management System</h1>
    <p>Track and Manage Your Parcels Efficiently</p>
    <a href="login.php" class="btn btn-primary btn-lg">Login to Manage Parcels</a>
</div>

<div  class="container mt-5">
    <h2 class="text-center">Parcel Tracking</h2>

    <!-- Parcel tracking form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="parcelID">Enter Parcel ID:</label>
            <input type="text" class="form-control" id="parcelID" name="parcelID" required>
        </div>
        <button type="submit" class="btn btn-primary">Track Parcel</button>
    </form>

    <!-- Display parcel tracking result -->
    <?php if (!empty($parcelData)) : ?>
        <div class="mt-4">
            <h4>Parcel Information:</h4>
            <ul>
                <li><strong>Sender Name:</strong> <?php echo $parcelData['SenderName']; ?></li>
                <li><strong>Sender Email:</strong> <?php echo $parcelData['SenderEmail']; ?></li>
                <li><strong>Recipient Name:</strong> <?php echo $parcelData['RecipientName']; ?></li>
                <li><strong>Recipient Email:</strong> <?php echo $parcelData['RecipientEmail']; ?></li>
                <li><strong>Date:</strong> <?php echo $parcelData['Date']; ?></li>
                <li><strong>Status:</strong> <?php echo $parcelData['Status']; ?></li>
            </ul>
        </div>
    <?php elseif ($errorMessage) : ?>
        <div class="mt-4">
            <p class="text-danger"><?php echo $errorMessage; ?></p>
        </div>
    <?php endif; ?>
</div>

<footer class="mt-5 py-3 bg-light">
    <div class="container text-center">
        <p>&copy; 2023 Courier Management. All rights reserved.</p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
