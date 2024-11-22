<!DOCTYPE html>
<html lang="en">
<?php
$currentPage = 'login';
include_once("config/regdbconnect.php");
session_start();
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cf47e7251d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <?php include("header.php"); ?>
        </div>
        <div class="main">

            <!-- Create Form -->
            <div class="createForm">
                <div class="register heading">
                    <h5>Create your account</h5>
                </div>

                <!-- Display error message for create form -->
                <?php include_once("./errors/create_error.php") ?>

                <form action="loginAuth.php" method="POST">
                    <div class="register">
                        <label class="labelTag" for="">Create User Name</label>
                        <input name="cname" class="form-control" type="text" required>
                    </div>
                    <br>
                    <div class="register">
                        <label class="labelTag">Enter Email address</label>
                        <input name="cemail" type="email" class="form-control" placeholder="name@example.com" required>
                    </div>
                    <br>
                    <div class="register">
                        <label class="labelTag">Create Password</label>
                        <input name="cpassword" type="password" class="form-control" placeholder="Max 20 characters" required>
                    </div>
                    <br>
                    <div class="register">
                        <input name="btnCreate" class="btn btn-primary" type="submit" value="Create">
                    </div>
                </form>
                <div class="term">
<p>Check Our  <a href="terms.php" target="_blank"  >Terms and Conditions</a> for how your data is being handled </p>
                   
                </div>
                <div class="createLogin">
                    <label>Already a user?</label>
                    <a href="login.php"><p id="loginuserlink">Login Here</p></a>
                </div>
            </div>


        </div>
        <?php include("footer.php"); ?>
    </div>

    <?php ob_end_flush(); ?>

    

</body>

</html>