<!DOCTYPE html>
<?php
ob_start();
include_once '../include/header.php';
include_once '../include/functions.php';
include_once '../model/userController.php';

if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}


$message = "";
$configFile = '../model/dbconfig.ini';
try {
   $userDatabase = new Users($configFile);
} catch (Exception $error) {
   echo "<h2>" . $error->getMessage() . "</h2>";
}

# -- Important -- #
# Set the session outside of the post request, so that the forms can get pre-filled. 
$userID = $_GET['userID'];
echo $userID;
$userInfo = $userDatabase->getUserDetails($userID);
// Get all of the States from the database. Fills dropdown list.
$stateList = $userDatabase->getAllStates();
# ----------------#
$sessionID = $_SESSION['userID'];
$modCheck = $userDatabase->isUserMod($sessionID);


if (isPostRequest()) {
   if (isset($_POST['updateBtn'])) {
      $userID = filter_input(INPUT_POST, 'userID');
      $userName = filter_input(INPUT_POST, 'userName');
      $userInnie = filter_input(INPUT_POST, 'userInnie');
      $userBio = filter_input(INPUT_POST, 'userBio');
      $userPW = filter_input(INPUT_POST, 'userPW');
      $userState = filter_input(INPUT_POST, 'userState');
      $isModerator = filter_input(INPUT_POST, 'isModerator');

      # -- Profile Pictures -- #
      # -- IMPORTANT!!! -- #
      $userInfo = $userDatabase->getUserDetails($userID);
      $fileDestination = $userInfo['userPic'];
      # First it get's the userInfo stored in the MySQL database, which I have linked to getUserDetails($userID)
      # Then set the DEFAULT $fileDestination to always be the previously set profile picture, stored in the DB.
      # This way if the user doesn't update their pic in the form, the previous image is still saved.

      #--- Profile Picture Traveling -- #
      $file = $_FILES['userProfilePicture'];
      if ($file['error'] != UPLOAD_ERR_NO_FILE) {
         $fileDestination = '../uploaded/' . $file['name'];
         move_uploaded_file($file['tmp_name'], $fileDestination);
      }
      # ---------------------------------#

      if ($userDatabase->updateProfile($userName, $userPW, $userInnie, $userBio, $userID, $fileDestination, $userState, $isModerator)) {
         header('Location: viewUsers.php?userID='. $userInfo['userID']);
      } else {
         $message = "Error in updating profile, please try again.";
      }
   }
   if (isset($_POST['cancelBtn'])) {
      header('Location: viewUsers.php?userID='. $userInfo['userID']);
   }
}


?>
<style>
   .container-fluid {
      height: 100vh;
   }

   .editProfContainer {
      width: 75%;
      margin-top: 15px;
      border-radius: 15px;
      border: 1px solid #E5E5E5;
      box-shadow: 5px 10px 10px #E5E5E5;
      padding: 15px;
   }

   .ProfilePics {
      object-fit: cover;
      /* Do not scale the image */
      object-position: center;
      /* Center the image within the element */
      width: 200px;
      height: 200px;
      border: solid 2px blue;
   }

   .newUserPP {
      object-fit: cover;
      /* Do not scale the image */
      object-position: center;
      margin-top: 1px;
      border: solid 2px blue;
      /* Center the image within the element */
      width: 97%;
      height: 97%;
   }


   .img-overlay {
      position: absolute;
      margin-left: 15px;
      top: 0;
      left: 0;
      width: 200px;
      height: 200px;
      pointer-events: all;
   }

   .img-overlay:hover {
      opacity: 20%;
      background-color: #F8F8F8;
   }


   .btnUpdatePP {
      Display: inline-block;
      position: absolute;
      top: 140px;
      left: 170px;
      pointer-events: all;
      background-color: purple;
   }

   input[type="file"] {
      display: none;
   }


   .custom-file-upload {
      height: 100%;
      width: 100%;
      display: inline-block;
      cursor: pointer;
   }

   .row {
      margin-top: 15px;
   }
</style>

