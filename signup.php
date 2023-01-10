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

      $configFile = __DIR__ . '/model/dbconfig.ini';
      try 
      {
         $userDatabase = new Users($configFile);
      } 
      catch ( Exception $error ) 
      {
         echo "<h2>" . $error->getMessage() . "</h2>";
      }   
    

      if($userDatabase->userSignup($userName, $PW) ){
      echo "Signed up! You can now login.";} 
      
      else{
      echo "Error:";}
   }
    
?>


<form action="signup.php" method="POST">
  <div>
    <label for="username">Username</label>
    <input type="text" id="userName" name="userName">
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" id="userPW" name="userPW">
  </div>
  <div>
    <button type="submit">Sign Up</button>
  </div>
</form>

<a href="login.php">Back to login page</a>

