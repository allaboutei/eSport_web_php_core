<!DOCTYPE html>
<html lang="en">
<?php
$currentPage = 'members';
session_start();
include_once("config/regdbconnect.php");
$captain_team_id = null;
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cf47e7251d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script>
     
        function toggleCaptainForm(userId) {
            var form = document.getElementById("captainForm_" + userId);
            var button = document.getElementById("btnCap_" + userId);
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
                button.style.display = "none";
            } else {
                form.style.display = "none";
                button.style.display = "inline";
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="header">
            <?php include("header.php"); ?>
        </div>
        <br>
        <div class="main">
            <h2 class="txtw">User List</h2>
            <?php
            if (isset($_GET['deleteid'])) {
                $deleteId = intval($_GET['deleteid']);
                $sqlDelete = "UPDATE tbl_user SET status='0' WHERE userId = '$deleteId'";
                if ($conn->query($sqlDelete) == true) {
                    echo "<h3 class='noti'>User deleted successfully</h3>";
                    echo "<div class='loader mg0Auto'></div>";
                    header("refresh:1,url=userlist.php");
                    exit();
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            }

            // Promoting or demoting the user from admin role
            if (isset($_GET['editid'])) {
                $editid = intval($_GET['editid']);
                $sqlSelect = "SELECT userRoleId FROM tbl_user WHERE userId=?";
                $stmtSelect = $conn->prepare($sqlSelect);
                $stmtSelect->bind_param("i", $editid);
                $stmtSelect->execute();
                $resultSelect = $stmtSelect->get_result();
                $rowSelect = $resultSelect->fetch_assoc();

                if ($rowSelect["userRoleId"] == 1) {
                    $sqlEdit = "UPDATE tbl_user SET userRoleId='0' WHERE userId=?";
                    $stmtEdit = $conn->prepare($sqlEdit);
                    $stmtEdit->bind_param("i", $editid);
                    if ($stmtEdit->execute()) {
                        echo "<h3 class='noti'>User Demoted successfully</h3>";
                        echo "<div class='loader mg0Auto'></div>";
                        header("refresh:1,url=userlist.php");
                        exit();
                    } else {
                        echo "Error Demoting User: " . $conn->error;
                    }
                } else {
                    $sqlEdit = "UPDATE tbl_user SET userRoleId='1' WHERE userId=?";
                    $stmtEdit = $conn->prepare($sqlEdit);
                    $stmtEdit->bind_param("i", $editid);
                    if ($stmtEdit->execute()) {
                        echo "<h3 class='noti'>User Promoted successfully</h3>";
                        echo "<div class='loader mg0Auto'></div>";
                        header("refresh:1,url=userlist.php");
                        exit();
                    } else {
                        echo "Error Promoting User: " . $conn->error;
                    }
                }
            }

            if (isset($_POST['btnSave'])) {
                $uid = $_POST['userId'];
                $teamid = $_POST['teamId'];
                if(empty($teamid)){
                    echo "<h3 class='noti'>Please Select A Team</h3>";
                    echo "<i class='fa-solid fa-triangle-exclamation'></i>";
                    header("refresh:1,url=userlist.php");
                    exit();
                }
                $sqlCheck = "SELECT COUNT(id) AS captain_count FROM tbl_captain WHERE teamId='$teamid'";
                $resultCheck = $conn->query($sqlCheck);
                $rowCheck = $resultCheck->fetch_assoc();

                if ($rowCheck['captain_count'] > 0) {
                    echo "<h3 class='noti'>This team already has a captain. Cannot assign another.</h3>";
                    echo "<i class='fa-solid fa-triangle-exclamation'></i>";
                    header("refresh:1,url=userlist.php");
                    exit();
                } else {
                    $sql1 = "INSERT INTO tbl_captain (id, userId, teamId) VALUES (NULL, '$uid', '$teamid')";
                    if ($conn->query($sql1) === true) {
                        echo "<h3 class='noti'>Successfully assigned the Captain</h3>";
                        echo "<div class='loader mg0Auto'></div>";
                        header("refresh:1,url=userlist.php");
                        exit();
                    }
                  
                }
            }

            if (isset($_POST['btnRemoveCap'])) {
                $uid = $_POST['userId'];
                $sql1 = "DELETE FROM tbl_captain WHERE userId= $uid";
                if ($conn->query($sql1) == true) {
                    echo "<h3 class='noti'>User is removed from Captain role successfully</h3>";
                    echo "<div class='loader mg0Auto'></div>";
                    header("refresh:1,url=userlist.php");
                }
            }

            $sql = "SELECT * FROM tbl_user";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            ?>

                <div class="feed">
                    <div class="memberContainer">
                        <?php while ($row = $result->fetch_assoc()) {
                            $playerid = $row["userId"];
                        ?>
                            <div class="memberCard">

                                <div class="memberInfo">
                                    <p>ID: <?php echo $row["userId"];
                                            if ($row['status'] == 0) {
                                                echo "<h5 class='deleted'>User Account is Deleted</h5>";
                                            }

                                            ?></p>
                                    <p>Name: <?php echo $row["userName"]; ?></p>
                                    <p>Email: <?php echo $row["userEmail"]; ?></p>

                                    <p>Captain of: <?php
                                                    $sql1 = "SELECT tt.teamName from tbl_team tt LEFT JOIN tbl_captain tc ON tt.teamId=tc.teamId  WHERE userId='$playerid'";
                                                    $result1 = $conn->query($sql1);
                                                    $row1 = $result1->fetch_assoc();
                                                    echo isset($row1['teamName']) ? $row1['teamName'] : "None";
                                                    ?></p>
                                    <p>Role: <?php echo ($row["userRoleId"] == 1) ? "Admin" : "User"; ?></p>
                                    <div class="">
                                        <a class="btn btn-danger" href="userlist.php?deleteid=<?php echo $row["userId"]; ?>">Delete</a>
                                        <?php if ($row["userRoleId"] == 1) { ?>
                                            <a class="btn btn-warning" href="userlist.php?editid=<?php echo $row["userId"]; ?>">Demote</a>
                                        <?php } else { ?>
                                            <a class="btn btn-success" href="userlist.php?editid=<?php echo $row["userId"]; ?>">Promote to Admin</a>
                                        <?php }
                                        $userid = $row['userId'];
                                        $sqlcap = "SELECT * FROM tbl_captain WHERE userId='$userid'";
                                        $resultcap = $conn->query($sqlcap);
                                        if ($resultcap->num_rows > 0) {
                                            $captain_team_id = 1;
                                        } else {
                                            $captain_team_id = 0;
                                        }
                                        if ($captain_team_id == 0) {
                                        ?>
                                            <button id="btnCap_<?php echo $row['userId']; ?>" class="btn btn-secondary btnAssign" onclick="toggleCaptainForm(<?php echo $row['userId']; ?>)">Assign as Captain</button>
                                            <form id="captainForm_<?php echo $row['userId']; ?>" action="#" method="POST" style="display: none;">
                                                <input type="hidden" name="userId" value="<?php echo $row['userId'] ?>">
                                                <select name="teamId" class="selectTag">
                                                    <option value="0">Select Team</option>
                                                    <?php
                                                    $sqlcap = "SELECT * from tbl_team";
                                                    $resultcap = $conn->query($sqlcap);
                                                    while ($rowcap = $resultcap->fetch_assoc()) {
                                                    ?>
                                                        <option value="<?php echo $rowcap['teamId'] ?>"><?php echo $rowcap['teamName'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <input class="btn btn-success btnConfirm" type="submit" name="btnSave" value="Confirm">
                                            </form>
                                        <?php
                                        } else {
                                        ?>
                                            <form action="#" method="POST">
                                                <input type="hidden" name="userId" value="<?php echo $row['userId'] ?>">
                                                <br>
                                                <input class="btn btn-danger" name="btnRemoveCap" type="submit" value="Remove Captain Status">
                                            </form>

                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <br><br><br>
        </div>
        <div class="footer">
            <?php include("footer.php"); ?>
        </div>
    </div>
    <?php ob_end_flush(); ?>

</body>

</html>
