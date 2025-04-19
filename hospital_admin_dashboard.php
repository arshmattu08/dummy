<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include "header.php";
?>

<?php 
// to make sure outsiders can't access through URL
if (!isset($_SESSION['role'])) {
    header("Location: access_denied.php"); // Redirect to homepage if not admin
    exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Typewriter Effect */
        .typewriter {
            font-family: 'Courier New', Courier, monospace;
            overflow: hidden; /* Ensures the text doesn't overflow */
            border-right: .15em solid black; /* Adds the cursor */
            white-space: nowrap; /* Prevents text from wrapping */
            display: inline-block;
            max-width: 100%;
            width: 0; /* Starts with no width */
            animation: typing 2.69s steps(35) 0.8s forwards, blink-caret .75s step-end infinite;
        }

        @keyframes typing {
            0% {
                width: 0;
            }
            100% {
                width: 30ch;
            }
        }

        @keyframes blink-caret {
            50% {
                border-color: transparent;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-lg-5" >
            <!-- This is for doctors-->
            <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    <a href="h_admin_doc.php" class="nav-item nav-link">Doctors</a>
                    <a href="h_view_appt.php" class="nav-item nav-link">Appointments</a>
                 </div> 
            </div>
        </nav>
    </div>

    <div class="container text-center mt-5">
    <h1>Welcome to your dashboard!</h1> <br> <br> 
        <h3><span class="typewriter">Hope you're doing good today.</span></h3>
</div>
<br><br><br><br><br><br><br><br>
  
    
</body>
</html>



<!-- Footer Start -->
<div class="container-fluid bg-dark text-white py-5 px-sm-3 px-md-5">
<?php
    include "footer.php";
    ob_end_flush();
?>
</div>
