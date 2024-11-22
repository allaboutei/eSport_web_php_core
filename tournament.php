<!DOCTYPE html>
<html lang="en">
<?php
$currentPage = 'tournament';
session_start();
include_once("config/regdbconnect.php");
$currentDate = date("Y-m-d");
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament</title>
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
                    <h4>Upload the Tournaments</h4>
                </div>
                <?php
                if (isset($_POST["btnSubmit"])) {
                    $name = $_POST["tourname"];
                    $desc = $_POST["tourdesc"];
                    $prize = $_POST["tourprize"];
                    $loc = $_POST["tourloc"];
                    $sdate = $_POST["tourstart"];
                    $edate = $_POST["tourend"];


                    $sql = "INSERT INTO tbl_tour (tourId,tourName,tourDesc,tourPrizepool,tourLocation,tourStartDate,tourEndDate,status) VALUES (NULL,'$name','$desc','$prize','$loc','$sdate','$edate','1')";

                    if ($conn->query($sql) == True) {
                        echo "Tournament uploaded successfully";
                        header("location:tournament.php");
                    }
                }
                ?>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="register">
                        <label class="labelTag">Tournament Name</label>
                        <input name="tourname" type="text" class="form-control">
                    </div>
                    <div class="register">
                        <label class="labelTag">Description</label>
                        <input name="tourdesc" type="text" class="form-control">
                    </div>
                    <div class="register">
                        <label class="labelTag">Price Pool</label>
                        <input name="tourprize" type="text" class="form-control">
                    </div>
                    <div class="register">
                        <label class="labelTag">Location</label>
                        <input name="tourloc" type="text" class="form-control">
                    </div>
                    <div class="register">
                        <label class="labelTag">Start Date</label>
                        <input name="tourstart" type="date" class="form-control">
                    </div>
                    <div class="register">
                        <label class="labelTag">End Date</label>
                        <input name="tourend" type="Date" class="form-control">
                    </div>

                    <div class="register">
                        <input name="btnSubmit" type="submit" class="btn btn-primary" value="Upload">
                    </div>
                </form>

            </div>
            <div class="feed">
                <div class="tourContainer">
                    <?php
                    $sql = "SELECT * FROM tbl_tour";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                    ?>


                        <?php
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <div class="tourCard">
                                <img src="<?php if ($row['tourImage'] == NULL) {
                                                echo 'images/DISPEL.jpg';
                                            } else {
                                                echo $row['tourImage'];
                                            }  ?>" alt="Image Not Uploaded">
                                <div class="tourInfo">

                                    <p><strong>Tournament Name : </strong></p>

                                    <p><strong>Tournament Prizepool : </strong> </p>
                                    <p><strong>Tournament Location : </strong> </p>
                                    <p><strong>Tournament Start Date : </strong></p>
                                    <p><strong>Tournament End Date : </strong></p>
                                    <p><strong>Status : </strong></p>
                                </div>
                                <div class="tourInfo">
                                    <p><?php echo $row['tourName']; ?></p>

                                    <p><?php echo $row['tourPrizepool']; ?></p>
                                    <p><?php echo $row['tourLocation']; ?></p>
                                    <p><?php echo date("d M, Y", strtotime($row['tourStartDate'])); ?></p>
                                    <p><?php echo date("d M, Y", strtotime($row['tourEndDate'])); ?></p>
                                    <p><?php if ($row['tourEndDate'] < $currentDate) {
                                            echo "Completed";
                                        } elseif ($row['tourStartDate'] <= $currentDate) {
                                            echo "Ongoing";
                                        } else { {
                                                echo "Upcomming";
                                            }
                                        }   ?></p>
                                </div>
                                <div class="tourDetails">
                                    <a href="allocate_team.php?id=<?php echo $row['tourId']; ?>" class="btn btn-secondary">Show More</a>
                                </div>


                            </div>
                        <?php }
                        ?>


                </div>

            </div>
        <?php
                    } else {
                        echo "No Tournament Available";
                    }
        ?>
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