<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Check if the UserID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userID = $_GET['id'];

    // Fetch user details for the provided UserID
    $query = "SELECT Users.*, Branches.BranchName 
              FROM Users 
              INNER JOIN Branches ON Users.BranchID = Branches.BranchID
              WHERE UserID = $userID";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $branchID = $row['BranchID'];
        $username = $row['Username'];
        $name = $row['Name'];
        $email = $row['Email'];
        $phone = $row['Phone'];
    } else {
        echo "User not found";
        exit;
    }
} else {
    echo "Invalid user ID";
    exit;
}

// Update user details if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newBranchID = $_POST["branchID"];
    $newUsername = $_POST["username"];
    $newName = $_POST["name"];
    $newEmail = $_POST["email"];
    $newPhone = $_POST["phone"];
    
    // Check if a new password is provided
    $newPassword = (!empty($_POST["password"])) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : $row['Password'];

    // Perform the SQL query to update the user details
    $updateQuery = "UPDATE Users SET
                    BranchID = '$newBranchID',
                    Username = '$newUsername',
                    Name = '$newName',
                    Email = '$newEmail',
                    Phone = '$newPhone',
                    Password = "YOUR_OWN_API_KEY"
                    WHERE UserID = $userID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "User details updated successfully";
        // Redirect to the view_users.php page after updating
        header("Location: view_users.php");
        exit;
    } else {
        echo "Error updating user details: " . mysqli_error($conn);
    }
}

// Fetch branches for dropdown menu
$branchQuery = "SELECT * FROM Branches";
$branchResult = mysqli_query($conn, $branchQuery);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User - Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
include('admin_navbar.php');
?>
<div class="container mt-5 mb-5">
    <h2 class="text-center">Edit User</h2>

    <!-- Form for editing user details -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $userID); ?>">
        <div class="form-group">
            <label for="branchID">Branch:</label>
            <select class="form-control" id="branchID" name="branchID" required>
                <?php
                // Display branches in a dropdown menu
                while ($branchRow = mysqli_fetch_assoc($branchResult)) {
                    $selected = ($branchRow['BranchID'] == $branchID) ? "selected" : "";
                    echo "<option value='{$branchRow['BranchID']}' $selected>{$branchRow['BranchName']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="form-text text-muted">Leave blank to keep the current password.</small>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
