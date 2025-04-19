<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
require_once 'dbconnect.php';

try {
    // ? Validate form inputs
    if (!isset($_POST['email'], $_POST['password'], $_POST['role'])) {
        throw new Exception("Please fill in all required fields.");
    }

    // ? Assign form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // ? Role configuration
    $role_map = [
        'hospital' => ['table' => 'PS_H_ADMIN', 'email_col' => 'H_ADMIN_EMAIL', 'pass_col' => 'H_ADMIN_PASS', 'name_col' => 'H_ADMIN_NAME', 'dashboard' => 'hospital_admin_dashboard.php'],
        'pharmacy' => ['table' => 'PS_P_ADMIN', 'email_col' => 'P_ADMIN_EMAIL', 'pass_col' => 'P_ADMIN_PASS', 'name_col' => 'P_ADMIN_NAME', 'dashboard' => 'pharmacy_admin_dashboard.php'],
        'staff'    => ['table' => 'PS_ST_ADMIN', 'email_col' => 'ST_ADMIN_EMAIL', 'pass_col' => 'ST_ADMIN_PASS', 'name_col' => 'ST_ADMIN_NAME', 'dashboard' => 'staff_admin_dashboard.php'],
        'super'    => ['table' => 'PS_SU_ADMIN', 'email_col' => 'SU_ADMIN_EMAIL', 'pass_col' => 'SU_ADMIN_PASS', 'name_col' => 'SU_ADMIN_NAME', 'dashboard' => 'super_admin_dashboard.php'],
    ];

    if (!isset($role_map[$role])) {
        throw new Exception("Invalid role selected.");
    }

    // ? Extract role-specific values
    $config = $role_map[$role];
    $conn = openConnection();

    // ? Prepare SQL query
    $stmt = $conn->prepare("SELECT * FROM {$config['table']} WHERE {$config['email_col']} = :email LIMIT 1");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        if (password_verify($password, $user[$config['pass_col']])) {
            $_SESSION['role'] = $role;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user[$config['name_col']];
            header("Location: {$config['dashboard']}");
            exit();
        } else {
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.history.back();</script>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
