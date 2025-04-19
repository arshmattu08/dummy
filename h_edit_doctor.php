<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "header.php";
include "dbconnect.php";
$conn = openConnection();

// Check if admin is logged in
if ($_SESSION['role'] !== 'hospital' && $_SESSION['role'] !== 'super') {
    header("Location: access_denied.php"); // Redirect to homepage if not admin
    exit();
    }

// Check if doctor ID is set
if (!isset($_GET['id'])) {
    echo "No doctor ID provided.";
    exit();
}

$doctor_id = $_GET['id'];

// Fetch existing data
$query = "SELECT * FROM PS_DOCTOR WHERE DOCTOR_ID = :doctor_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
$stmt->execute();
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$doctor) {
    echo "Doctor not found.";
    exit();
}

// Handle delete request
if (isset($_POST['delete'])) {
    // Update the doctor's status to 'Disabled'
    $deleteQuery = "UPDATE PS_DOCTOR SET STATUS = 'Disabled' WHERE DOCTOR_ID = :doctor_id";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);

    if ($deleteStmt->execute()) {
        // Redirect to dashboard after deletion
        $_SESSION['delete_message'] = "Doctor has been disabled successfully!";
        header("Location: h_admin_doc.php");
        exit();
    } else {
        echo "Error disabling doctor.";
    }
}

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['delete'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $hospital_id = $_POST['hospital_id'];

    // Update query
    $updateQuery = "UPDATE PS_DOCTOR SET DOCTOR_FNAME = :first_name, DOCTOR_LNAME = :last_name, DOCTOR_DOB = :dob, HOSPITAL_ID = :hospital_id WHERE DOCTOR_ID = :doctor_id";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':first_name', $first_name);
    $updateStmt->bindParam(':last_name', $last_name);
    $updateStmt->bindParam(':dob', $dob);
    $updateStmt->bindParam(':hospital_id', $hospital_id);
    $updateStmt->bindParam(':doctor_id', $doctor_id);

    if ($updateStmt->execute()) {
        $_SESSION['success_message'] = "Doctor updated successfully!";
        header("Location: h_admin_doc.php"); // Redirect after update
        exit();
    } else {
        echo "Error updating doctor.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
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
            .form-group input[type="date"],
            .form-group input[type="number"] {
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
    <h2>Edit Doctor Information</h2>
    <form method="post">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($doctor['DOCTOR_FNAME']) ?>" required>
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars($doctor['DOCTOR_LNAME']) ?>" required>
        </div>

        <div class="form-group">
            <label>Date of Birth:</label>
            <input type="date" name="dob" value="<?= htmlspecialchars($doctor['DOCTOR_DOB']) ?>" required>
        </div>

        <div class="form-group">
            <label>Hospital ID:</label>
            <input type="number" name="hospital_id" value="<?= htmlspecialchars($doctor['HOSPITAL_ID']) ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit">Update</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to disable this doctor?');">Delete</button>
        </div>
    </form>
</div>
<?php ob_end_flush(); ?>
</body>
</html>





