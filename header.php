
<a class="logo" href="index.php"><img  src="images/DISPEL.jpg" alt=""></a>
<div class="navibar <?php echo isset($currentPage) ? $currentPage : ''; ?>">
    <a href="newsletter.php" class="<?php echo $currentPage === 'newsletter' ? 'currentTab' : ''; ?>">Newsletter</a>
    <a href="playerreg.php" class="<?php echo $currentPage === 'playerreg' ? 'currentTab' : ''; ?>">Players</a>
    <a href="teamreg.php" class="<?php echo $currentPage === 'teamreg' ? 'currentTab' : ''; ?>">Teams</a>
    <a href="tournament.php" class="<?php echo $currentPage === 'tournament' ? 'currentTab' : ''; ?>">Tournaments</a>
    <a href="match.php" class="<?php echo $currentPage === 'match' ? 'currentTab' : ''; ?>">Matches</a>
    
</div>

<!-- <img src="images/DISPEL.png" alt=""> -->
<div class="loginModule" >
<?php echo isset($_SESSION['userName']) ? $_SESSION['userName'] : 'Not Logged in'; ?><br>
 <?php 
 if(!isset($_SESSION['userId'])){
?>
<a href="login.php"><i class="fa-solid fa-user btn btn-secondary"></i></a>
<?php
 }
 elseif(isset($_SESSION['userId']) && $_SESSION['userRoleId']==0)
 {
?>
<div class="logInOut">
     <a href="profile.php?id=<?php echo $_SESSION['userId'] ?>"><i class="fa-solid fa-user btn btn-secondary"></i></a>
     <a href="logout.php?"><i class="fa-solid fa-arrow-right-from-bracket btn btn-secondary"></i></a>
     </div>
<?php

 }
 else{
?>
<div class="logInOut">
     <a href="logout.php?"><i class="fa-solid fa-arrow-right-from-bracket btn btn-secondary"></i></a>
     </div>
<?php

 } ?>
</div>
