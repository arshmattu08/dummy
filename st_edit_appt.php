<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "header.php";
include "dbconnect.php";
$conn = openConnection();

// Check if admin is logged in
if ($_SESSION['role'] !== 'staff') {
    header("Location: access_denied.php"); // Redirect to homepage if not admin
    exit();
    }

// Check if Appt ID is set
if (!isset($_GET['id'])) {
    echo "No doctor ID provided.";
    exit();
}
$appt_id = $_GET['id'];

// Fetch existing data
$query = "SELECT * FROM PS_APPOINTMENTS WHERE APPOINTMENT_ID = :appt_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':appt_id', $appt_id, PDO::PARAM_INT);
$stmt->execute();
$appt = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$appt) {
    echo "Appt. not found.";
    exit();
}

// Handle delete/cancel request
if (isset($_POST['delete'])) {
    // Update the doctor's status to 'Disabled'
    $deleteQuery = "UPDATE PS_APPOINTMENTS SET `STATUS` = 'Cancelled' WHERE APPOINTMENT_ID = :appt_id";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bindParam(':appt_id', $appt_id, PDO::PARAM_INT);

    if ($deleteStmt->execute()) {
        // Redirect to dashboard after deletion
        $_SESSION['delete_message'] = "Appointment has been cancelled successfully!";
        header("Location: h_view_appt.php");
        exit();
    } else {
        echo "Error deleting Appt.";
    }
}

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['delete'])) {
    $appointment_id = $_POST['appt_id'];
    $owner_id = $_POST['owner_id'];
    $pet_id = $_POST['pet_id'];
    $service_type = $_POST['service_type'];
    $appt_date = $_POST['appt_date'];
    $appt_time = $_POST['appt_time'];
    $appt_status = $_POST['appt_status'];
    $notes = $_POST['notes'];
    $created_at = $_POST['created_at'];
    $doc_id = $_POST['doctor_id'];


    // Update query
    $updateQuery = "UPDATE PS_APPOINTMENTS SET APPOINTMENT_ID = :appt_id, OWNER_ID = :owner_id, PET_ID = :pet_id,
     SERVICE_TYPE = :service_type, APPOINTMENT_DATE = :appt_date, APPOINTMENT_TIME = :appt_time, `STATUS` = :appt_status, NOTES = :notes, 
     CREATED_AT = :created_at, DOCTOR_ID = :doctor_id
      WHERE APPOINTMENT_ID = :appt_id";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':appt_id', $appointment_id);
    $updateStmt->bindParam(':owner_id', $owner_id);
    $updateStmt->bindParam(':pet_id', $pet_id);
    $updateStmt->bindParam(':service_type', $service_type);
    $updateStmt->bindParam(':appt_date', $appt_date);
    $updateStmt->bindParam(':appt_time', $appt_time);
    $updateStmt->bindParam(':appt_status', $appt_status);
    $updateStmt->bindParam(':notes', $notes);
    $updateStmt->bindParam(':created_at', $created_at);
    $updateStmt->bindParam(':doctor_id', $doc_id);

    if ($updateStmt->execute()) {
        $_SESSION['success_message'] = "Appointment updated successfully!";
        header("Location: st_view_appt.php"); // Redirect after update
        exit();
    } else {
        echo "Error updating Appointment.";
    }
}
?>

<!--This is HTML scripting-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appt</title>
<style>
    .form-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
    }

    .form-container h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #555;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="date"] {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 20px;
    }

    .form-actions button {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }

    .form-actions button[type="submit"] {
        background-color: #4CAF50;
    }

    .form-actions button[name="delete"] {
        background-color: #e74c3c;
    }
</style>

</head>
<body>
<div class="form-container">
    <h2>Edit Appointment Details</h2>
    <form method="post">
        <div class="form-group">
            <label>Appointment ID:</label>
            <input type="number" name="appt_id" value="<?= htmlspecialchars($appt['APPOINTMENT_ID']) ?>" required>
        </div>

        <div class="form-group">
            <label>Owner ID:</label>
            <input type="number" name="owner_id" value="<?= htmlspecialchars($appt['OWNER_ID']) ?>" required>
        </div>

        <div class="form-group">
            <label>Pet ID:</label>
            <input type="number" name="pet_id" value="<?= htmlspecialchars($appt['PET_ID']) ?>" required>
        </div>

        <div class="form-group">
            <label>Service Type:</label>
            <input type="text" name="service_type" value="<?= htmlspecialchars($appt['SERVICE_TYPE']) ?>" required>
        </div>

        <div class="form-group">
            <label>Appointment Date:</label>
            <input type="date" name="appt_date" value="<?= htmlspecialchars($appt['APPOINTMENT_DATE']) ?>" required>
        </div>

        <div class="form-group">
            <label>Appointment Time:</label>
            <input type="text" name="appt_time" value="<?= htmlspecialchars($appt['APPOINTMENT_TIME']) ?>" required>
        </div>

        <div class="form-group">
            <label>Appointment Status:</label>
            <input type="text" name="appt_status" value="<?= htmlspecialchars($appt['STATUS'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Notes:</label>
            <input type="text" name="notes" value="<?= htmlspecialchars($appt['NOTES'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Created At:</label>
            <input type="text" name="created_at" value="<?= htmlspecialchars($appt['CREATED_AT']) ?>" required>
        </div>

        <div class="form-group">
            <label>Doctor ID:</label>
            <input type="text" name="doctor_id" value="<?= htmlspecialchars($appt['DOCTOR_ID']) ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit">Update</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to cancel their appointment?');">Cancel Appt.</button>
        </div>
    </form>
</div>

<?php ob_end_flush(); ?>
</body>
</html>


