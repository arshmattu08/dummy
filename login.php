<?php
    include "header.php";
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login</title>
        </head>
        <body>
            <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <ul class="nav nav-pills card-header-pills justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" id="login-tab" href="#" onclick="showForm('login')">Login</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <!-- Login Form -->
                    <form id="login-form" action="login_process.php" method="POST" onsubmit="return validateLoginForm()">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="login-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="login-password" name="password" required>
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
