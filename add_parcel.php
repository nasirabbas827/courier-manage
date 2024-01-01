<?php
session_start();
include('config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION["user_id"];
$branchID = $_SESSION['branch_id'];

// Add parcel to the database if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senderName = $_POST["senderName"];
    $senderAddress = $_POST["senderAddress"];
    $senderEmail = $_POST["senderEmail"];
    $recipientName = $_POST["recipientName"];
    $recipientAddress = $_POST["recipientAddress"];
    $recipientEmail = $_POST["recipientEmail"];
    $weight = $_POST["weight"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $amount = $_POST["amount"];
    $status = $_POST["status"];
    $estimatedDeliveryTime = $_POST["estimatedDeliveryTime"];
    $deliveryRequested = isset($_POST["deliveryRequested"]) ? "Yes" : "No";

    // Perform the SQL query to insert data into the Parcels table
    $parcelQuery = "INSERT INTO Parcels (SenderName, SenderAddress, SenderEmail, RecipientName, RecipientAddress, RecipientEmail, Weight, Date, Time, Amount, Status, EstimatedDeliveryTime, DeliveryRequested, BranchID, UserID) 
                    VALUES ('$senderName', '$senderAddress', '$senderEmail', '$recipientName', '$recipientAddress', '$recipientEmail', '$weight', '$date', '$time', '$amount', '$status', '$estimatedDeliveryTime', '$deliveryRequested', '$branchID', '$userID')";

    if (mysqli_query($conn, $parcelQuery)) {
        echo "Parcel added successfully ";

        // Send email to sender and recipient with parcel information
        sendParcelEmail($senderEmail, $recipientEmail, $senderName, $recipientName, $status, $estimatedDeliveryTime, $deliveryRequested);
    } else {
        echo "Error: " . $parcelQuery . "<br>" . mysqli_error($conn);
    }
}

function sendParcelEmail($senderEmail, $recipientEmail, $senderName, $recipientName, $status, $estimatedDeliveryTime, $deliveryRequested) {
    $mail = new PHPMailer(true);

    try {
        // Configure the mailer (SMTP settings, etc.)
        // SMTP configuration for Gmail
       // SMTP configuration
       $mail->isSMTP();
       $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
       $mail->SMTPAuth = true;
       $mail->Username = 'nasiryt.827@gmail.com'; // Replace with your SMTP username
       $mail->Password = 'zmcrrapmywubsmhk'; // Replace with your SMTP password
       $mail->Port = 587; // Replace with your SMTP port (usually 587)

       // Send the email
       $mail->setFrom('nasiryt.827@gmail.com', 'NASIR ABBAS'); // Replace with your Gmail address and name
        $mail->addAddress($senderEmail, $senderName);
        $mail->addAddress($recipientEmail, $recipientName);
        $mail->Subject = 'Parcel Information';
        $mail->isHTML(true);
        $mail->Body = "Hello $senderName,<br><br>Your parcel has been added successfully.<br><br>
                       Parcel Information:<br>
                       Status: $status<br>
                       Estimated Delivery Time: $estimatedDeliveryTime days<br>
                       Delivery Requested: $deliveryRequested<br><br>
                       Thank you for using our services!<br><br>Best regards,<br>Courier Management System";

        // Send the email
        $mail->send();
        echo '   Email has been sent successfully';
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Parcel</title>
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
    <h2 class="text-center">Add Parcel</h2>

  <!-- Form for adding parcels with responsive layout -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="senderName">Sender Name:</label>
                <input type="text" class="form-control" id="senderName" name="senderName" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="senderAddress">Sender Address:</label>
                <input type="text" class="form-control" id="senderAddress" name="senderAddress" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="senderEmail">Sender Email:</label>
                <input type="email" class="form-control" id="senderEmail" name="senderEmail" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="recipientName">Recipient Name:</label>
                <input type="text" class="form-control" id="recipientName" name="recipientName" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="recipientAddress">Recipient Address:</label>
                <input type="text" class="form-control" id="recipientAddress" name="recipientAddress" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="recipientEmail">Recipient Email:</label>
                <input type="email" class="form-control" id="recipientEmail" name="recipientEmail" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="text" class="form-control" id="weight" name="weight" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="In Transit">In Transit</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Pending">Pending</option>
                    <option value="Delayed">Delayed</option>
                    <option value="Returned">Returned</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="estimatedDeliveryTime">Estimated Delivery Time (days):</label>
                <input type="number" class="form-control" id="estimatedDeliveryTime" name="estimatedDeliveryTime" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-check">
                <input type="checkbox" class=" mt-3 form-check-input" id="deliveryRequested" name="deliveryRequested">
                <label class=" mt-3 form-check-label" for="deliveryRequested">Delivery Requested</label>
            </div>
        </div>
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary float-right">Add Parcel</button>
        </div>
    </div>
</form>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
