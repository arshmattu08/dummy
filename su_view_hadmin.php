<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "header.php";
include "dbconnect.php";
$conn = openConnection();
// $doc_email = $_SESSION['email'];
?>


<?php 
// to make sure outsiders can't access through URL
if ($_SESSION['role'] !== 'super') {
    header("Location: access_denied.php"); // Redirect to homepage if not admin
    exit();
    }


$query = "SELECT H_ADMIN_ID,H_ADMIN_NAME, H_ADMIN_EMAIL FROM PS_H_ADMIN WHERE H_STATUS = 'Active'"; // Update this query if needed to match your table structure
$stmt = $conn->prepare($query);
// $stmt->bindParam(':email', $doc_email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="css/style.css?v=1" rel="stylesheet">
</head>
<body>
<br>
<h2 style="text-align: center; margin-bottom: 10px;">Hospital Admins</h2> <br>
<div style="display: flex; flex-direction: column; align-items: center; width: 100%; margin-bottom: 20px;">
    <a href="super_admin_dashboard.php" class="btn btn-outline-dark d-flex align-items-center">
        <i class="bi bi-house-door-fill"></i>
    </a>
</div>
<div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
        <table id="myTable" class="table table-striped table-bordered dataTable">
        <thead>
        <tr>
            <b><th>Hosp. Admin ID</th></b>
            <b><th>Admin Name</th></b>
            <b><th>Admin Email</th></b>
            <th><i class = "fas fa-edit"></i></th>
        </tr>
        </thead>

        <?php
        // Step 3: Display fetched data
        if (count($result) > 0) {
            foreach ($result as $row) {
                echo "<tr>
                        <td>{$row['H_ADMIN_ID']}</td>
                        <td>{$row['H_ADMIN_NAME']}</td>
                        <td>{$row['H_ADMIN_EMAIL']}</td>
                        
                        <td>
                        <a href='su_edit_hadmin.php?id={$row['H_ADMIN_ID']}' style='text-decoration: none; padding: 3px 7px; background-color: #007bff; color: white; border-radius: 3px; font-size: 12px; display: inline-block;'>Edit</a>
                    </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No Appointments found.</td></tr>";
        }
        ?>

    </table>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
    </script>

    <?php if (isset($_SESSION['success_message'])) {
       echo "<p style='color: green; font-weight: bold;'>" . $_SESSION['success_message'] . "</p>";
    // Unset the message after displaying it
    unset($_SESSION['success_message']); } 
    
    
    if (isset($_SESSION['delete_message'])) {
        echo "<p style='color: orange; font-weight: bold;'>" . $_SESSION['delete_message'] . "</p>";
        unset($_SESSION['delete_message']);
    }
    
    ob_end_flush();
    ?>
</div>
</body>
</html>