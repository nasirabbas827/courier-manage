<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data and insert into the Branches table
    $branchName = $_POST["branchName"];
    $location = $_POST["location"];
    $contactPerson = $_POST["contactPerson"];
    $contactNumber = $_POST["contactNumber"];

    // Perform the SQL query to insert data into the Branches table
    $sql = "INSERT INTO Branches (BranchName, Location, ContactPerson, ContactNumber) 
            VALUES ('$branchName', '$location', '$contactPerson', '$contactNumber')";

    if (mysqli_query($conn, $sql)) {
        echo "Branch added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

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

    <!-- Form for adding branches -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="branchName">Branch Name:</label>
            <input type="text" class="form-control" id="branchName" name="branchName" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="form-group">
            <label for="contactPerson">Contact Person:</label>
            <input type="text" class="form-control" id="contactPerson" name="contactPerson" required>
        </div>
        <div class="form-group">
            <label for="contactNumber">Contact Number:</label>
            <input type="number" class="form-control" id="contactNumber" name="contactNumber" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Branch</button>
        <a class="btn btn-outline-dark" href="view_branches.php">View Branches</a>
    </form>
   
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
