<?php
session_start();

// Set session timeout to 5 minutes (300 seconds)
$session_timeout = 5 * 60;

// Check if the session variable exists

// Update last activity timestamp
$_SESSION['last_activity'] = time();
    include "header.php";
?>
<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-lg-5">
        <a href="" class="navbar-brand d-block d-lg-none">
            <h1 class="m-0 display-5 text-capitalize font-italic text-white">
                <span class="text-primary">Safety</span>First
            </h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
            <div class="navbar-nav mr-auto py-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="service.php" class="nav-item nav-link">Service</a>
                <a href="price.php" class="nav-item nav-link">Price</a>
                <a href="booking.php" class="nav-item nav-link">Booking</a>
                <a href="signin.php" class="nav-item nav-link">Sign In</a>
            </div>
        </div>
    </nav>
</div>
<!-- Navbar End -->

<!-- Sign In Section Start -->
<div class="container-fluid pt-5">
    <div class="d-flex flex-column text-center mb-5 pt-5">
        <h2 class="text-primary">Welcome to Pet Sphere</h2>
        <h3 class="display-5 m-0">Sign In to <span class="text-primary">Your Account</span></h3>
        <h4 class="display-5 m-0">New User? <span class="text-primary">Click on Sign Up</span></h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <ul class="nav nav-pills card-header-pills justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" id="login-tab" href="#" onclick="showForm('login')">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="signup-tab" href="#" onclick="showForm('signup')">Sign Up</a>
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
                    
                    <!-- Sign Up Form -->
                    <form id="signup-form" action="signup_process.php" method="POST" onsubmit="return validateSignupForm()">
                        <div class="form-group">
                            <label for="first_name">Pet Owner's First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Pet Owner's Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="zip_code">Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" pattern="\d{5}" title="Enter a valid 5-digit Zip Code" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="signup-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password (min 6 characters)</label>
                            <input type="password" class="form-control" id="signup-password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sign In Section End -->

<!-- CSS to Hide Sign-Up Form Initially -->
<style>
    #signup-form {
        display: none;
    }
</style>

<!-- JavaScript for Form Switching -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    showForm('login'); // Ensure only login form appears initially
});

function showForm(type) {
    if (type === 'login') {
        document.getElementById('login-form').style.display = 'block';
        document.getElementById('signup-form').style.display = 'none';
        document.getElementById('login-tab').classList.add('active');
        document.getElementById('signup-tab').classList.remove('active');
    } else {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('signup-form').style.display = 'block';
        document.getElementById('login-tab').classList.remove('active');
        document.getElementById('signup-tab').classList.add('active');
    }
}

// Form Validation for Login
function validateLoginForm() {
    let email = document.getElementById("login-email").value.trim();
    let password = document.getElementById("login-password").value.trim();

    if (!email || !password) {
        alert("Both Email and Password are required.");
        return false;
    }

    // Simple email validation
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    return true;
}

// Form Validation for Sign-Up
function validateSignupForm() {
    let firstName = document.getElementById("first_name").value.trim();
    let lastName = document.getElementById("last_name").value.trim();
    let city = document.getElementById("city").value.trim();
    let zipCode = document.getElementById("zip_code").value.trim();
    let email = document.getElementById("signup-email").value.trim();
    let password = document.getElementById("signup-password").value.trim();
    let confirmPassword = document.getElementById("confirm_password").value.trim();

    if (!firstName || !lastName || !city || !zipCode || !email || !password || !confirmPassword) {
        alert("All fields are required.");
        return false;
    }

    // Validate Zip Code (5 digits)
    if (!/^\d{5}$/.test(zipCode)) {
        alert("Please enter a valid 5-digit Zip Code.");
        return false;
    }

    // Validate email format
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Password validation
    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }

    // Confirm password match
    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}
</script>

<!-- Footer Start -->
<div class="container-fluid bg-dark text-white py-5 px-sm-3 px-md-5">
<?php
    include "footer.php";
?>
</div>
