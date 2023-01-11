<?php
   session_start();
   include_once __DIR__ . '/include/functions.php';
   include_once __DIR__ . '/model/userController.php';

   $_SESSION['isLoggedIn'] = false;


   $message = "";
   if (isPostRequest()) 
   {
      $userName = filter_input(INPUT_POST, 'userName');
      $PW = filter_input(INPUT_POST, 'userPW');
      $userInnie = filter_input(INPUT_POST, 'userInnie');
      $userBio = filter_input(INPUT_POST, 'userBio');

      #--- Profile pictures -- #
      #$file = $_FILES['userProfilePicture'];
      #$fileDestination = 'uploaded/' . $file['name'];
      #move_uploaded_file($file['tmp_name'], $fileDestination);
      # ---------------------- #

      $configFile = __DIR__ . '/model/dbconfig.ini';
      try 
      {
         $userDatabase = new Users($configFile);
      } 
      catch ( Exception $error ) 
      {
         echo "<h2>" . $error->getMessage() . "</h2>";
      }   
    
      #if you add profile pictures back to the signup sheet -> 
      # make sure u include $fileDestination in the userSignup parameters.
      if($userDatabase->userSignup($userName, $PW, $userInnie, $userBio)){
           $message = "Signed up! You can now login.";
       } 
       
       else{
           $message = "Error in signing up, please try again.";
       }
    }
 

    
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Sign Up Account</title>
   <meta charset="utf-8">
   <meta name="viewport" content="min-width=device-min-width, initial-scale=1">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div id="mainDiv">

      <h1>User Registration</h1>
      <form action="signup.php" method="POST" enctype="multipart/form-data">
        <div>
          <label for="username">Username</label>
          <input type="text" id="userName" name="userName" class="form-control" required>
          <small id="innieHelp" class="form-text text-muted">Create a login username, do not share this with anyone.</small>
        </div>

        <br>
        <div>
          <label for="userPW">Password</label>
          <input type="password" id="userPW" name="userPW" class="form-control" required>
          <small id="innieHelp" class="form-text text-muted">Create a login password, do not share this with anyone.</small>
        </div>

        <br>
        <div>
          <label for="userInnie">Your Innie Handle (@)</label>
          <input type="text" id="userInnie" name="userInnie" class="form-control" required>
          <small id="innieHelp" class="form-text text-muted">This will be what people on PlugIn see you as.</small>
        </div>

        <div>
          <!-- Hidden input, that will create the default bio "Say something about yourself". This connects the bio to the user's id upon sign up. -->
          <input type="hidden" id="userBio" name="userBio" class="form-control" value="Say something about yourself..." required>
        </div>

        <br>
        
      <!--
        <div>
          <label for="userProfilePicture">Profile Picture</label>
          <input type="hidden" id="userProfilePicture" name="userProfilePicture" class="form-control" accept="image/*" required>
        </div>
       -->

        <div>
          <br>
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </div>
      </form>

      <a href="login.php">Back to login page</a>
    </div>

    <br>
    <?php echo $message ?>
  </div>
</body>
</html>
</body>
</html>
