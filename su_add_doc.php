<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
include 'dbconnect.php';
include 'header.php';
$conn = openConnection();
?>

<?php 
//
if (isset($_POST['add'])){
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $dob = $_POST['dob'];
    $hospital_id = $_POST['h_id'];

    $insertQuery = "INSERT INTO PS_DOCTOR (DOCTOR_FNAME,DOCTOR_LNAME, DOCTOR_DOB, HOSPITAL_ID) 
    VALUES (:first_name,:last_name,:dob,:h_id)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bindParam(':first_name', $firstname,PDO::PARAM_STR);
    $insertStmt->bindParam(':last_name', $lastname, PDO::PARAM_STR);
    $insertStmt->bindParam(':dob', $dob);
    $insertStmt->bindParam(':h_id', $hospital_id, PDO::PARAM_INT);



    if ($insertStmt->execute()) {
        // Redirect to dashboard after deletion
        $_SESSION['add_message'] = "Doctor has been added successfully!";
        header("Location: h_admin_doc.php");
        exit();
    } else {
        echo "Error adding doctor.";
    }


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doc</title>
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

        .form-group input {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-actions {
            margin-top: 20px;
            text-align: center;
        }

        .form-actions button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-actions button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Add a New Doctor</h2>
    <form method="POST">
        <div class="form-group">
            <label>First Name:</label>   
            <input type="text" name="first_name" required>
        </div>

        <div class="form-group">
            <label>Last Name:</label> 
            <input type="text" name="last_name" required>
        </div>

        <div class="form-group">
            <label>Date of Birth:</label> 
            <input type="date" name="dob" required>
        </div>

        <div class="form-group">
            <label>Hospital ID:</label> 
            <input type="number" name="h_id" required>
        </div>

        <div class="form-actions">
            <button type="submit" name="add">Add</button>
        </div>
    </form>
</div>

</body>
</html>



<?php
ob_end_flush();
?>