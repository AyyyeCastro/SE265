<?php
   include_once '../include/functions.php';
   include_once '../include/header.php';
   include_once '../model/userController.php';

   if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn'])
   {
      header("location: ../login.php"); 
      exit;
   }
   

   $message = "";
   $configFile = '../model/dbconfig.ini';
   try 
   {
      $userDatabase = new Users($configFile);
   } 
   catch ( Exception $error ) 
   {
      echo "<h2>" . $error->getMessage() . "</h2>";
   }   
  
   # -- Important -- #
   # Set the session outside of the post request, so that the forms can get pre-filled. 
   $userID = $_SESSION['userID'];
   $userInfo = $userDatabase->getUserDetails($userID);





   
   # ----------------#
?>

<style>
   .img-container{
      position: relative;
   }
   
   .img-overlay{
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
   }
   
   .img-overlay img {
      position: absolute;
      top: 90%;
      left: 60%;
      transform: translate(-320%, -40%);
   }
</style>

<div class="container">
    <div id="mainDiv">
        <div id ="profileHeader">
           <br>
           <div class="container-fluid bg-light">
              <div class="container">
                 <div class="row" style="padding: 10px;">
                    <div class="col-md-4">
                       <div class="img-container">
                          <?php 
                             $defaultAvie = "../include/default-avie/default-avie.jpg";
                             if (is_null($userInfo['userPic']) || empty($userInfo['userPic'])) { 
                                echo "<img src= '$defaultAvie' class='img-fluid rounded-circle' alt='profile picture' style='height: 175px; width: 175px; border: solid 2px blue;'>";
                             }
                              else{
                                echo "<img src='" . $userInfo['userPic'] . "' class='img-fluid rounded-circle' alt='profile picture' style='height: 175px; width: 175px; border: solid 2px blue;'>";
                             }
                             ?>

                           <div class="changePicIcon">
                              <a href="../backend/editUserPic.php" class="img-overlay">
                              <img src="../include/icons/change-avie.png" class="img-fluid" style="height: 40px; width: 40px;">
                              </a>
                           </div>
                           
                       </div>
                    </div>

                    <div class="col-md-7" style="padding: 10px;">
                       <h1><?php echo $userInfo['userInnie']; ?></h1> 
                       <small id="bioTitle" class="form-text text-muted">Biography</small>
                       <p><?php echo $userInfo['userBio']; ?></p>
                    </div>

                     <!-- The following code would be inside the 'profileHeader' div in your viewProfile.php file, most likely in the same area where you have the "Edit" button currently -->

                     <div class="col-md-1" style="padding: 10px;">
                        <!-- Check if the currently logged in user's ID matches the ID of the profile being viewed -->
                        <?php if ($_SESSION['userID'] === $userInfo['userID']) { ?>
                           <p style="text-align: right;"><a href="../backend/editProfile.php">Edit</a><p>
                        <?php } ?>
                     </div>

                 </div> <!-- Row -->
              </div> <!-- container -->
           </div> <!-- container bg -->
        </div> <!-- div profileHeader -->
        <br>  
    </div> <!-- main div -->
</div>
</body>
</html>






