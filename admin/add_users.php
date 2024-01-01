<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch branches for dropdown menu
$branchQuery = "SELECT * FROM Branches";
$branchResult = mysqli_query($conn, $branchQuery);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data and insert into the Users table
    $branchID = $_POST["branchID"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Perform the SQL query to insert data into the Users table
    $userQuery = "INSERT INTO Users (BranchID, Username, Password, Name, Email, Phone) 
                  VALUES ('$branchID', '$username', '$password', '$name', '$email', '$phone')";

    if (mysqli_query($conn, $userQuery)) {
        echo "User added successfully";
    } else {
        echo "Error: " . $userQuery . "<br>" . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Users - Admin Dashboard</title>
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
    <h2 class="text-center">Add Users</h2>

    <!-- Form for adding users -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="branchID">Branch:</label>
            <select class="form-control" id="branchID" name="branchID" required>
                <?php
                // Display branches in a dropdown menu
                while ($branchRow = mysqli_fetch_assoc($branchResult)) {
                    echo "<option value='{$branchRow['BranchID']}'>{$branchRow['BranchName']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="number" class="form-control" id="phone" name="phone" required>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
