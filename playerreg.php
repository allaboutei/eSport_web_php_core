<!DOCTYPE html>
<html lang="en">
<?php
$currentPage = 'playerreg';
include_once("config/regdbconnect.php");
session_start();
isset($_SESSION['role']) ? $role = $_SESSION['role'] : $role = "Not Logged In";
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Registration</title>
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
            <div class="formBtnModule <?php if (!isset($_SESSION['userRoleId']) || $_SESSION['userRoleId'] == 1) {
                                            echo 'blockContent';
                                        } ?>">
                <button class="fillForm fillBtn">Fill Form</button>
                <i class="fa-solid fa-scroll"></i>
            </div>

            <?php
            if (!isset($_SESSION['userRoleId'])) {
                echo "<h3>Login to register as a player</h3>
                      <a href='login.php' class='btn btn-success'>Go To Login</a>";
            } elseif ($_SESSION['userRoleId'] == 0) {
                echo "<h3>Ready to compete in the matches? Fill out the form Now!</h3>";
            } else {
                echo "<h3>Welcome Admin!</h3>";
            }

            // Insert player data
            // Insert or Update player data
            if (isset($_POST["btnSubmit"])) {
                $name = $_SESSION["userName"];
                $link = $_POST["plink"];
                $email = $_SESSION["userEmail"];
                $phno = $_POST["pno"];
                $igname = $_POST["pign"];
                $igid = $_POST["pigid"];
                $pos = $_POST["ppos"];
                $uid = $_SESSION['userId'];

                // Check if an editId is present to perform an update
                if (isset($_POST["editId"])) {
                    $editId = $_POST["editId"]; // Capture editId from the hidden field
                    $sqlUpdate = "UPDATE tbl_player 
            SET playerName='$name', playerFblink='$link', playerEmail='$email', playerPhno='$phno', playerIgn='$igname', playerIgid='$igid', roleId='$pos'
            WHERE playerId='$editId'";

                    if ($conn->query($sqlUpdate) === true) {
                        echo "<div class='loader mg0Auto'></div>";
                        echo "<h3 class='noti'>Player updated successfully</h3>";
                        header("refresh:1,url=playerreg.php");
                        exit();
                    } else {
                        echo "ERROR Update";
                    }
                } else {
                    
                    $sqlCheck = "SELECT * FROM tbl_player WHERE userId='$uid'";
                    $result = $conn->query($sqlCheck);

                    if ($result->num_rows > 0) {
                        echo "<i class='fa-solid fa-triangle-exclamation'></i>";
                        header("refresh:1,url=playerreg.php");
                        echo "Error! You Cannot Register with the same account twice";
                        exit();
                    } else {
                        $sqlInsert = "INSERT INTO tbl_player (playerId, userId, playerName,playerImg, playerFblink, playerEmail, playerPhno, playerIgn, playerIgid, roleId, status)
                          VALUES (NULL, '$uid', '$name',NULL, '$link', '$email', '$phno', '$igname', '$igid', '$pos', '0')";
                        if ($conn->query($sqlInsert) === true) {
                            echo "<div class='loader mg0Auto'></div>";
                            header("refresh:1,url=playerreg.php");
                            echo "Record inserted successfully";
                            exit();
                        } else {
                            echo "Insert Error";
                        }
                    }
                }
            }


            // Update player data


            // Delete player data
            if (isset($_GET["deleteid"])) {
                $delid = $_GET["deleteid"];
                $sqlCheck = "SELECT * FROM tbl_player WHERE status='0' AND playerId='$delid'";
                $resultCheck = $conn->query($sqlCheck);
                if ($resultCheck->num_rows > 0) {
                    $sql = "DELETE FROM tbl_player WHERE playerId='$delid'";
                    if ($conn->query($sql) == true) {
                        echo "<div> Record deleted successfully</div>";
                        echo "<div class='loader mg0Auto'></div>";
                        header("refresh:1,url=playerreg.php");
                        exit();
                    } else {
                        echo "Error deleting the player";
                    }
                }
                echo "Error Deletion! The Player is assigned to a team";
                echo "<i class='fa-solid fa-triangle-exclamation'></i>";
                header("refresh:1,url=playerreg.php");
                exit();
            }

            // Edit player data
            $rowEdit = Null;
            if (isset($_GET["editid"])) {
                $eid = $_GET["editid"];
                $sqlEdit = "SELECT * FROM tbl_player WHERE playerId='$eid'";
                $resultEdit = $conn->query($sqlEdit);
                $rowEdit = $resultEdit->fetch_assoc();
            }
            ?>

            <div class="content">
                <div class="register heading">
                    <h4>Register Here</h4>
                </div>

                <form action="" method="POST">
                    <?php $sql = "SELECT * FROM tbl_player";
                    $result = $conn->query($sql);
                    ?>
                   
                    <div class="register">
                        <p class="labelTag">Facebook Link</p>
                        <input name="plink" value="<?php echo
                                                    isset($rowEdit['playerFblink']) ? $rowEdit['playerFblink'] : '' ?>" type="url" class="form-control" required>
                    </div>
                    
                    <div class="register">
                        <p class="labelTag">Phone Number</p>
                        <input name="pno" value="<?php echo
                                                    isset($rowEdit['playerPhno']) ? $rowEdit['playerPhno'] : ''
                                                    ?>" type="number" class="form-control" required>
                    </div>
                    <div class="register">
                        <p class="labelTag">In Game Name</p>
                        <input name="pign" value="<?php echo
                                                    isset($rowEdit['playerIgn']) ? $rowEdit['playerIgn'] : ''  ?>" type="text" class="form-control" required>
                    </div>
                    <div class="register">
                        <p class="labelTag">In Game ID</p>
                        <input name="pigid" value="<?php echo isset($rowEdit['playerIgid']) ? $rowEdit['playerIgid'] : '' ?>" type="text" class="form-control" required>
                    </div>
                    <div class="register">
                        <?php
                        $ssql = "SELECT * FROM tbl_role";
                        $r = $conn->query($ssql);
                        ?>
                        <p class="labelTag">Role/Position</p>
                        <select name="ppos" class="selectTag" required>
                            <option>------Select Role------</option>
                            <?php
                            while ($row1 = $r->fetch_assoc()) {
                                echo "<option value='" . $row1['roleId'] . "'>" . $row1['roleName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <?php if (isset($rowEdit)) { ?>
                        <input type="hidden" name="editId" value="<?php echo $rowEdit['playerId']; ?>">
                        <div class="register">
                            <input id="updatebutton" name="btnSubmit" type="submit" class="btn btn-primary" value="Update">
                        </div>
                    <?php } else { ?>
                        <div class="register">
                            <input name="btnSubmit" type="submit" class="btn btn-primary" value="Register">
                        </div>
                    <?php } ?>
                </form>

                <?php
                $sql = "SELECT * FROM tbl_player";
                $result = $conn->query($sql);
                if ($result->num_rows > 0 && !isset($_GET['editid'])) {
                ?>
            </div>

            <div class="feed">
                <strong>Registered Players</strong>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Player Name</th>
                        <th>Player Facebook Link</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>In Game Name</th>
                        <th>In Game ID</th>
                        <th>Player Role</th>
                        <?php if ($role == "admin") {
                            echo "<th>Action</th>";
                        } ?>
                    </tr>

                    <?php
                    while ($row = $result->fetch_assoc()) {


                    ?>
                        <tr class="<?php if(!isset($_SESSION['userId']) || $_SESSION['userId']!=$row['userId']  ){
                            echo "";
                        }
                        else{
                            echo "distinct";
                        }
                        
                        
                        ?>">
                            <td>
                                <?php echo $row["playerId"]; ?>
                            </td>
                            <td>
                                <?php echo $row["playerName"]; ?>
                            </td>
                            <td>
                                <?php echo $row["playerFblink"]; ?>
                            </td>
                            <td>
                                <?php echo $row["playerEmail"]; ?>
                            </td>
                            <td>
                                <?php echo $row["playerPhno"]; ?>
                            </td>

                            <td>
                                <?php echo $row["playerIgn"]; ?>
                            </td>
                            <td>
                                <?php echo $row["playerIgid"]; ?>
                            </td>
                            <td>
                                <?php
                                $rolename = $row["roleId"];
                                $ssql = "SELECT roleName FROM tbl_role WHERE roleId=$rolename";
                                $res = $conn->query($ssql);
                                $roww = $res->fetch_assoc();
                                echo $roww["roleName"];

                                ?>
                            </td>

                            <?php if (!isset($role) || $role == "user") {
                                echo "";
                            } elseif ($role == "admin") {
                            ?>
                                <td>
                                    <a href="playerreg.php?editid=<?php echo $row['playerId']; ?>">Edit</a>

                                    <a href="playerreg.php?deleteid=<?php
                                                                    echo $row['playerId']; ?>">Delete</a>
                                </td>
                            <?php
                            } ?>



                        </tr>
                    <?php
                    }
                    ?>
                </table>

            </div>
        <?php
                }
        ?>
        </div>
        <?php
        include("footer.php");
        ?>
    </div>
    <?php
    ob_end_flush();
    ?>
    <script src="script.js"></script>
</body>

</html>