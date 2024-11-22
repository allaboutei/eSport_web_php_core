<!DOCTYPE html>
<html lang="en">
<?php
$currentPage = 'index';
include_once "config/regdbconnect.php";
session_start();
ob_start();
if (isset($_SESSION['isCaptain'])) {
    $authCap = $_SESSION['isCaptain'];
} else {
    echo "";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
        <br>
        <div class="main ">
            <div class="slider" id="slider">
                <div class="slides"></div>
                <div id="navigation-manual" class="navigation-manual"></div>
            </div>

            <?php

            if (!isset($_SESSION['userRoleId'])) {
            ?>






            <?php
            } elseif (isset($_SESSION['userRoleId']) && $_SESSION['userRoleId'] == 1) {
            ?>
                <h3>Welcome Admin</h3>

                <div class="homePage">
                    <div class="mainPanel">
                        <div class="panelCard">
                            <h4>News</h4>
                            <?php
                            $sql = "SELECT COUNT(newsId) FROM tbl_news";
                            $resultNews = $conn->query($sql);
                            $rowNews = $resultNews->fetch_assoc();
                            ?>
                            <p><strong>Total News : <?php echo $rowNews['COUNT(newsId)']; ?></strong></p>
                            <a href="newsletter.php" class="btn btn-primary">Manage News</a>
                        </div>
                        <img src="images/DISPEL.png" alt="Image Not Found">
                    </div>
                    <div class="mainPanel">
                        <div class="panelCard">
                            <h4>Teams</h4>
                            <?php
                            $sql = "SELECT COUNT(teamId) FROM tbl_team";
                            $resultNews = $conn->query($sql);
                            $rowNews = $resultNews->fetch_assoc();
                            ?>
                            <p><strong>Total Teams : <?php echo $rowNews['COUNT(teamId)']; ?></strong></p>
                            <a href="teamreg.php" class="btn btn-primary">Manage Teams</a>
                        </div>
                        <img src="images/DISPEL.png" alt="Image Not Found">
                    </div>

                    <div class="mainPanel">
                        <div class="panelCard">
                            <h4>Tournaments</h4>
                            <?php
                            $sql = "SELECT COUNT(tourId) FROM tbl_tour";
                            $resultNews = $conn->query($sql);
                            $rowNews = $resultNews->fetch_assoc();
                            ?>
                            <p><strong>Tournaments created : <?php echo $rowNews['COUNT(tourId)']; ?></strong></p>
                            <a href="tournament.php" class="btn btn-primary">Manage Tournaments</a>
                        </div>
                        <img src="images/DISPEL.png" alt="Image Not Found">
                    </div>
                    <div class="mainPanel">
                        <div class="panelCard">
                            <h4>Players</h4>
                            <?php
                            $sql = "SELECT COUNT(playerId) FROM tbl_player";
                            $resultNews = $conn->query($sql);
                            $rowNews = $resultNews->fetch_assoc();
                            ?>
                            <p><strong>Total Players : <?php echo $rowNews['COUNT(playerId)']; ?></strong></p>
                            <a href="playerreg.php" class="btn btn-primary">Manage Players</a>
                        </div>
                        <img src="images/DISPEL.png" alt="Image Not Found">
                    </div>
                    <div class="mainPanel">
                        <div class="panelCard">
                            <h4>Users</h4>
                            <?php
                            $sql = "SELECT COUNT(userId) FROM tbl_user";
                            $resultNews = $conn->query($sql);
                            $rowNews = $resultNews->fetch_assoc();
                            ?>
                            <p><strong>Registered Users : <?php echo $rowNews['COUNT(userId)']; ?></strong></p>
                            <a href="userlist.php" class="btn btn-primary">Manage Users</a>
                        </div>
                        <img src="images/DISPEL.png" alt="Image Not Found">
                    </div>
                    <div class="mainPanel">
                        <div class="panelCard">
                            <h4>Matches</h4>
                            <?php
                            $sql = "SELECT COUNT(matchId) FROM tbl_match";
                            $resultNews = $conn->query($sql);
                            $rowNews = $resultNews->fetch_assoc();
                            ?>
                            <p><strong>Match Completed : <?php echo $rowNews['COUNT(matchId)']; ?></strong></p>
                            <a href="match.php" class="btn btn-primary">Manage Matches</a>
                        </div>
                        <img src="images/DISPEL.png" alt="Image Not Found">
                    </div>
                </div>
                <?php
            } else {
                $uid = $_SESSION['userId'];
                $sql = "SELECT tt.teamId,tt.teamName,tt.teamImage from tbl_team tt LEFT JOIN tbl_captain tc ON tt.teamId=tc.teamId  WHERE userId='$uid'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<h3>Welcome Back Captain</h3>";
                ?>
                    <p> Click Here to Check your Team Details <a href="allocate_player.php?id=<?php echo $row["teamId"]; ?>"><?php echo $row['teamName']; ?></a></p>
                    <img class="whImg" src="uploadfiles/<?php echo $row['teamImage'] ?>" alt="">
            <?php

                } else {
                    echo "<h5>You are now part of the community</h5>";
                }
            }

            ?>


        </div>
<br>
<br>
        <div class="footer">
            <?php
            include("footer.php");
            ?>
        </div>
    </div>
    <?php
    ob_end_flush();
    ?>
    <script>
        const images = [
            {
                src: "sliderImages/sliderimg1.jpg",
                alt: "Slide 1",
                link: "#"
            },{
                src: "sliderImages/sliderimg2.jpg",
                alt: "Slide 2",
                link: "#"
            },
            {
                src: "sliderImages/sliderimg3.png",
                alt: "Slide 3",
                link: "#"
            },
        ];

        const slider = document.getElementById("slider");
        const slidesContainer = slider.querySelector(".slides");
        const navigationManual = document.getElementById("navigation-manual");

        // Add slides dynamically
        images.forEach((image, index) => {
            const slide = document.createElement("div");
            slide.classList.add("slide");

            // Wrap image in link if `link` exists
            const imgWrapper = document.createElement(image.link ? "a" : "div");
            if (image.link) imgWrapper.href = image.link;

            const img = document.createElement("img");
            img.src = image.src;
            img.alt = image.alt;
            imgWrapper.appendChild(img);

            slide.appendChild(imgWrapper);
            slidesContainer.appendChild(slide);

            // Create navigation dots
            const navBtn = document.createElement("div");
            navBtn.classList.add("manual-btn");
            navBtn.dataset.index = index;
            navBtn.addEventListener("click", () => goToSlide(index));
            navigationManual.appendChild(navBtn);
        });

        let currentIndex = 0;

        // Function to navigate to a specific slide
        function goToSlide(index) {
            currentIndex = index;
            slidesContainer.style.transform = `translateX(-${index * 100}%)`;
            updateDots();
        }

        // Update active dot
        function updateDots() {
            navigationManual.querySelectorAll(".manual-btn").forEach((btn, idx) => {
                btn.classList.toggle("active", idx === currentIndex);
            });
        }

        // Auto-slide functionality
        setInterval(() => {
            currentIndex = (currentIndex + 1) % images.length;
            goToSlide(currentIndex);
        }, 3000);

        // Initialize slider
        goToSlide(0);
    </script>
</body>

</html>