<!DOCTYPE html>
<html lang="en">
<?php
$currentPage = 'match';
include_once("config/regdbconnect.php");
session_start();
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/cf47e7251d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">

    <script>
        function toggleScoreForm(matchId) {
            var form = document.getElementById("scoreForm_" + matchId);
            var button = document.getElementById("btnScore_" + matchId);
            var view = document.getElementById("matchView_" + matchId);
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
                button.style.display = "none";
                view.style.display = "none";
            } else {
                form.style.display = "none";
                button.style.display = "inline";
                view.style.display = "inline";
            }
        }
    </script>
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
                    <h4>Insert Match to a Tournament</h4>
                </div>
                <?php
                if (isset($_POST["btnSubmit"])) {
                    $title = $_POST["mtitle"];
                    $format = $_POST["mformat"];
                    $team1 = $_POST["mteam1"];
                    $team2 = $_POST["mteam2"];
                    $tour = $_POST["mtour"];
                    $date = $_POST["mdate"];
                    $time = $_POST["mtime"];

                    $sql = "INSERT INTO tbl_match (matchId, matchTitle, formatId, team1Name, team2Name, tourId, matchDate, matchTime,status) VALUES (NULL,'$title','$format','$team1','$team2','$tour','$date','$time','0')";

                    if ($conn->query($sql) == true) {
                        echo "Record inserted successfully";
                        header("location:match.php");
                        exit();
                    }
                }

                if (isset($_POST['btnScoreUpdate'])) {

                    $matchid = $_POST['matchid'];
                    $team1score = $_POST['team1Score'];
                    $team2score = $_POST['team2Score'];



                    $sql = "UPDATE tbl_result SET team1score='$team1score',team2score='$team2score' WHERE matchId=' $matchid'";
                    if ($conn->query($sql)) {

                        header("location:match.php");
                    } else {
                        echo "ERROR";
                    }
                }
                if (isset($_POST['btnComplete'])) {
                    $matchid = $_POST['matchid'];
                    $sql = "UPDATE tbl_match SET status='1' WHERE matchId='$matchid' ";
                    if ($conn->query($sql)) {
                        $sql1 = "INSERT INTO tbl_result (id,matchId,team1score,team2score) VALUES (NULL,'$matchid',NULL,NULL)";
                        $conn->query($sql1);
                        header("location:match.php");
                    } else {
                        echo "ERROR";
                    }
                }
                ?>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="register">
                        <p class="labelTag">Match Title</p>
                        <input name="mtitle" type="text" class="form-control" required>
                    </div>
                    <div class="register">
                        <?php
                        $ssql = "SELECT * FROM tbl_format";
                        $r = $conn->query($ssql);
                        ?>
                        <p class="labelTag">Format</p>
                        <select name="mformat" class="selectTag" required>
                            <option>Select Format</option>
                            <?php
                            while ($row1 = $r->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $row1['formatId'] ?>">
                                    <?php echo $row1['formatName'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="register">
                        <?php
                        $ssql = "SELECT * FROM tbl_team";
                        $r = $conn->query($ssql);
                        ?>
                        <p class="labelTag">First Team</p>
                        <select name="mteam1" class="selectTag" required>
                            <option>Select First Team</option>
                            <?php
                            while ($row1 = $r->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $row1['teamId'] ?>">
                                    <?php echo $row1['teamName'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="register">
                        <?php
                        $ssql = "SELECT * FROM tbl_team";
                        $r = $conn->query($ssql);
                        ?>
                        <p class="labelTag">Second Team</p>
                        <select name="mteam2" class="selectTag" required>
                            <option>Select Second Team</option>
                            <?php
                            while ($row1 = $r->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $row1['teamId'] ?>">
                                    <?php echo $row1['teamName'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="register">
                        <?php
                        $ssql = "SELECT * FROM tbl_tour";
                        $r = $conn->query($ssql);
                        ?>
                        <p class="labelTag">Tournament Name</p>
                        <select name="mtour" class="selectTag" required>
                            <option>Select Tournament</option>
                            <?php
                            while ($row1 = $r->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $row1['tourId'] ?>">
                                    <?php echo $row1['tourName'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="register">
                        <p class="labelTag">Match Date</p>
                        <input name="mdate" type="date" class="form-control" required>
                    </div>
                    <div class="register">
                        <p class="labelTag">Match Time</p>
                        <input name="mtime" type="time" class="form-control" required>
                    </div>
                    <div class="register">
                        <input name="btnSubmit" type="submit" class="btn btn-primary" value="Create">
                    </div>

                </form>
            </div>


            <div class="feed">
                <?php
                $sql = "SELECT * FROM tbl_match WHERE status='0'";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {

                ?>
                    <div class="matchContainer">
                        <h4>Upcomming Matches</h4>
                        <?php while ($row = $result->fetch_assoc()) {
                            $matchid = $row['matchId'];
                            $formatname = $row['formatId'];
                            $team1name = $row['team1Name'];
                            $team2name = $row['team2Name'];
                            $tourname = $row['tourId'];


                        ?>
                            <div class="matchCard">
                                <img class="matchBg" src="images/matchbg.jpg" alt="">
                                <?php $ssql = "SELECT teamName,teamImage FROM tbl_team WHERE teamId='$team1name'";
                                $r = $conn->query($ssql);
                                $row1 = $r->fetch_assoc(); ?>
                                <div class="matchTeam">
                                    <img class="whImg" src="uploadfiles/<?php echo $row1['teamImage']; ?>" alt="Image Not Found">
                                    <br>
                                    <?php

                                    echo isset($row1['teamName']) ? $row1['teamName'] : "Team Not Found" ?>
                                </div>

                                <div class="matchInfo">
                                    <?php
                                    $ssql = "SELECT tourName FROM tbl_tour WHERE tourId='$tourname'";
                                    $r = $conn->query($ssql);
                                    $row1 = $r->fetch_assoc();
                                    ?>
                                    <h4><?php echo $row1['tourName'] ?></h4>

                                    <div class="matchDesc">
                                        <p><?php echo  $row['matchTitle'] ?></p>
                                        <?php
                                        $ssql = "SELECT formatName FROM tbl_format WHERE formatId='$formatname'";
                                        $r = $conn->query($ssql);
                                        $row1 = $r->fetch_assoc();
                                        ?>
                                        <p><?php echo $row1['formatName'] ?></p>

                                    </div>

                                    <div class="matchScore">
                                        <h5>TBD</h5>
                                        <h4>VS</h4>
                                        <h5>TBD</h5>
                                    </div>
                                    <div class="matchDateTime">
                                        <p><?php echo date("F d, Y", strtotime($row['matchDate'])) ?></p>
                                        &nbsp;
                                        <p><?php echo date("g:i A", strtotime($row['matchTime']))  ?></p>
                                    </div>

                                    <?php
                                    if (isset($_SESSION['userRoleId'])) {
                                        if ($_SESSION['userRoleId'] == 0) {
                                            echo "";
                                        } elseif ($_SESSION['userRoleId'] == 1) {
                                    ?>
                                            <form action="#" method="POST">
                                                <input name="matchid" type="hidden" value="<?php echo $row['matchId'];  ?>">
                                                <input name="btnComplete" class="btn btn-success" type="submit" value="Mark As Completed">
                                            </form>
                                    <?php
                                        }
                                    } else {
                                    }
                                    ?>
                                </div>
                                <div class="matchTeam">
                                    <?php $ssql = "SELECT teamName,teamImage FROM tbl_team WHERE teamId='$team2name'";
                                    $r = $conn->query($ssql);
                                    $row1 = $r->fetch_assoc(); ?>
                                    <img class="whImg" src="uploadfiles/<?php echo $row1['teamImage']; ?>" alt="Image Not Found">
                                    <br>
                                    <?php echo isset($row1['teamName']) ? $row1['teamName'] : "Team Not Found" ?>
                                </div>





                            </div>
                            <br>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                } else {
                    echo "No Upcomming Matches.Stay Tuned!";
                }
                ?>
                <div class="matchContainer">
                    <h4>Completed Matches</h4>
                    <?php
                    $sql = "SELECT * FROM tbl_match WHERE status='1' ORDER BY matchId DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows < 0) {
                        echo "No Completed match at this time";
                    } else {

                        while ($row = $result->fetch_assoc()) {
                            $matchid = $row['matchId'];
                            $formatname = $row['formatId'];
                            $team1name = $row['team1Name'];
                            $team2name = $row['team2Name'];
                            $tourname = $row['tourId'];


                    ?>
                            <div class="matchCard">
                                <img class="matchBg" src="images/matchbg.jpg" alt="">
                                <div class="matchTeam">
                                    <?php
                                    $ssql = "SELECT teamName,teamImage FROM tbl_team WHERE teamId='$team1name'";
                                    $r = $conn->query($ssql);
                                    $row1 = $r->fetch_assoc();
                                    ?>
                                    <img class="whImg" src="uploadfiles/<?php echo $row1['teamImage']; ?>" alt="Image Not Found">
                                    <br>
                                    <?php
                                    echo isset($row1['teamName']) ? $row1['teamName'] : "Team Not Found" ?>
                                </div>
                                <div class="matchInfo">
                                    <?php
                                    $ssql = "SELECT tourName FROM tbl_tour WHERE tourId='$tourname'";
                                    $r = $conn->query($ssql);
                                    $row1 = $r->fetch_assoc();
                                    ?>
                                    <h4><?php echo $row1['tourName']; ?></h4>
                                    <div class="matchDesc">
                                        <p><?php echo  $row['matchTitle'] ?></p>
                                        <p><?php
                                            $ssql = "SELECT formatName FROM tbl_format WHERE formatId='$formatname'";
                                            $r = $conn->query($ssql);
                                            $row1 = $r->fetch_assoc();
                                            echo $row1['formatName'] ?></p>
                                    </div>

                                    <?php

                                    if (!isset($_SESSION['userRoleId']) || $_SESSION['userRoleId'] == 0) {
                                        $ssql = "SELECT team1score,team2score FROM tbl_result WHERE matchId='$matchid'";
                                        $r = $conn->query($ssql);
                                        $row1 = $r->fetch_assoc();
                                    ?>
                                        <div class="matchScore">
                                            <p><?php echo isset($row1['team1score']) ? $row1['team1score'] : "TBD"; ?></p>
                                            <h4>VS</h4>
                                            <p><?php echo isset($row1['team2score']) ? $row1['team2score'] : "TBD"; ?></p>
                                        </div>
                                    <?php
                                    } elseif ($_SESSION['userRoleId'] == 1) {

                                        $ssql = "SELECT team1score,team2score FROM tbl_result WHERE matchId='$matchid'";
                                        $r = $conn->query($ssql);
                                        $row1 = $r->fetch_assoc();
                                    ?>
                                        <div id="matchView_<?php echo  $row['matchId']; ?>" class="matchScore">
                                            <h5><?php echo isset($row1['team1score']) ? $row1['team1score'] : "TBD"; ?></h5>
                                            <h4>VS</h4>
                                            <h5><?php echo isset($row1['team2score']) ? $row1['team2score'] : "TBD"; ?></h5>
                                        </div>
                                        <form id="scoreForm_<?php echo $row['matchId']; ?>" action="#" method="POST" style="display: none;">
                                            <?php
                                            $ssql = "SELECT team1score,team2score FROM tbl_result WHERE matchId='$matchid'";
                                            $r = $conn->query($ssql);
                                            $row1 = $r->fetch_assoc();
                                            ?>
                                            <div class="matchScore">
                                                <input type="hidden" name="matchid" value="<?php echo $matchid; ?>">
                                                <h5>
                                                    <input name="team1Score" class="scoreInput" type="number" value="<?php echo isset($row1['team1score']) ? $row1['team1score'] : ''; ?>" required>
                                                </h5>
                                                <h4>VS</h4>
                                                <h5>
                                                    <input name="team2Score" class="scoreInput" type="number" value="<?php echo isset($row1['team2score']) ? $row1['team2score'] : ''; ?>" required>
                                                </h5>

                                            </div>
                                            <input name="btnScoreUpdate" class="btn btn-success" type="submit" value="Save">
                                        </form>

                                        <button id="btnScore_<?php echo $row['matchId']; ?>" class="btn btn-primary" onclick="toggleScoreForm(<?php echo $row['matchId']; ?>)">Edit Score</button>
                                    <?php
                                    }

                                    ?>






                                    <div class="matchDateTime">
                                        <p><?php echo date("F d, Y", strtotime($row['matchDate'])) ?></p>
                                        &nbsp;
                                        <p><?php echo date("g:i A", strtotime($row['matchTime']))  ?></p>
                                    </div>
                                </div>

                                <div class="matchTeam">
                                    <?php
                                    $ssql = "SELECT teamName,teamImage FROM tbl_team WHERE teamId='$team2name'";
                                    $r = $conn->query($ssql);
                                    $row1 = $r->fetch_assoc();
                                    ?>
                                    <img class="whImg" src="uploadfiles/<?php echo $row1['teamImage']; ?>" alt="Image Not Found">
                                    <br>
                                    <?php
                                    echo isset($row1['teamName']) ? $row1['teamName'] : "Team Not Found" ?>
                                </div>
                            </div>
                            <br>
                        <?php
                        }
                        ?>
                </div>
            <?php

                    }
            ?>
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