<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if the branch ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $branchID = $_GET['id'];

    // Fetch branch details for the provided BranchID
    $query = "SELECT * FROM Branches WHERE BranchID = $branchID";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $branchName = $row['BranchName'];
        $location = $row['Location'];
        $contactPerson = $row['ContactPerson'];
        $contactNumber = $row['ContactNumber'];
    } else {
        echo "Branch not found";
        exit;
    }
} else {
    echo "Invalid branch ID";
    exit;
}

// Update branch details if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newBranchName = $_POST["branchName"];
    $newLocation = $_POST["location"];
    $newContactPerson = $_POST["contactPerson"];
    $newContactNumber = $_POST["contactNumber"];

    // Perform the SQL query to update the branch details
    $updateQuery = "UPDATE Branches SET
                    BranchName = '$newBranchName',
                    Location = '$newLocation',
                    ContactPerson = '$newContactPerson',
                    ContactNumber = '$newContactNumber'
                    WHERE BranchID = $branchID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Branch details updated successfully";
        // Redirect to the view_branches.php page after updating
        header("Location: view_branches.php");
        exit;
    } else {
        echo "Error updating branch details: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Branch - Admin Dashboard</title>
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
    <h2 class="text-center">Edit Branch</h2>

    <!-- Form for editing branch details -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $branchID); ?>">
        <div class="form-group">
            <label for="branchName">Branch Name:</label>
            <input type="text" class="form-control" id="branchName" name="branchName" value="<?php echo $branchName; ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>" required>
        </div>
        <div class="form-group">
            <label for="contactPerson">Contact Person:</label>
            <input type="text" class="form-control" id="contactPerson" name="contactPerson" value="<?php echo $contactPerson; ?>" required>
        </div>
        <div class="form-group">
            <label for="contactNumber">Contact Number:</label>
            <input type="text" class="form-control" id="contactNumber" name="contactNumber" value="<?php echo $contactNumber; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Branch</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
