<?php
   include_once '../include/functions.php';
   include_once '../include/header.php';
   include_once '../model/userController.php';

   if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn'])
   {
      // work in progress... If not logged in when viewing prorfiles 
      // -> redirect to login w/ a prompt on why they should be logged in..
      echo "Please login before viewing profiles..";
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
  

   $userID = filter_input(INPUT_GET, 'userID');
   $userInfo = $userDatabase->getUserDetails($userID);
   $userListLog = $userDatabase->getUserListing($userID);
   

   # ----------------#
?>

<style>
   .img-container{
      position: relative;
   }
   
   .img-overlay{
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
   }
   
   .img-overlay img {
      position: absolute;
      top: 90%;
      left: 60%;
      transform: translate(-320%, -40%);
   }

   .ProfilePics {
      object-fit: cover;/* Do not scale the image */
      object-position: center; /* Center the image within the element */
      width: 200px;
      height: 200px;
      margin-bottom: 1rem;
   }

   .profDetails
   {
      word-spacing: 7px;
   }
</style>

<div class="container">
    <div id="mainDiv">
        <div id ="profileHeader">

           <br>
           <a href="searchUsers.php"><button class="btn btn-primary">Back</button></a>
           <br><br>

           <div class="container-fluid bg-light">
              <div class="container">
                 <div class="row" style="padding: 10px;">
                    <div class="col-md-4">
                       <div class="img-container">
                          <?php 
                             $defaultAvie = "../include/default-avie/default-avie.jpg";
                             if (is_null($userInfo['userPic']) || empty($userInfo['userPic'])) { 
                                echo "<img src= '$defaultAvie' class='ProfilePics rounded-circle' alt='profile picture' style='border: solid 2px blue;'>";
                             }
                              else{
                                echo "<img src='" . $userInfo['userPic'] . "' class='ProfilePics rounded-circle' alt='profile picture' style='border: solid 2px blue;'>";
                             }
                             ?>   
                       </div>
                    </div>

                    <div class="col-md-7" style="padding: 10px;">
                       <h1><?php echo $userInfo['userInnie']; ?></h1> 
                       <small id="joinDate" class="form-text text-muted profDetails"> 
                           Joined: <b><?php echo date("Y-m-d", strtotime($userInfo['userJoined'])); ?></b> 
                           State: <b><?php echo $userInfo['userState']; ?> </b>
                        </small>
                       <br>
                       <small id="bioTitle" class="form-text text-muted">Biography</small>
                       <p><?php echo $userInfo['userBio']; ?></p>
                    </div>

                     <!-- The following code would be inside the 'profileHeader' div in your viewProfile.php file, most likely in the same area where you have the "Edit" button currently -->

                     <div class="col-md-1" style="padding: 10px;">
                        <!-- Check if the currently logged in user's ID matches the ID of the profile being viewed -->
                        <?php if ($_SESSION['userID'] === $userInfo['userID']) { ?>
                           <p style="text-align: right;"><a href="../backend/editProfile.php">Edit</a><p>
                        <?php } ?>
                     </div>

                 </div> <!-- Row -->
              </div> <!-- container -->
           </div> <!-- container bg -->
        </div> <!-- div profileHeader -->
        <br>  

         <!-- BEGIN TABLE -->
         <table class="table table-hover" id="userListLog">
            <thead>
                  <tr>
                     <th></th> <!-- listID -->
                     <th></th> <!-- image -->
                     <th>Title</th>
                     <th>Price</th>
                     <th>Desc</th>
                     <th>Condition</th>
                     <th>Category</th>
                  </tr>
            </thead>
            <tbody>
                  <!-- For every value stored in the array we declared in the PHP section -->
                  <?php
                     foreach ($userListLog as $row): ?>
                  <tr>
                     <td>
                        <form action="" method="post">
                           <input type="hidden" name="p_id" value="<?= $row['listID']; ?>" />
                        </form>   
                     </td>
                     <!-- Display it's value, AND IMPORTANTLY set the links to lead to the user's profile according by userID -->
                     <td><img src="<?= $row['listProdPic']; ?>" style="height: 200px; width: 200px;"></td>
                     <td><?= $row['listProdTitle']; ?></td>
                     <td><?= $row['listProdPrice']; ?></td>
                     <td><?= $row['listDesc']; ?></td>
                     <td><?= $row['listCond']; ?></td>
                     <td><?= $row['listProdCat']; ?></td>
                  </tr>
            <?php endforeach;?>
            <!-- END for-loop -->
            </tbody>
         </table>
         <!-- END TABLE -->
    </div> <!-- main div -->
</div>
</body>
</html>






