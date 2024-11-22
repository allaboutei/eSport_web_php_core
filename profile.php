<!DOCTYPE html>
<html lang="en">

<head>
    <?php $currentPage = 'profile';
    include_once "config/regdbconnect.php";
    session_start();
    ob_start(); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cf47e7251d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Profile</title>
</head>

<body>

    <div class="container">
        <div class="header">
            <?php include("header.php"); ?>
        </div>
        <?php
        if (isset($_GET['id'])) {

            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_user WHERE userId='$id'";
            $result = $conn->query($sql);

            $row = $result->fetch_assoc();
        }
        ?>
        <div class="main">
            <div class="profileContainer">
                <h3>Welcome Back, <?php echo $row['userName'] ?></h3>

                <img class="whImg" src="profile/<?php echo isset($row['userImg']) ? $row['userImg'] : "default.png" ?>" alt="Image Not Uploaded">
                <div class="profileInfo">
                    <div class="profileCard">
                        <h5 class="mg0Auto">User Perspective</h5>
                        <div class="Info">
                            <p>User Name : <?php echo $row['userName'] ?></p>
                        </div>
                        <div class="Info">
                            <p>User Email : <?php echo $row['userEmail'] ?></p>
                        </div>
                        <div class="Info">
                            <p>User Role : <?php if ($row['userRoleId'] == 1) {
                                                echo "Administrator";
                                            } else {
                                                echo "Causal User";
                                            }  ?></p>
                        </div>
                    </div>
                    <div class="profileCard">
                        <h5 class="mg0Auto">Player Perspective</h5>
                        <?php

                        $sql = "SELECT tp.playerId,tp.playerIgn,tp.roleId FROM tbl_player tp JOIN tbl_user tu ON tp.userId = tu.userId WHERE tp.userId = '$id'";

                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            if (isset($row['playerId'])) {
                                $playerid = $row['playerId'];


                                $sql1 = "SELECT tt.teamName FROM tbl_allocate ta JOIN tbl_team tt ON ta.teamId = tt.teamId WHERE ta.playerId = '$playerid'";

                                $result1 = $conn->query($sql1);
                                if ($result1 && $result1->num_rows > 0) {
                                    $row1 = $result1->fetch_assoc();
                                }
                            }
                        }

                        ?>
                        <div class="Info">
                            <p>Gaming Name : <?php echo isset($row['playerIgn']) ? $row['playerIgn'] : "You Haven't Registered As A Player" ?></p>
                        </div>
                        <div class="Info">
                            <?php
                            if (isset($row['roleId'])) {
                                $roleid = $row['roleId'];
                                $sqlr="SELECT roleName FROM tbl_role WHERE roleId='$roleid'";
                                $resultr=$conn->query($sqlr);
                                $rowr=$resultr->fetch_assoc();
                            } ?>
                            <p>In Game Role : <?php echo isset($rowr['roleName']) ? $rowr['roleName'] : "You Haven't Registered As A Player" ?></p>
                        </div>
                        <div class="Info">

                            <p>Current Team : <?php echo isset($row1['teamName']) ? $row1['teamName'] : "Not In A Team" ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="footer">
            <?php include("footer.php"); ?>
        </div>
</body>

</html>