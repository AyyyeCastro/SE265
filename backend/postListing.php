<?php
   include_once '../include/functions.php';
   include_once '../include/header.php';
   include_once '../model/userController.php';

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
      $listProdCat = filter_input(INPUT_POST, 'inputProdCat');
      $listProdPrice = filter_input(INPUT_POST, 'inputProdPrice');
      $listProdTitle = filter_input(INPUT_POST, 'inputProdTitle');
      $listDesc = filter_input(INPUT_POST, 'inputProdDesc');
      $listCond = filter_input(INPUT_POST, 'inputProdCond');

      # -- Profile Pictures -- #
      # -- IMPORTANT!!! -- #
      $userInfo = $userDatabase->getUserDetails($userID);
      $fileDestination = $userInfo['listProdPic'];
      # First it get's the userInfo stored in the MySQL database, which I have linked to getUserDetails($userID)
      # Then set the DEFAULT $fileDestination to always be the previously set profile picture, stored in the DB.
      # This way if the user doesn't update their pic in the form, the previous image is still saved.
  
      #--- Profile Picture Traveling -- #
      $file = $_FILES['inputProdPic'];
      if ($file['error'] != UPLOAD_ERR_NO_FILE) {
          $fileDestination = '../backend/listingUpload/' . $file['name'];
          move_uploaded_file($file['tmp_name'], $fileDestination);
      }
      # ---------------------------------#
  
      if($userDatabase->postUserListing($userID, $listProdCat, $listProdPrice, $listProdTitle, $listDesc, 
      $listCond, $fileDestination)){
          header("location: ../backend/viewProfile.php"); 
      }else{
          $message = "Error in updating profile, please try again.";
      }
  }
?>

   <div class="container">
      <div id="mainDiv">
         <form action="postListing.php" method="post" enctype="multipart/form-data">
            <div>
               <label for="inputProdCat">Product Category:</label>
               <input type="text" class="form-control" id="inputProdCat" name="inputProdCat" required>
            </div>

            <div>
               <label for="inputProdPrice">Product price:</label>
               <input type="number" class="form-control" id="inputProdPrice" name="inputProdPrice" required>
            </div>

            <div>
               <label for="inputProdTitle">Product Name/Title:</label>
               <input type="text" class="form-control" id="inputProdTitle" name="inputProdTitle" required>
            </div>

            <div>
               <label for="inputProdDesc">Product Description:</label> <!-- listSummary in the db -->
               <textarea class="form-control" id="inputProdDesc" name="inputProdDesc" rows="5" required></textarea>
            </div>

            
            <div>
               <label for="inputProdCond">Product Condition:</label> <!-- listCondition in the db -->
               <textarea class="form-control" id="inputProdCond" name="inputProdCond" rows="5" required></textarea>
            </div>

            <div>
               <label for="inputProdPic">Upload Product Picture</label>
               <input type="file" id="inputProdPic" name="inputProdPic" class="form-control" accept="image/*">
            </div>

            <br>
            <input type="submit" class="btn btn-primary" value="Post Listing">
         </form>
      </div> <!-- main div -->
   </div>
</body>
</html>






