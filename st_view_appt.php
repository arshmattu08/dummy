<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "header.php";
include "dbconnect.php";
$conn = openConnection();
$doc_email = $_SESSION['email'];
?>

<?php 
// to make sure outsiders can't access through URL
if ($_SESSION['role'] !== 'staff') {
    header("Location: access_denied.php"); // Redirect to homepage if not admin
    exit();
    }



$query = "SELECT PS_APPOINTMENTS.* 
        FROM PS_APPOINTMENTS 
        JOIN PS_ST_ADMIN
        ON PS_APPOINTMENTS.DOCTOR_ID = PS_ST_ADMIN.ST_ADMIN_ID
        WHERE PS_ST_ADMIN.ST_ADMIN_EMAIL = :email"; // Update this query if needed to match your table structure
$stmt = $conn->prepare($query);
$stmt->bindParam(':email', $doc_email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor/Staff Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="css/style.css?v=1" rel="stylesheet">
    
</head>
<body>
<br><br>
<h2 style="text-align: center; margin-bottom: 20px;">Your Appointments Info</h2> 
<div class="d-flex justify-content-center mb-3">
            <!-- House icon button -->
            <a href="staff_admin_dashboard.php" class="btn btn-outline-dark d-flex align-items-center" title="Back to Dashboard">
                <i class="bi bi-house-door-fill"></i>
            </a>
</div>
<div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
    <table id="myTable" class="table table-striped table-bordered dataTable">
        <thead>
        <tr>
            <th>Appt. ID</th>
            <b><th>Owner ID</th></b>
            <b><th>Pet ID</th></b>
            <b><th>Service</th></b>
            <b><th>Appt Date</th></b>
            <b><th>Appt Time</th></b>
            <b><th>Status</th></b>
            <b><th>Notes</th></b>
            <b><th>Created At</th></b>
            <b><th>Doctor ID</th></b>
            <b><th>Edit</th></b>
        </tr>
        </thead>

        <?php
        // Step 3: Display fetched data
        if (count($result) > 0) {
            foreach ($result as $row) {
                echo "<tr>
                        <td>{$row['APPOINTMENT_ID']}</td>
                        <td>{$row['OWNER_ID']}</td>
                        <td>{$row['PET_ID']}</td>
                        <td>{$row['SERVICE_TYPE']}</td>
                        <td>{$row['APPOINTMENT_DATE']}</td>
                        <td>{$row['APPOINTMENT_TIME']}</td>
                        <td>{$row['STATUS']}</td>
                        <td>{$row['NOTES']}</td>
                        <td>{$row['CREATED_AT']}</td>
                        <td>{$row['DOCTOR_ID']}</td>
                        <td>
                        <a href='st_edit_appt.php?id={$row['APPOINTMENT_ID']}' style='text-decoration: none; padding: 3px 7px; background-color: #007bff; color: white; border-radius: 3px; font-size: 12px; display: inline-block;'>Edit</a>
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