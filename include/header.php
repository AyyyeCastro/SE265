<?php
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
<style>
  .navbar{
    border-bottom: 1px solid rgba(186, 186, 186, .4); /* first 3 are the color, last is the opacity */
    background-clip: padding-box; 
    -webkit-background-clip: padding-box; 
  }
</style>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <img src="../include/PlugIn-Icon.png" class="img-fluid rounded-circle" width="40" height="40" class="d-inline-block align-top" alt="">
    <a class="navbar-brand" href="plugInHome.php">Plugin</a>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <!-- Everyone -->

        <!-- Signed in only -->
        <?php if (isUserLoggedIn()) 
        {?>
          <li class="nav-item active">
            <a class="nav-link" href="postListing.php">List Sale <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewProfile.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logoff.php">Logout</a>
          </li>
          <?php
        } ?>

        <!-- only if not signed in -->
        <?php if (!isUserLoggedIn()) 
        { ?>
          <li class="nav-item">
            <a class="nav-link" href="logoff.php">Login</a>
          </li>
          <?php
        } ?>
      </ul>

      <form class="form-inline my-2 my-lg-0" method="post" action="displayResults.php">
  <select class="form-control mr-sm-2" name="search_option">
    <option value="Products">Products</option>
    <option value="Sellers">Sellers</option>
  </select>
  <input class="form-control mr-sm-2" type="search" placeholder="Search PlugIn" aria-label="Search" name="inputName"/>
  <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" value="Search">Search</button>
</form>

    </div>
  </nav>


  
   



  

