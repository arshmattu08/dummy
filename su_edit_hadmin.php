<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "header.php";
include "dbconnect.php";
$conn = openConnection();

// Check if admin is logged in/ no outsiders using URL
if ($_SESSION['role'] !== 'super') {
    header("Location: access_denied.php"); // Redirect to homepage if not admin
    exit();
    }
// Check if doctor ID is set
if (!isset($_GET['id'])) {
    echo "No doctor ID provided.";
    exit();
}

$h_admin_id = $_GET['id'];

$query = "SELECT H_ADMIN_ID,H_ADMIN_NAME, H_ADMIN_EMAIL FROM PS_H_ADMIN WHERE H_ADMIN_ID = :admin_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':admin_id', $h_admin_id, PDO::PARAM_INT);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$admin) {
    echo "Admin not found.";
    exit();
}

// Handle delete request
if (isset($_POST['delete'])) {
    // Update the doctor's status to 'Disabled'
    $deleteQuery = "UPDATE PS_H_ADMIN SET STATUS = 'Disabled' WHERE H_ADMIN_ID = :admin_id";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bindParam(':admin_id', $h_admin_id, PDO::PARAM_INT);

    if ($deleteStmt->execute()) {
        // Redirect to dashboard after deletion
        $_SESSION['delete_message'] = "Admin has been deleted successfully!";
        header("Location: su_view_hadmin.php");
        exit();
    } else {
        echo "Error disabling doctor.";
    }
}

// ON THIS RN...
// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['delete'])) {
    $admin_id = $_POST['h_admin_id'];
    $admin_name = $_POST['h_admin_name'];
    $admin_email = $_POST['h_admin_email'];
    

    // Update query
    $updateQuery = "UPDATE PS_H_ADMIN SET H_ADMIN_ID = :admin_id, H_ADMIN_NAME = :admin_name, H_ADMIN_EMAIL = :admin_email WHERE H_ADMIN_ID = :admin_id";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':admin_id', $admin_id);
    $updateStmt->bindParam(':admin_name', $admin_name);
    $updateStmt->bindParam(':admin_email', $admin_email);
 

    if ($updateStmt->execute()) {
        $_SESSION['success_message'] = "Admin updated successfully!";
        header("Location: su_view_hadmin.php"); // Redirect after update
        exit();
    } else {
        echo "Error updating Admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
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

            .form-group input[type="text"] {
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
<h2>Edit Admin Information</h2>
<div class="form-container">
    <h2>Edit Admin Information</h2>
    <form method="post">
        <div class="form-group">
            <label>Hosp. Admin ID:</label>
            <input type="text" name="h_admin_id" value="<?= htmlspecialchars($admin['H_ADMIN_ID']) ?>" required>
        </div>

        <div class="form-group">
            <label>Admin Name:</label>
            <input type="text" name="h_admin_name" value="<?= htmlspecialchars($admin['H_ADMIN_NAME']) ?>" required>
        </div>

        <div class="form-group">
            <label>Admin Email:</label>
            <input type="text" name="h_admin_email" value="<?= htmlspecialchars($admin['H_ADMIN_EMAIL']) ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit">Update</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to disable this admin?');">Delete</button>
        </div>
    </form>
</div>

<?php ob_end_flush(); ?>
</body>
</html>