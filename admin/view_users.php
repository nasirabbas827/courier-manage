<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Delete user if the UserID is provided in the URL
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $userID = $_GET['delete'];

    // Perform the SQL query to delete the user
    $deleteQuery = "DELETE FROM Users WHERE UserID = $userID";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Users - Admin Dashboard</title>
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
    <h2 class="text-center">View Users</h2>

    <!-- Display all users in a table -->
    <table class="table">
    <a class="m-2 btn btn-outline-success float-right" href="add_users.php">Add New User</a>

        <thead>
            <tr>
                <th>UserID</th>
                <th>Branch</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch and display all users with related branch information
            $query = "SELECT Users.*, Branches.BranchName 
                      FROM Users 
                      INNER JOIN Branches ON Users.BranchID = Branches.BranchID";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['UserID']}</td>";
                echo "<td>{$row['BranchName']}</td>";
                echo "<td>{$row['Username']}</td>";
                echo "<td>{$row['Name']}</td>";
                echo "<td>{$row['Email']}</td>";
                echo "<td>{$row['Phone']}</td>";
                echo "<td>
                        <a href='edit_user.php?id={$row['UserID']}' class='btn btn-primary'>Edit</a>
                        <a href='view_users.php?delete={$row['UserID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
