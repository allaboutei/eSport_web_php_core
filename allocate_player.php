<!DOCTYPE html>
<html lang="en">
<?php
include_once "config/regdbconnect.php";
session_start();
ob_start();




?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Allocation </title>
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

        <?php
        $resultt = null;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sqlt = "SELECT * FROM tbl_team WHERE teamId=$id";
            $resultt = $conn->query($sqlt);
            if (!isset($_SESSION['userId'])) {
                echo "";
            } else {
                $uid = $_SESSION['userId'];
                $sql = "SELECT * FROM tbl_captain WHERE userId=$uid AND teamId=$id";
                $result = $conn->query($sql);
                if ($row = $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $authCap = 1;
                } else {
                    $authCap = 0;
                }

                // Check if the query ran successfully
                if (!$resultt) {
                    echo "<p>Error fetching team details.</p>";
                    exit;  // Stop further execution if there's an error
                }
            }
        }
        ?>

        <div class="main">

            <div class="allocateContainer">
                <?php
                //    echo $captain_team_id;
                if ($resultt && $resultt->num_rows > 0) {
                    $rowt = $resultt->fetch_assoc();
                ?>
                    <div class="team">
                        <div class="teamL">
                            <h4 class=""><?php echo $rowt['teamName']; ?></h4>
                            <img class="whImg" src="uploadfiles/<?php echo $rowt['teamImage']; ?>" alt="Could not Load the Image">
                        </div>
                        <div class="teamR">
                            <h5>Created At: <?php echo date("l: F d, Y", strtotime($rowt["createdat"])); ?> </h5>

                            <?php $sql = "SELECT u.userName 
                    FROM tbl_user u
                    JOIN tbl_captain c ON u.userId=c.userId
                    WHERE c.teamId='$id'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                            }

                            ?>
                            <h5>Captain: <?php echo  isset($row['userName']) ? $row['userName'] : "No captain assigned"; ?></h5>
                        </div>
                    </div>
                    <hr>
                    <h5>Team Members</h5>

                    <div class="playerCard">
                        <?php
                        $sql = "SELECT tp.playerId, tp.playerName, tp.playerIgn,tp.roleId
                            FROM tbl_allocate ta 
                            JOIN tbl_player tp ON ta.playerId = tp.playerId
                            JOIN tbl_team tt ON ta.teamId = tt.teamId
                            WHERE tt.teamId = '$id'";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                        ?>



                            <?php
                            while ($row = $result->fetch_assoc()) {
                            ?>


                                <div class="playerInfo">
                                    <?php
                                    if (!isset($_SESSION['userRoleId'])) {

                                        echo "";
                                    } elseif ($_SESSION['userRoleId'] == 1 || $authCap == 1) {
                                    ?>
                                        <div class="action">
                                            <form action="allocations/player.php" method="GET">
                                                <input type="hidden" name="playerId" value="<?php echo $row['playerId']; ?>">
                                                <input type="hidden" name="teamId" value="<?php echo $id; ?>">
                                                <input class="btn btn-danger" name="btnRemove" type="submit" value="Remove">
                                            </form>
                                        </div>


                                    <?php
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                    <img src="profile/<?php echo isset($row['playerImg']) ? $row['playerImg'] : '../images/DISPEL.jpg' ?>" alt="Image not loaded">
                                    <?php

                                    ?>
                                    <h6><?php echo $row['playerName']; ?>
                                        <?php
                                        //  $sqlCheck = "SELECT u.userName 
                                        //  FROM tbl_user u
                                        //  JOIN tbl_captain c ON u.userId=c.userId
                                        //  WHERE c.teamId='$id'";
                                        //          $resultCheck = $conn->query($sqlCheck);
                                        //          if ($resultCheck->num_rows > 0) {
                                        //              $rowCheck = $resultCheck->fetch_assoc();
                                        //          }
                                        // echo  isset($rowCheck['userName'])
                                        ?>
                                    </h6>
                                    <h6><?php echo $row['playerIgn']; ?></h6>
                                    <h6>
                                        <?php
                                        $rid = $row['roleId'];
                                        $sqlr = "SELECT roleName FROM tbl_role WHERE roleId='$rid'";
                                        $resultr = $conn->query($sqlr);
                                        $rowr = $resultr->fetch_assoc();
                                        echo $rowr['roleName']; ?></h6>





                                </div>


                            <?php
                            } ?>
                    </div>


            <?php
                        } else {
                            echo "<p>No player assigned to this team.</p>";
                        }
                    }
            ?>
            <hr>
            </div>
            <br>

            <div class="<?php if (!isset($_SESSION['userRoleId'])) {

                            echo "blockContent";
                        } elseif ($_SESSION['userRoleId'] == 1 || $authCap == 1) {
                            echo "allocateContainer";
                        } else {
                            echo "blockContent";
                        } ?>">
                <hr>
                <h5>Only Admins and Captains Can Allocate Players</h5>
                <h6>Current Available Players</h6>
                <?php
                $sqlp = "SELECT * FROM tbl_player WHERE status='0'";
                $resultp = $conn->query($sqlp);
                ?>
                <div class="playerCard">
                    <?php
                    if ($resultp && $resultp->num_rows > 0) {
                        while ($rowp = $resultp->fetch_assoc()) {
                    ?>
                            <div class="playerInfo">
                                <div class="action">
                                    <form action="allocations/player.php" method="GET">
                                        <input type="hidden" name="playerId" value="<?php echo $rowp['playerId']; ?>">
                                        <input type="hidden" name="teamId" value="<?php echo $id; ?>">
                                        <input class="btn btn-success" name="btnAssign" type="submit" value="Assign">
                                    </form>
                                </div>
                                <img src="profile/<?php echo isset($rowp['playerImg']) ? $rowp['playerImg'] : '../images/DISPEL.jpg' ?>" alt="Image not loaded">

                                <h6><?php echo $rowp['playerName']; ?></h6>
                                <h6><?php echo $rowp['playerIgn']; ?></h6>
                                <h6>
                                    <?php
                                    $rid = $rowp['roleId'];
                                    $sqlr = "SELECT roleName FROM tbl_role WHERE roleId='$rid'";
                                    $resultr = $conn->query($sqlr);
                                    $rowr = $resultr->fetch_assoc();
                                    echo $rowr['roleName']; ?></h6>



                            </div>
                    <?php
                        }
                    } else {
                        echo "
                          <h6>No active players found</h6>  

                       ";
                    }
                    ?>
                </div>
            </div>
            <br><br>
        </div>

        <div class="footer">
            <?php include("footer.php"); ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>