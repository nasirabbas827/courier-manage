<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if ParcelID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_parcels.php");
    exit;
}

$parcelID = $_GET['id'];

// Fetch parcel details for the logged-in user
$query = "SELECT * FROM Parcels WHERE ParcelID = $parcelID ";
$result = mysqli_query($conn, $query);

if (!$row = mysqli_fetch_assoc($result)) {
    // Redirect if the parcel is not found or does not belong to the logged-in user
    header("Location: view_parcels.php");
    exit;
}

// Update parcel details if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senderName = $_POST["senderName"];
    $senderAddress = $_POST["senderAddress"];
    $recipientName = $_POST["recipientName"];
    $recipientAddress = $_POST["recipientAddress"];
    $weight = $_POST["weight"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $amount = $_POST["amount"];
    $status = $_POST["status"];
    $estimatedDeliveryTime = $_POST["estimatedDeliveryTime"];
    $deliveryRequested = isset($_POST["deliveryRequested"]) ? "Yes" : "No";

    // Perform the SQL query to update parcel details
    $updateQuery = "UPDATE Parcels SET
                    SenderName = '$senderName',
                    SenderAddress = '$senderAddress',
                    RecipientName = '$recipientName',
                    RecipientAddress = '$recipientAddress',
                    Weight = '$weight',
                    Date = '$date',
                    Time = '$time',
                    Amount = '$amount',
                    Status = '$status',
                    EstimatedDeliveryTime = '$estimatedDeliveryTime',
                    DeliveryRequested = '$deliveryRequested'
                    WHERE ParcelID = $parcelID AND UserID = $userID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Parcel updated successfully');</script>";
        header("Location: view_parcels.php");
        exit;
    } else {
        echo "<script>alert('Error updating parcel');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Parcel</title>
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
    <h2 class="text-center">Edit Parcel</h2>

    <!-- Form for editing parcel with responsive layout -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$parcelID"; ?>">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="senderName">Sender Name:</label>
                    <input type="text" class="form-control" id="senderName" name="senderName" value="<?php echo $row['SenderName']; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="senderAddress">Sender Address:</label>
                    <input type="text" class="form-control" id="senderAddress" name="senderAddress" value="<?php echo $row['SenderAddress']; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="recipientName">Recipient Name:</label>
                    <input type="text" class="form-control" id="recipientName" name="recipientName" value="<?php echo $row['RecipientName']; ?>" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="recipientAddress">Recipient Address:</label>
                    <input type="text" class="form-control" id="recipientAddress" name="recipientAddress" value="<?php echo $row['RecipientAddress']; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="weight">Weight:</label>
                    <input type="text" class="form-control" id="weight" name="weight" value="<?php echo $row['Weight']; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $row['Date']; ?>" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="time">Time:</label>
                    <input type="time" class="form-control" id="time" name="time" value="<?php echo $row['Time']; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" class="form-control" id="amount" name="amount" value="<?php echo $row['Amount']; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="In Transit" <?php if ($row['Status'] == 'In Transit') echo 'selected'; ?>>In Transit</option>
                        <option value="Delivered" <?php if ($row['Status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                        <option value="Pending" <?php if ($row['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Delayed" <?php if ($row['Status'] == 'Delayed') echo 'selected'; ?>>Delayed</option>
                        <option value="Returned" <?php if ($row['Status'] == 'Returned') echo 'selected'; ?>>Returned</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="estimatedDeliveryTime">Estimated Delivery Time (days):</label>
                    <input type="number" class="form-control" id="estimatedDeliveryTime" name="estimatedDeliveryTime" value="<?php echo $row['EstimatedDeliveryTime']; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="deliveryRequested" name="deliveryRequested" <?php if ($row['DeliveryRequested'] == 'Yes') echo 'checked'; ?>>
                    <label class="form-check-label" for="deliveryRequested">Delivery Requested</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Parcel</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
