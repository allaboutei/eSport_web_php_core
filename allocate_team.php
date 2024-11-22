<!DOCTYPE html>
<html lang="en">
<?php
include_once "config/regdbconnect.php";
ob_start();
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Allocations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/cf47e7251d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <?php
            include("header.php");
            ?>
        </div>
        <div class="main">
            <?php
            if (isset($_GET['id'])) {
                $tourid = $_GET['id'];
                $sql = "SELECT * FROM tbl_tour WHERE tourId='$tourid'";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                } else {
                    echo "No tournament found.";
                    exit;
                }
            }
            ?>
            <div class="">
                <h5><?php echo $row['tourName'] ?></h5>
                <p><strong>Venue : </strong><?php echo $row['tourLocation']  ?></p>
                <p><strong>Description : </strong><?php echo $row['tourDesc'] ?></p>
                <br>
                <div class="">
                    <h5>Competing Teams</h5>
                    <?php
                    $sql1 = "SELECT tm.teamId,tm.teamName,tm.teamImage
                    FROM tbl_team tm LEFT JOIN tbl_team_allocate  ta ON tm.teamId=ta.teamId WHERE ta.tourId='$tourid' ";

                    $result1 = $conn->query($sql1);
                    if ($result1 && $result1->num_rows > 0) {
                    ?>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Team Logo</th>
                                <?php if (!isset($_SESSION['userRoleId']) || $_SESSION['userRoleId'] == 0) {

                                    echo "";
                                } else {
                                    echo " <th>Action</th>";
                                } ?>
                            </tr>
                            <?php
                            while ($row1 = $result1->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row1['teamId']; ?></td>
                                    <td><?php echo $row1['teamName']; ?></td>
                                    <td><img class="whImg" src="uploadfiles/<?php echo $row1['teamImage']; ?>" alt=""></td>

                                    <?php if (!isset($_SESSION['userRoleId']) || $_SESSION['userRoleId'] == 0) {

                                        echo "";
                                    } else {
                                    ?>
                                        <td>
                                            <form action="allocations/team.php" method="GET">
                                                <input type="hidden" name="teamId" value="<?php echo $row1['teamId']; ?>">
                                                <input type="hidden" name="tourId" value="<?php echo $tourid; ?>">
                                                <input class="btn btn-danger" name="btnRemove" type="submit" value="Remove">
                                            </form>
                                        </td>
                                    <?php
                                    } ?>


                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    <?php
                    } else {
                        echo "No Team Assigned";
                    }
                    ?>
                </div>
            
                <div class=" <?php if (!isset($_SESSION['userRoleId']) || $_SESSION['userRoleId'] == 0) {

                                    echo "blockContent";
                                } else {
                                    echo "";
                                } ?>">
                                <br>
                    <h4>Available Teams</h4>
                    <?php

                    $sql2 = "SELECT tm.teamId,tm.teamName,tm.teamImage FROM tbl_team tm 
                    LEFT JOIN tbl_team_allocate ta ON tm.teamId=ta.teamId AND ta.tourId='$tourid' WHERE ta.teamId IS NULL";

                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                    ?>
                        <table>
                            <tr>
                                <th>Team ID</th>
                                <th>Team Name</th>
                                <th>Team Logo</th>
                                <th>Assign Teams</th>

                            </tr>
                            <?php
                            while ($row2 = $result2->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row2['teamId']; ?></td>
                                    <td><?php echo $row2['teamName']; ?></td>
                                    <td><img class="whImg" src="uploadfiles/<?php echo $row2['teamImage']; ?>" alt=""></td>



                                    <td>
                                        <form action="allocations/team.php" method="GET">
                                            <input type="hidden" name="teamId" value="<?php echo $row2['teamId']; ?>">
                                            <input type="hidden" name="tourId" value="<?php echo $tourid; ?>">
                                            <input class="btn btn-success" name="btnAssign" type="submit" value="Assign">
                                        </form>
                                    </td>
                                    <?php
                                    ?>


                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    <?php
                    } else {
                        echo "No Available Teams";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="footer">
            <?php
            include("footer.php");
            ?>
        </div>
    </div>
    <?php
    ob_end_flush();
    ?>
    <script src="script.js"></script>
</body>

</html>