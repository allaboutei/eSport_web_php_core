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

            <!-- Login Form -->
            <div class="loginContent">
                <div class="register heading">
                    <h5>Login to eSports Site</h5>
                </div>

                <!-- Include login error message if exists -->
                <?php include_once("./errors/login_error.php") ?>

                <form action="loginAuth.php" method="POST">
                    <div class="register">
                        <label class="labelTag">User Name</label>
                        <input name="uname" type="text" class="form-control" required>
                    </div>
                    <br>
                    <div class="register">
                        <label class="labelTag">Password</label>
                        <input name="upw" type="password" class="form-control" required>
                    </div>
                    <br>
                    <div class="register">
                        <input name="btnLogin" class="btn btn-primary" type="submit" value="Login">
                    </div>
                </form>
                <div class="createLogin">
                    <label>Don't have an account?</label>
                    <a href="register.php"><p id="createnewuserlink">Create an account</p></a>
                </div>
            </div>

        </div>
        <?php include("footer.php"); ?>
    </div>

    <?php ob_end_flush(); ?>

   

</body>

</html>