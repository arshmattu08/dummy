<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    if (!isset($_SESSION['code'])) {
    header("Location: access_denied.php"); // Redirect to homepage if not admin
    exit();
    }

    include "header.php";
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Login</title>
        </head>
        <body>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>Admin Login</h4>
                    </div>
                    <div class="card-body">
                        <form id="login-form" action="admin_login_process.php" method="POST">
                            <div class="form-group">
                                <label for="login-email">Email</label>
                                <input type="email" class="form-control" id="login-email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="login-password">Password</label>
                                <input type="password" class="form-control" id="login-password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label>Role</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="hospital" value="hospital" required>
                                    <label class="form-check-label" for="hospital">Hospital Admin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="pharmacy" value="pharmacy">
                                    <label class="form-check-label" for="pharmacy">Pharmacy Admin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="staff" value="staff">
                                    <label class="form-check-label" for="staff">Staff</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="super" value="super">
                                    <label class="form-check-label" for="super">Super Admin</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>        
</html>';


<!-- Footer Start -->
<div class="container-fluid bg-dark text-white py-5 px-sm-3 px-md-5">
<?php
    include "footer.php";
?>
</div>
