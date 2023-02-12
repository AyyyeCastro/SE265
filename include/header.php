<!DOCTYPE html>
<?php
  require_once '../include/functions.php';
?>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PlugIn</title>

  <!-- stylesheets -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500&display=swap" rel="stylesheet">
  <!-- scripts -->
  <script src="https://cdn.tiny.cloud/1/9yk0iyxnanrkhcdqgc0l40rq3lxpl4ji336zutoiwao5vbd7/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="https://kit.fontawesome.com/7a790d5aa6.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<style>
  .navbar{
    border-bottom: 1px solid rgba(186, 186, 186, .4); /* first 3 are the color, last is the opacity */
    background-clip: padding-box; 
    -webkit-background-clip: padding-box; 
  }
  body, html{
    height: 100%;
    font-size: 16px;
    font-family: 'Sora', sans-serif;
    color: black;
  }

  .make-centered {
      height: 100%;
      display: flex;
      align-items: center;
   }
  a{
    color: #506d90;
    text-decoration: none; /* no underline */
  }
  a .hover{
    color: #506d90;
    font-weight: bold;
    text-decoration: none; /* no underline */
  }
  .btnLogOff, .btnInbox, .btnProfile{}
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
            <a class="nav-link" href="postListing.php"><button class="btn"><i class="fa-solid fa-cash-register fa-xl"></i></button> Sell Item</a>
          </li>
          <li class="nav-item btnProfile">
            <a class="nav-link make-centered" href="viewProfile.php"><button class="btn"><i class="fa-solid fa-user fa-xl"></i></button> Profile</a>
          </li>
          <li class="nav-item btnInbox">
            <a class="nav-link make-centered" href="viewInbox.php"><button class="btn"><i class="fa-solid fa-bell fa-xl"></i></button> Inbox</a>
          </li>

          <li class="nav-item btnLogOff">
            <a class="nav-link make-centered" href="logoff.php" onclick="return confirm('Logout?')"><button class="btn"><i class="fa-solid fa-plug-circle-minus fa-xl"></i></button> Logout</a>
          </li>
          <?php
        } ?>

        <!-- only if not signed in -->
        <?php if (!isUserLoggedIn()) 
        { ?>
          <li class="nav-item">
            <a class="nav-link" href="../login.php"><i class="fa-solid fa-plug-circle-plus fa-xl"></i> Login/signup</a>
          </li>
          <?php
        } ?>
      </ul>

      <form class="form-inline my-2 my-lg-0" method="get" action="displayResults.php">
        <select class="form-control mr-sm-2" name="search_option">
          <option value="Products">Products</option>
          <option value="Sellers">Sellers</option>
        </select>
        <input class="form-control mr-sm-2" type="search" placeholder="Search PlugIn" aria-label="Search" name="inputName"/>
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="search" value="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>

    </div>
  </nav>


  


  
   



  

