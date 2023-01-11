<?php
  // This should already be loaded, but just in case
  include_once '../include/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>PlugIn</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>

  <nav class="navbar navbar-light bg-light">
    
    <a class="navbar-brand" href="../backend/youLoggedIn.php">
      <img src="../include/PlugIn-Icon.png" class="img-fluid rounded-circle" width="40" height="40" class="d-inline-block align-top" alt="">
      PlugIn
    </a>
  
    <div>
      <?php
      if (isUserLoggedIn()) 
      { ?>
      <ul class="nav navbar-nav navbar-right">
      <li><a href="viewProfile.php">View profile</a> &nbsp&nbsp <a href="logoff.php">Logout</a></li>
      </ul>
      <?php
      }  
      ?>
    </div>
  </nav>
   



  

