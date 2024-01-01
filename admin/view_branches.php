<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Delete branch if the branch ID is provided in the URL
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $branchID = $_GET['delete'];

    // Perform the SQL query to delete the branch
    $deleteQuery = "DELETE FROM Branches WHERE BranchID = $branchID";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "Branch deleted successfully";
    } else {
        echo "Error deleting branch: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Branches - Admin Dashboard</title>
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
    <h2 class="text-center">View Branches</h2>

    <!-- Display all branches in a table -->
    <table class="table">
        <a class="m-2 btn btn-outline-success float-right" href="add_branches.php">Add New Branch</a>
        <thead>
            <tr>
                <th>BranchID</th>
                <th>Branch Name</th>
                <th>Location</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch and display all branches
            $query = "SELECT * FROM Branches";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['BranchID']}</td>";
                echo "<td>{$row['BranchName']}</td>";
                echo "<td>{$row['Location']}</td>";
                echo "<td>{$row['ContactPerson']}</td>";
                echo "<td>{$row['ContactNumber']}</td>";
                echo "<td>
                        <a href='edit_branch.php?id={$row['BranchID']}' class='btn btn-primary'>Edit</a>
                        <a href='view_branches.php?delete={$row['BranchID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this branch?\")'>Delete</a>
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
