<!DOCTYPE html>
<?php
   include_once '../include/functions.php';
   include_once '../model/userController.php';

   session_start();
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



   if(isPostRequest()){

      $userName = filter_input(INPUT_POST, 'userName');
      $userInnie = filter_input(INPUT_POST, 'userInnie');
      $userBio = filter_input(INPUT_POST, 'userBio');
      $userPW = filter_input(INPUT_POST, 'userPW');


      #--- Profile pictures -- #
      $file = $_FILES['userProfilePicture'];
      $fileDestination = '../uploaded/' . $file['name'];
      move_uploaded_file($file['tmp_name'], $fileDestination);
      # ---------------------- #

      if($userDatabase->updateProfile($userName, $userPW, $userInnie, $userBio, $userID, $fileDestination)){
         header("location: ../backend/viewProfile.php"); 
      }
      else{
          $message = "Error in updating profile, please try again.";
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="min-width=device-min-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div id="mainDiv">
            <h1>Update Profile Avie</h1> <!-- SUPER important. enctype="multipart/form-data" in order to allow inserting profile pics -->
            <form action="editProfile.php" method="POST" enctype="multipart/form-data">
               <div>
                    <input type="hidden" id="userName" name="userName" class="form-control" value="<?php echo $userInfo['userName'];?>" required>
               <div>
                  <input type="hidden" id="userPW" name="userPW" class="form-control">
               </div>
               <div>
                  <input type="hidden" id="userInnie" name="userInnie" class="form-control" value="<?php echo $userInfo['userInnie'];?>" required>
                  
               </div>
               <div>
                  <input type="hidden" id="userBio" name="userBio" class="form-control" required value="<?php echo $userInfo['userBio'];?>">
               </div>


               <br>
               <div>
                  <input type="file" id="userProfilePicture" name="userProfilePicture" class="form-control" accept="image/*" required>
               </div>
               <br>
               <div>
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="viewProfile.php" style="padding: 15px;">Cancel</a>
               </div>
            </form>
            <br>
            <?php echo $message ?>
        </div>
    </div>
</body>
</html>

