<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pet Sphere</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-lg-5">
            <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    <a class="text-white pr-3" href="">FAQs</a>
                    <span class="text-white">|</span>
                    <a class="text-white px-3" href="">Help</a>
                    <span class="text-white">|</span>
                    <a class="text-white pl-3" href="">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-white px-3" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-white px-3" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-white px-3" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-white px-3" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-white pl-3" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row py-3 px-lg-5">
            <div class="col-lg-4">
                <a href="" class="navbar-brand d-none d-lg-block">
                    <h1 class="m-0 display-5 text-capitalize"><span class="text-primary">Pet </span>Sphere</h1>
                </a>
            </div>
            <div class="col-lg-8 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="d-inline-flex flex-column text-center pr-3 border-right">
                        <h6>Opening Hours</h6>
                        <p class="m-0">8.00AM - 9.00PM</p>
                    </div>
                    <div class="d-inline-flex flex-column text-center px-3 border-right">
                        <h6>Email Us</h6>
                        <p class="m-0">info@example.com</p>
                    </div>

                    <div>
                        <h6>Call Us</h6>
                        <p class="m-0">&nbsp;+012 345 6789</p>
                    </div>
                    <!-- Existing line is now clickable -->
                    <div class="d-inline-flex flex-column text-center px-3 border-right" onclick="toggleAdminAccess()" style="cursor: pointer;">
                        <hr style="border: 1px solid #fff; width: 100%; margin: 25px 0;">
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Hidden Input Section (initially hidden) -->
    <div id="adminAccessSection" style="display: none; text-align: center; margin-top: 20px;">
        <input type="password" id="adminPass" placeholder="Enter Admin Code">
        <button onclick="checkAccess()">Submit</button>
    </div>

    <script>
        // Function to toggle the visibility of the input and submit button
        function toggleAdminAccess() {
            const adminSection = document.getElementById('adminAccessSection');
            if (adminSection.style.display === 'none') {
                adminSection.style.display = 'block'; // Show input and submit button
            } else {
                adminSection.style.display = 'none'; // Hide input and submit button
            }
        }

        // Function to check if the entered password is correct
        function checkAccess() {
        let pass = document.getElementById("adminPass").value;

        if (pass === "1234") {
            // Send an AJAX request to a PHP script to set the session variable
            fetch("admin_session.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "action=set_admin"
            }).then(response => response.text()).then(data => {
                if (data === "success") {
                    window.location.href = "admin_login.php"; // Redirect after session is set
                } else {
                    alert("Error setting session!");
                }
            });
        } else {
            alert("Incorrect code!");
        }
    }    </script>
</body>
</html>
