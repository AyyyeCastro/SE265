<?php
   session_start();
   include_once '../include/functions.php';
   include_once '../include/header.php';
   include_once '../model/userController.php';

   if (!isUserLoggedIn())
   {
      header("location: ../login.php"); 
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
    <div class="container">
        <div id="mainDiv">
            <div>
               <br>
               <div class="container-fluid bg-light">
                  <div class="container">
                     <div class="row">

                        <div class="col-md-4"> <!--When I tie MySQL to profile pics I can do: echo $userInfo['profile_picture']; -->
                        <img src="../include/images/pin-head.png" class="img-fluid rounded-circle" alt="profile picture">
                        </div>

                        <div class="col-sm-9">
                        <h1><?php echo $userInfo['userInnie']; ?></h1>
                        <p><?php echo $userInfo['userBio']; ?></p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <br>
            <a href="youLoggedIn.php">Back Home</a>    
        </div>
    </div>
</body>
</html>

