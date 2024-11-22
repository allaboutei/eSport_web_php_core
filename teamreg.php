<!DOCTYPE html>
<html lang="en">
<?php
$currentPage = 'teamreg';
include_once("config/regdbconnect.php");
session_start();
ob_start();
isset($_SESSION['role']) ? $role = $_SESSION['role'] : $role = "Not Logged In";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Registration</title>
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
            <div class="formBtnModule <?php if (isset($_SESSION['userRoleId'])) {
                                            if ($_SESSION['userRoleId'] == 0) {
                                                echo "blockContent";
                                            } elseif ($_SESSION['userRoleId'] == 1) {
                                                echo "";
                                            }
                                        } else {
                                            echo "blockContent";
                                        } ?> ">
                <button class="fillForm fillBtn">Fill Form </button>
                <i class="fa-solid fa-scroll"></i>
            </div>
            <div class="content <?php if (isset($_SESSION['userRoleId'])) {
                                    if ($_SESSION['userRoleId'] == 0) {
                                        echo "blockContent";
                                    } elseif ($_SESSION['userRoleId'] == 1) {
                                        echo "";
                                    }
                                } else {
                                    echo "blockContent";
                                } ?>">
                <div class="register heading">
                    <h4>Register Your Team Here</h4>
                </div>
                <?php
                if (isset($_POST["btnSubmit"])) {
                    $name = $_POST["tname"];
                    $email = $_POST["temail"];
                    $phno = $_POST["tno"];

                    if (isset($_FILES["tfile"]) && $_FILES["tfile"]["error"] == 0) {
                        $filename = $_FILES["tfile"]["name"];
                        $filepatch = $_FILES["tfile"]["tmp_name"];
                        move_uploaded_file($filepatch, "uploadfiles/" . $filename);
                    } else {
                        $filename = "";
                    }

                    if (isset($_POST["editId"])) {
                        $editId = $_POST["editId"];
                        $sql = "UPDATE tbl_team SET teamName='$name', teamEmail='$email', teamPhno='$phno', teamImage='$filename' WHERE teamId=' $editId'";
                        if ($conn->query($sql) == True) {
                            echo "<div>Successfully Updated One Record!</div>";
                            header("location:teamreg.php");
                            exit();
                        }
                    } else {
                        $sql = "INSERT INTO tbl_team (teamId, teamName, teamEmail, teamPhno, teamImage,assignedTour) VALUES (NULL, '$name','$email', '$phno','$filename','0')";
                        if ($conn->query($sql) == True) {
                            echo "Record inserted successfully";
                            header("location:teamreg.php");
                            exit();
                        } else {
                            echo "Insertion Error";
                        }
                    }
                }



                if (isset($_GET["deleteid"])) {
                    $delid = $_GET["deleteid"];
                    $sql = "DELETE FROM tbl_team WHERE teamId = '$delid'";
                    if ($conn->query($sql) == TRUE) {
                        echo "<div> Record deleted successfully</div>";
                        header("location:teamreg.php");
                        exit();
                    }
                }
                $editRow = null;
                if (isset($_GET["editid"])) {
                    $eid = $_GET["editid"];
                    $sql = "SELECT * from tbl_team WHERE teamId='$eid'";
                    $result = $conn->query($sql);
                    $editRow = $result->fetch_assoc();
                }
                ?>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo ($editRow['teamId']) ? $editRow['teamId'] : ""; ?>">
                    <div class="register">
                        <p class="labelTag">Team Name</p>
                        <input name="tname" type="text" class="form-control"
                            value="<?php echo isset($editRow) ? $editRow['teamName'] : ''; ?>" required>
                    </div>

                    <div class="register">
                        <p class="labelTag">Team Email</p>
                        <input name="temail" type="email" class="form-control"
                            value="<?php echo isset($editRow) ? $editRow['teamEmail'] : ''; ?>" required>
                    </div>
                    <div class="register">
                        <p class="labelTag">Team Phone Number</p>
                        <input name="tno" type="number" class="form-control"
                            value="<?php echo isset($editRow) ? $editRow['teamPhno'] : ''; ?>" required>
                    </div>
                    <div class="register">
                        <p class="labelTag">Upload Team Logo</p>
                        <input name="tfile" type="file" class="form-control uploadTag">
                    </div>
                    <?php if (isset($editRow)) {
                    ?>
                        <div class="register">
                            <input type="hidden" name="editId" value="<?php echo $editRow['teamId']; ?>">
                            <input name="btnSubmit" type="submit" class="btn btn-success" value="Update">
                        </div>
                    <?php } else { ?>
                        <div class="register">

                            <input name="btnSubmit" type="submit" class="btn btn-primary" value="Register">
                        </div>
                    <?php } ?>
                </form>
                <?php
                $sql = "SELECT * FROM tbl_team";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                ?>
            </div>


            <div class="feed">


                <div class="teamC">
                    <?php while ($row = $result->fetch_assoc()) { ?>

                        <div class="teamCa">
                            <a href="allocate_player.php?id=<?php echo $row["teamId"]; ?>">
                                <img class="whImg" src="uploadfiles/<?php echo $row['teamImage'] ?>" alt="">
                                <div class="teamI">
                                    <p>ID: <?php echo $row["teamId"]; ?></p>
                                    <p>Name: <?php echo $row["teamName"]; ?></p>
                                    <p>Email: <?php echo $row["teamEmail"]; ?></p>
                                    <p>Ph No: <?php echo $row["teamPhno"]; ?></p>
                                    <?php
                                    if (!isset($_SESSION['userRoleId']) || $_SESSION['userRoleId'] == 0) {

                                        echo "";
                                    } else {

                                    ?>
                                        <div class="action">
                                            <a class="btn btn-primary" href="teamreg.php?editid=<?php echo $row['teamId'] ?>">Edit Info</a>
                                            <a class="btn btn-danger" href="teamreg.php?deleteid=<?php echo $row["teamId"]; ?>">Delete</a>

                                        </div>
                                    <?php
                                    }

                                    ?>

                                </div>
                            </a>
                        </div>

                    <?php } ?>
                </div>

            <?php } ?>

            </div>


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