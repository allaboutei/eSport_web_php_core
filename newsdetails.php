<!DOCTYPE html>
<html lang="en">
<?php
include_once("config/regdbconnect.php");
session_start();
ob_start();

if (isset($_POST['btnLike'])) {
    $uid = $_SESSION['userId'];
    $newsid = $_POST['newsId'];
    // echo "newsId: " . $newsid . ", userId: " . $uid;
    $sql1 = "INSERT INTO tbl_like (id,newsId,userId) VALUES (NULL,'$newsid','$uid')";
    $conn->query($sql1);
}
if (isset($_POST['btnDislike'])) {
    $uid = $_SESSION['userId'];
    $newsid = $_POST['newsId'];
    $likeid = $_POST['likeId'];
    $sqlunlike = "DELETE FROM tbl_like WHERE id='$likeid' AND newsId='$newsid' AND userId='$uid'";
    $conn->query($sqlunlike);
}

if (isset($_POST['btnReport'])) {
    $uid = $_SESSION['userId'];
    $newsid = $_POST['newsId'];
    // echo "newsId: " . $newsid . ", userId: " . $uid;
    $sql1 = "INSERT INTO tbl_report (id,newsId,userId) VALUES (NULL,'$newsid','$uid')";
    $conn->query($sql1);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/cf47e7251d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <?php
            include("header.php") ?>
        </div>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql = "SELECT * FROM tbl_news
            WHERE newsId=$id";
            $result = $conn->query($sql);
        }

        ?>
        <div class="main">

            <div class="newsExpandedContainer">
                <?php
                $row = $result->fetch_assoc();
                $newsid = $row['newsId'];
                ?>
                <h4 class="mg0Auto"><?php echo $row['newsHeading']; ?></h4>
                <img class="wh100 mg0Auto" src="uploadfiles/<?php echo $row['newsFootage'] ?>" alt="Could not Load the Image">
                <h5> <?php echo date("l: F d, Y", strtotime($row["newsDate"])); ?> </h5>

                <p> <?php echo $row['newsBody'] ?> </p>
            </div>



            <?php
            $newsid = $row['newsId'];
            $uid = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;


            $sqllike = "SELECT COUNT(id) as No4Likes FROM tbl_like WHERE newsId='$newsid'";
            $resultlike = $conn->query($sqllike);
            if ($resultlike->num_rows > 0) {
                $rowlike = $resultlike->fetch_assoc();
            }

            $sqlreport = "SELECT COUNT(id) as No4Reports FROM tbl_report WHERE newsId='$newsid'";
            $resultreport = $conn->query($sqlreport);

            if ($resultreport->num_rows > 0) {
                $rowreport = $resultreport->fetch_assoc();
            }



            if ($uid) {

                $sql2 = "SELECT id FROM tbl_like WHERE newsId='$newsid' AND userId='$uid'";
                $result2 = $conn->query($sql2);
                $sql3 = "SELECT id FROM tbl_report WHERE newsId='$newsid' AND userId='$uid'";
                $result3 = $conn->query($sql3);

            ?>
                <div class="react">
                    <form action='#' method='POST'>

                        <input type='hidden' name='newsId' value="<?php echo $newsid ?>">

                        <?php
                        // user has liked or not
                        if ($result2 && $result2->num_rows > 0) {
                            $row2 = $result2->fetch_assoc();
                            $likeId = $row2['id'];
                        ?>
                            <input type='hidden' name='likeId' value="<?php echo $likeId ?>">
                            <input name='btnDislike' class='btn btn-danger' type='submit' value='Unlike'>
                        <?php
                        } else {
                        ?>
                            <input name="btnLike" class="btn btn-success" type="submit" value="Like">


                        <?php
                        }

                        // user has reported or not
                        if ($result3 && $result3->num_rows > 0) {
                            $row3 = $result3->fetch_assoc();
                            $reportId = $row3['id'];
                        ?>
                            <input type='hidden' name='reportId' value="<?php echo $reportId ?>">
                            <p class="btn btn-warning">Reported</p>
                        <?php
                        } else {
                        ?>
                            <input name="btnReport" class="btn btn-warning" type="submit" value="Report">
                        <?php
                        }
                        ?>

                    </form>
                </div>
                <div class="react">
                    <div class="icon">
                        <p><i class="fa-solid fa-heart"></i> &nbsp; <?php echo isset($rowlike['No4Likes']) ? $rowlike['No4Likes'] : "0" ?></p>
                    </div>
                    <div class="icon">
                        <p><i class="fa-solid fa-flag"></i> &nbsp; <?php echo isset($rowreport['No4Reports']) ? $rowreport['No4Reports'] : "0" ?></p>
                    </div>

                </div>

            <?php

            } else {
            ?>
            <h5>Login to react or report</h5>
                <div class="react">
                    <div class="icon">
                        <p><i class="fa-solid fa-heart"></i> &nbsp; <?php echo isset($rowlike['No4Likes']) ? $rowlike['No4Likes'] : "0" ?></p>
                    </div>
                    <div class="icon">
                        <p><i class="fa-solid fa-flag"></i> &nbsp; <?php echo isset($rowreport['No4Reports']) ? $rowreport['No4Reports'] : "0" ?></p>
                    </div>

                </div>

            <?php
            }
            ?>


        </div>


    </div>
    <div class="footer">
        <?php
        include("footer.php") ?>
    </div>
    </div>
    <script src="script.js"></script>
</body>

</html>