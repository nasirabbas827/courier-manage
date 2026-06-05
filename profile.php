<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Fetch user details for the logged-in user
$userID = $_SESSION["user_id"];
$query = "SELECT * FROM Users WHERE UserID = $userID";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['Username'];
    $name = $row['Name'];
    $email = $row['Email'];
    $phone = $row['Phone'];
} else {
    echo "User not found";
    exit;
}

// Update user profile if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST["name"];
    $newEmail = $_POST["email"];
    $newPhone = $_POST["phone"];
    
    // Check if a new password is provided
    $newPassword = (!empty($_POST["password"])) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : $row['Password'];

    // Perform the SQL query to update the user profile
    $updateQuery = "UPDATE Users SET
                    Name = '$newName',
                    Email = '$newEmail',
                    Phone = '$newPhone',
                    Password = "YOUR_OWN_API_KEY"
                    WHERE UserID = $userID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Profile updated successfully";
        // Refresh the page after updating
        header("Refresh:0");
        exit;
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<?php
include('navbar.php');
?>
<div class="container mt-5 mb-5">
    <h2 class="text-center">Update Profile</h2>

    <!-- Form for updating user profile -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" disabled>
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
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="form-text text-muted">Leave blank to keep the current password.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
