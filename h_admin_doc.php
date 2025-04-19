<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "header.php";
include "dbconnect.php";
$conn = openConnection();
?>

<?php 
// to make sure outsiders can't access through URL, access for both super admin and h admins
if ($_SESSION['role'] !== 'hospital' && $_SESSION['role'] !== 'super') {
    header("Location: access_denied.php"); 
    exit();
    }


$query = "SELECT * FROM PS_DOCTOR WHERE STATUS = 'Active' "; // Update this query if needed to match your table structure
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="css/style.css?v=1" rel="stylesheet">
</head>
<body>
<h2 style="text-align: center; margin-bottom: 20px;">Doctors' Information</h2>
<div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
        <!-- Super admin add button-->
        <?php if ($_SESSION['role'] === 'super') : ?>
        <div class="d-flex justify-content-between align-items-end mb-2 flex-wrap">
        <div class="dataTables_length" id="example_length">
        <!-- Let DataTables auto-generate this -->
        </div>

        <div class="d-flex justify-content-end align-items-center mt-2 mt-md-0" style="gap: 10px;">
        <div class="dataTables_filter" id="example_filter">
            <!-- Let DataTables auto-generate this -->
        </div>

        <!-- Icon + Add button wrapper -->
        <div class="d-flex align-items-center gap-10" style="gap: 10px;">
            <!-- House icon button -->
            <a href="super_admin_dashboard.php" class="btn btn-outline-dark d-flex align-items-center" title="Back to Dashboard">
                <i class="bi bi-house-door-fill"></i>
            </a>

            <!-- Add Doctor button -->
            <a href="su_add_doc.php" class="btn btn-primary d-flex align-items-center" style="gap: 6px; background-color: black;">
                <i class="bi bi-plus-circle-fill"></i> Add Doctor
            </a>
        </div>
    </div>
</div>
<?php endif; ?>
        <!--Home button even if you're non super admin-->
<div class="d-flex justify-content-center mb-3" style="gap: 10px;">
            <!-- House icon button -->
            <a href="hospital_admin_dashboard.php" class="btn btn-outline-dark d-flex align-items-center" title="Back to Dashboard">
                <i class="bi bi-house-door-fill"></i>
            </a>
</div>
        <table id="myTable" class="table table-striped table-bordered dataTable">
        <thead>
        <tr>
            <b><th>ID</th></b>
            <b><th>First Name</th></b>
            <b><th>Last Name</th></b>
            <b><th>Date of Birth</th></b>
            <b><th>Hospital ID</th></b>
            <th><i class = "fas fa-edit"></i></th>
        </tr>
        </thead>

        <?php
        // Step 3: Display fetched data
        if (count($result) > 0) {
            foreach ($result as $row) {
                echo "<tr>
                        <td>{$row['DOCTOR_ID']}</td>
                        <td>{$row['DOCTOR_FNAME']}</td>
                        <td>{$row['DOCTOR_LNAME']}</td>
                        <td>{$row['DOCTOR_DOB']}</td>
                        <td>{$row['HOSPITAL_ID']}</td>
                        <td>
                        <a href='h_edit_doctor.php?id={$row['DOCTOR_ID']}' style='text-decoration: none; padding: 3px 7px; background-color: #007bff; color: white; border-radius: 3px; font-size: 12px; display: inline-block;'>Edit</a>
                    </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No doctors found.</td></tr>";
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


    if (isset($_SESSION['add_message'])) {
        echo "<p style='color: green; font-weight: bold;'>" . $_SESSION['add_message'] . "</p>";
     // Unset the message after displaying it
     unset($_SESSION['add_message']); } 
    
    
    if (isset($_SESSION['delete_message'])) {
        echo "<p style='color: orange; font-weight: bold;'>" . $_SESSION['delete_message'] . "</p>";
        unset($_SESSION['delete_message']);
    }
    
    ob_end_flush();
    ?>
</div>
</body>
</html>