<div class="container-fluid">
   <div class="container editProfContainer">
      <h1>Account Information</h1>
      <!-- SUPER important. enctype="multipart/form-data" in order to allow inserting profile pics -->
      <form action="editUserProfile.php" method="POST" enctype="multipart/form-data">

         <div class="row">
            <div class="col-md-12">
               <img id="newUserPP" class="newUserPP rounded-circle img-overlay" />

               <div class="img-container">
                  <?php
                  $defaultAvie = "../include/default-avie/default-avie.jpg";
                  if (is_null($userInfo['userPic']) || empty($userInfo['userPic'])) {
                     echo "<img src= '$defaultAvie' class='ProfilePics rounded-circle' alt='profile picture'>";
                  } else {
                     echo "<img src='" . $userInfo['userPic'] . "' class='ProfilePics rounded-circle' alt='profile picture'>";
                  }
                  ?>

                  <div class="changePPBox">
                     <div class="img-overlay">
                        <label class="custom-file-upload">
                           <input type="file" id="userProfilePicture" name="userProfilePicture" class="form-control"
                              accept="image/*">
                        </label>
                     </div>
                  </div>

               </div>
            </div>
         </div>

         <input type="hidden" id="userID" name="userID" class="form-control"
                  value="<?php echo $userInfo['userID']; ?>" required>

         <div class="row">
            <div class="col-md-12">
               <label for="username">Username</label>
               <input type="text" id="userName" name="userName" class="form-control"
                  value="<?php echo $userInfo['userName']; ?>" required>
               <small id="userHelp" class="form-text text-muted">Remember, this is your login username. Keep this
                  private.</small>
            </div>
         </div>

         <div class="row">
            <div class="col-md-12">
               <label for="userPW">Password</label>
               <input type="password" id="userPW" name="userPW" class="form-control"
                  value="<?php echo $userInfo['userPW']; ?>">
               <small id="innieHelp" class="form-text text-muted">Do not enter anything, if you want to keep the same
                  Password.</small>
            </div>
         </div>
         

         <div class="row">
            <div class="col-md-12">
               <select class="form-control" id="userState" name="userState">
                  <?php
                  $selectedState = (isset($_GET["listState"])) ? $_GET["listState"] : $userInfo['userState'];
                  echo '<option value="" ' . (($selectedState == '') ? 'selected' : '') . '>All States</option>';
                  foreach ($stateList as $states) {
                     $selected = ($states['stateName'] == $selectedState) ? 'selected' : '';
                     echo '<option value="' . $states['stateName'] . '" ' . $selected . '>' . $states['stateName'] . '</option>';
                  }
                  ?>
               </select>
            </div>

         </div>

         <div class="row">
            <div class="col-md-12">
               <label for="userInnie">Your Innie Handle (@)</label>
               <input type="text" id="userInnie" name="userInnie" class="form-control"
                  value="<?php echo $userInfo['userInnie']; ?>" maxlength="15" required>
               <small id="innieHelp" class="form-text text-muted">Your public handle, and what people will see you
                  as.</small>
            </div>
         </div>

         <div class="row">
            <div class="col-md-12">
               <label for="userBio">Bio</label>
               <textarea id="userBio" name="userBio" class="form-control"
                  required><?php echo $userInfo['userBio']; ?></textarea>
            </div>
         </div>



         <!--  Ensure this can only be viewed by ADMIN and/or MODS -->
         <?php if ($modCheck['isModerator'] == 'YES' || $modCheck['isOwner'] == 'YES'): ?>
            <div class="row">
               <div class="col-md-12">
                  <label for="isModerator">Is Moderator:</label>
                  <select name="isModerator" id="isModerator">
                     <option value="YES" <?php if ($userInfo['isModerator'] == 'YES') {
                        echo 'selected';
                     } ?>>YES</option>
                     <option value="NO" <?php if ($userInfo['isModerator'] == 'NO') {
                        echo 'selected';
                     } ?>>NO</option>
                  </select>
               </div>
            </div>
         <?php endif ?>
         <!------------>


         <div class="row">
            <div class="col-md-12">
               <input type="submit" class="btn btn-primary" name="updateBtn" value="update" />
               <input type="submit" class="btn btn-secondary" name="cancelBtn" value="cancel"
                  onclick="return confirm('This will remove all progress. Leave page?')">
            </div>
         </div>
      </form>
      <br>
      <?php echo $message ?>
   </div>
</div>
</body>

</html>

<?php include_once '../include/footer.php'; ?>
<script>
   document.getElementById('userProfilePicture').onchange = function () {
      var src = URL.createObjectURL(this.files[0])
      document.getElementById('newUserPP').src = src

      // Add an indicator to let the user know that the photo is ready to be submitted
      document.getElementById("photoIndicator").innerHTML = "Check to apply updated picture.";
      document.getElementById("btnUpdatePPBox").innerHTML = "<button type='submit' class='btn btn-primary btnUpdatePP'><i class='fa-solid fa-square-check fa-xl'></i></button>";

   }

</script>