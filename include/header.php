<!DOCTYPE html>
<?php
require '../include/functions.php';
require '../model/userController.php';
$configFile = '../model/dbconfig.ini';
try {
  $userDatabase = new Users($configFile);
} catch (Exception $error) {
  echo "<h2>" . $error->getMessage() . "</h2>";
}
?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PlugIn</title>

  <!-- stylesheets -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500&display=swap" rel="stylesheet">
  <!-- scripts -->
  <script src="https://cdn.tiny.cloud/1/9yk0iyxnanrkhcdqgc0l40rq3lxpl4ji336zutoiwao5vbd7/tinymce/5/tinymce.min.js"
    referrerpolicy="origin"></script>
  <script src="https://kit.fontawesome.com/7a790d5aa6.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>

</head>
<style>
  .navbar {
    border-bottom: 1px solid rgba(186, 186, 186, .4);
    /* first 3 are the color, last is the opacity */
    background-clip: padding-box;
    -webkit-background-clip: padding-box;
  }

  body,
  html {
    font-size: 16px;
    font-family: 'Sora', sans-serif;
    color: black;
  }

  .make-centered {
    height: 100%;
    display: flex;
    align-items: center;
  }

  a {
    color: #506d90;
    text-decoration: none;
    /* no underline */
  }

  a .hover {
    color: #506d90;
    font-weight: bold;
    text-decoration: none;
    /* no underline */
  }

  .navbar-brand {
    margin-left: 5px;
  }

  .siteIcon {
    border-radius: 10px;
  }
</style>

<body>
  <nav class="navbar navbar-expand-xl navbar-light bg-light">
    <a class="navbar-brand" href="plugInHome.php">
      <img src="../include/materials/PI-Icon4.png" class="siteIcon" width="50" height="50"
        class="d-inline-block align-top" alt="">
      Plugin
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <!-- Everyone -->

        <!-- Signed in only -->
        <?php if (isUserLoggedIn()): ?>
          <li class="nav-item"><samp></samp>
            <a class="nav-link make-centered" href="postListing.php">
              <button class="btn"><i class="fa-solid fa-cash-register fa-xl"></i></button> Sell Item
            </a>
          </li>

          <li class="nav-item btnInbox">
            <a class="nav-link make-centered" href="viewInbox.php">
              <button class="btn"><i class="fa-solid fa-comments-dollar fa-xl"></i></button> Messages
            </a>
          </li>
          <?php $sessionID = $_SESSION['userID'];
            if ($userDatabase->headerModCheck($sessionID)): ?>
            <li class="nav-item">
              <a class="nav-link make-centered" href="modTools.php">
                <button class="btn"><i class="fa-solid fa-gear fa-xl"></i></button> Mod Tools
              </a>
            </li>
          <?php endif ?>

          <!-- add this li item after the Inbox button -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle make-centered" href="#" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <button class="btn"><i class="fa-solid fa-user fa-xl"></i></button> Account
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="viewProfile.php">
                <button class="btn"><i class="fa-regular fa-id-badge fa-lg"></i></button> Your Profile
              </a>
              <a class="dropdown-item" href="viewSaleHistory.php">
                <button class="btn"><i class="fa-solid fa-boxes-packing fa-lg"></i></button>Your Sales
              </a>
              <a class="dropdown-item" href="viewPurchaseHistory.php">
                <button class="btn"><i class="fa-solid fa-box-archive fa-lg"></i></button>Your Orders
              </a>
              <a class="dropdown-item" href="logoff.php" onclick="return confirm('Logout?')">
                <button class="btn"><i class="fa-solid fa-plug-circle-minus fa-xl"></i></button> Logout
              </a>
            </div>
          </li>
        <?php endif ?>



        <!-- only if not signed in -->
        <?php if (!isUserLoggedIn()) { ?>
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
        <input class="form-control mr-sm-2" type="search" placeholder="Search PlugIn" aria-label="Search"
          name="inputName" />
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="search" value="Search"><i
            class="fa-solid fa-magnifying-glass"></i></button>
      </form>

    </div>
  </nav>