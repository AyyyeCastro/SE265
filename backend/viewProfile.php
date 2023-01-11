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
            <div id ="profileHeader">
               <br>
               <div class="container-fluid bg-light">
                  <div class="container">
                     <div class="row" style="padding: 10px;">

                        <div class="col-md-4"> 
                           <img src="<?php echo '../'. $userInfo['userPic']; ?>" class="img-fluid rounded-circle" alt="profile picture" style="height: 175px; width: 175px; border: solid 2px blue;"">
                        </div>

                        <div class="col-md-8" style="padding: 10px;">
                           <h1><?php echo $userInfo['userInnie']; ?></h1>
                           <p><?php echo $userInfo['userBio']; ?></p>
                        </div>

                     </div> <!-- Row -->
                  </div> <!-- container -->
               </div> <!-- container bg -->
            </div> <!-- div profileHeader -->
            <br>
            <a href="youLoggedIn.php">Back Home</a>    
        </div> <!-- main div -->
    </div>
</body>
</html>






