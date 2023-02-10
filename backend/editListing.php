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
  
   ## IMPORTANT -- A DELETE BUTTON WILL BE NEEDED. 
   ## NOT IMPLEMENTED YET.
   $deleteList =[];
   $userID = $_SESSION['userID'];
   $userInfo = $userDatabase->getUserDetails($userID);

   if(isGetRequest()){
      # -- Important -- #
      # Set the session outside of the post request, 
      # so that the forms can get pre-filled. 
      $listID = $_GET['listID'];
      #echo '<br>' . $listID . ' -- this is the list id from the GET<br>';
      
      # array to store all of the list details.
      $listDetails = $userDatabase->getListForm($listID);
      $catList = $userDatabase->getAllCategories();
      $condList = $userDatabase->getAllConditions();
      

      # DEBUG - DUMP THE listDetails array.
      #echo '<br><br> this is the listDetails container <br><br>';
      #var_dump($listDetails);
      #echo '<br><br>';

   }

   if(isPostRequest()){
      if (isset($_POST['updateBtn'])) 
      {
         $listID = filter_input(INPUT_POST, 'listID');
         
         $listProdCat = filter_input(INPUT_POST, 'inputProdCat');
         $listProdPrice = filter_input(INPUT_POST, 'inputProdPrice');
         $listProdTitle = filter_input(INPUT_POST, 'inputProdTitle');
         $listDesc = filter_input(INPUT_POST, 'inputProdDesc');
         $listCond = filter_input(INPUT_POST, 'inputProdCond');
         $listState = filter_input(INPUT_POST, 'inputProdState');


         # -- IMPORTANT!!! -- #
         $listDetails = $userDatabase->getListForm($listID);
         $catList = $userDatabase->getAllCategories();
         $condList = $userDatabase->getAllConditions();


         $fileDestination = $listDetails['listProdPic'];
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
   
         if($userDatabase->updateUserListing($listID, $listProdCat, $listProdPrice, $listProdTitle, 
         $listDesc, $listCond, $fileDestination, $listState)){
            header("location: ../backend/viewProfile.php"); 
         }else{
            $message = "Error posting new listing, please try again.";
         }
      }
      if (isset($_POST['cancelBtn'])){
         header('Location: viewProfile.php');
      }
      if (isset($_POST['deleteBtn'])){
         $listID = filter_input(INPUT_POST, 'listID');
         $deleteList = $userDatabase->deleteUserLising($listID);
         header('Location: viewProfile.php');
      }
  }
?>

   <div class="container">
      <div id="mainDiv">
         <form action="editListing.php" method="post" enctype="multipart/form-data">
            <div>
               <input type="hidden" id="listID" name="listID" value="<?= $listDetails['listID']; ?>" />
            </div>

            <div>
               <!-- product state. This is a hidden field. Value gathered automatically from user's profile state -->
               <input type="disabled" class="form-control" id="inputProdState" name="inputProdState" value="<?php echo $userInfo['userState']; ?>" readonly>
            </div>
            <br>

            <div>
               <label for="inputProdCat">Product Category:</label>
               <select class="form-control" id="inputProdCat" name="inputProdCat" required>
                  <option value="" disabled selected>Choose category</option>
                  <?php
                     foreach ($catList as $category) {
                        $selected = ($category['catGenre'] == $listDetails['listProdCat']) ? 'selected' : '';
                        echo '<option value="' . $category['catGenre'] . '" ' . $selected . '>' . $category['catGenre'] . '</option>';
                     }
                  ?>
               </select>
            </div>

            <div>
               <label for="inputProdPrice">Product price:</label>
               <input type="text" class="form-control" id="inputProdPrice" name="inputProdPrice"  value="<?php echo $listDetails['listProdPrice'];?>" required>
            </div>

            <div>
               <label for="inputProdTitle">Product Name/Title:</label>
               <input type="text" class="form-control" id="inputProdTitle" name="inputProdTitle" value="<?php echo $listDetails['listProdTitle']; ?>" required>
            </div>

            <div>
               <label for="inputProdDesc">Product Description:</label> 
               <textarea class="form-control" id="inputProdDesc" name="inputProdDesc" rows="5" required><?php echo $listDetails['listDesc']; ?></textarea>
            </div>

            
            <div>
               <label for="inputProdCond">Product Condition:</label> 
               <select class="form-control" id="inputProdCond" name="inputProdCond" required>
                  <option value="" disabled>Choose category</option>
                  <?php
                     foreach ($condList as $condition) {
                        $selected = ($condition['condType'] == $listDetails['listCondition']) ? 'selected' : '';
                        echo '<option value="' . $condition['condType'] . '" ' . $selected . '>' . $condition['condType'] . '</option>';
                     }
                  ?>
               </select>
            </div>


            <div>
               <label for="inputProdPic">Upload Product Picture</label>
               <input type="file" id="inputProdPic" name="inputProdPic" class="form-control" accept="image/*">
               <small id="prodPicHelp" class="form-text text-muted">Don't insert new files, if you want to keep the same ones already posted.</small>
            </div>

            <br>
            <div>
               <!-- Submit button -->
               <input type="submit" class="btn btn-primary" name="updateBtn" value="Update" />
               <!-- Cancel button -->
               <input type="submit" class="btn btn-secondary" name="cancelBtn" value="Cancel" onclick="return confirm('This will remove all progress. Leave page?')"/>
               <!-- Delete button -->
               <input type="submit" class="btn btn-warning" name="deleteBtn" value="Delete" onclick="return confirm('Are you sure you want to delete this listing? It is a permenant decision.')"/>
            </div>
         </form>

      </div> <!-- main div -->
   </div>
</body>
</html>






