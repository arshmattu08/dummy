<?php
  if (isset($_SESSION['last_activity'])) {
    // Check if the session has expired
    if (time() - $_SESSION['last_activity'] > $session_timeout) {
        session_unset(); // Unset session variables
        session_destroy(); // Destroy the session
        header("Location: signin.php"); // Redirect to login page
        exit();
    }
}
  
  include "header.php";
?>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Include the database connection file
    include 'dbconnect.php';

    // Check if the form was submitted with POST data
    if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['first_name']) || !isset($_POST['last_name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['confirm_password'])) {
        // If any of the necessary fields are missing, redirect the user to the signup page
        header("Location: signin.php");
        exit();
    }

    // Get the form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $city = trim($_POST['city']);
    $zip_code = trim($_POST['zip_code']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Hashing the password
    $confirm_password = trim($_POST['confirm_password']);

    // Check if any required field is empty
    if ($first_name == "" || $last_name == "" || $email == "" || $password == "" || $confirm_password == "" || $city == "" || $zip_code == "") {
        echo "<script>alert('All fields are required. Please fill in all the details.'); window.location.href = 'signin.php';</script>";
        exit();
    }

    // PDO connection (use your connection settings from dbconnect.php)
    $conn = openConnection(); // Assuming this function returns a PDO instance

    // Check if email already exists using PDO
    $sql_check = "SELECT * FROM PS_PET_OWNER WHERE OWNER_EMAIL = :email";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        echo "<script>alert('Email already exists. Please try logging in or use a different email.'); window.location.href = 'signin.php';</script>";
        exit();
    }

    // Insert data into the users table using PDO
    $sql = "INSERT INTO PS_PET_OWNER (OWNER_FNAME, OWNER_LNAME, OWNER_CITY, OWNER_ZIP_CODE, OWNER_EMAIL, OWNER_PASSWORD) 
            VALUES (:first_name, :last_name, :city, :zip_code, :email, :password)";
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the statement
    $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindParam(':city', $city, PDO::PARAM_STR);
    $stmt->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);

    // Execute the query
    if ($stmt->execute()) {
        // Success message after registration
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registration Successful</title>
        </head>
        <body>
        <div class="container mt-5">
            <div class="alert alert-success text-center">
                <h4>Thank you for registering with PetSphere!</h4>
                <p>Please proceed with <a href="login.php" class="btn btn-primary">Login</a></p>
            </div>
        </div>
        </body>
        </html>';
    } else {
        echo "<script>alert('Error in registration. Please try again.'); window.location.href = 'signin.php';</script>";
    }

    // Close the database connection
    $conn = null;
?>
<div class="container-fluid bg-dark text-white py-5 px-sm-3 px-md-5">
<?php
    include "footer.php";
?>

