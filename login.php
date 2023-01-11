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
    
        if ($userDatabase->isUserTrue($userName, $PW)) 
        {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['userID'] = $userDatabase->getUserId($userName);
            header ('Location: backend/youLoggedIn.php');
        } 
        else 
        {
           $message = "Incorrect login credentials. Please try again";
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>User Login</title>
   <meta charset="utf-8">
   <meta name="viewport" content="min-width=device-min-width, initial-scale=1">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
   <div class="se-pre-con"></div>
      <div class="container">
         <div id="mainDiv">

         <h1>User Login</h1>
         <form action="login.php" method="POST">
            <div class="form-group">
               <label for="username">Username</label>
               <input type="text" class="form-control" id="userName" name="userName">
            </div>
            <div class="form-group">
               <label for="password">Password</label>
               <input type="password" class="form-control" id="userPW" name="userPW">
            </div>
            <button type="submit" class="btn btn-primary">Log In</button>
         </form>
         
         <br>
         <a href="signup.php"><button type="submit" class="btn btn-primary">sign up</button></a>

         <?php 
            if ($message)
            {   ?>
            <div class="custom-text" style=" color: blue; padding: 15px; margin-top: 15px; max-width: 50vw; background-color: #FAF9F6; border: dotted 4px blue;"> 
            <?php echo $message; ?>
            </div>
            <?php } 
         ?>
      </div>
   </div>
</body>
</html>


    