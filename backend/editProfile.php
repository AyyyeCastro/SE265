<!DOCTYPE html>
<?php
include_once '../include/functions.php';
include_once '../model/userController.php';

session_start();
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
$userID = $_SESSION['userID'];
$userInfo = $userDatabase->getUserDetails($userID);
// Get all of the States from the database. Fills dropdown list.
$stateList = $userDatabase->getAllStates();
# ----------------#


if (isPostRequest()) {
   if (isset($_POST['updateBtn'])) {
      $userName = filter_input(INPUT_POST, 'userName');
      $userInnie = filter_input(INPUT_POST, 'userInnie');
      $userBio = filter_input(INPUT_POST, 'userBio');
      $userPW = filter_input(INPUT_POST, 'userPW');
      $userState = filter_input(INPUT_POST, 'userState');

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

      if ($userDatabase->updateProfile($userName, $PW, $userInnie, $userBio, $userID, $fileDestination, $userState)) {
         header("location: ../backend/viewProfile.php");
      } else {
         $message = "Error in updating profile, please try again.";
      }
   }
   if (isset($_POST['cancelBtn'])) {
      header('Location: viewProfile.php');
   }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <title>Edit Account</title>
   <meta charset="utf-8">
   <meta name="viewport" content="min-width=device-min-width, initial-scale=1">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
   <div class="container">
      <div id="mainDiv">
         <h1>Account Information</h1>
         <!-- SUPER important. enctype="multipart/form-data" in order to allow inserting profile pics -->
         <form action="editProfile.php" method="POST" enctype="multipart/form-data">
            <div>
               <label for="username">Username</label>
               <input type="text" id="userName" name="userName" class="form-control"
                  value="<?php echo $userInfo['userName']; ?>" required>
               <small id="userHelp" class="form-text text-muted">Remember, this is your login username. Keep this
                  private.</small>
            </div>
            <br>
            <div>
               <label for="userPW">Password</label>
               <input type="password" id="userPW" name="userPW" class="form-control">
               <small id="innieHelp" class="form-text text-muted">Do not enter anything, if you want to keep the same
                  Password.</small>
            </div>
            <br>
            <div>
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
            <br>
            <div>
               <label for="userInnie">Your Innie Handle (@)</label>
               <input type="text" id="userInnie" name="userInnie" class="form-control"
                  value="<?php echo $userInfo['userInnie']; ?>" maxlength="15" required>
               <small id="innieHelp" class="form-text text-muted">Your public handle, and what people will see you
                  as.</small>
            </div>
            <br>
            <div>
               <label for="userBio">Bio</label>
               <textarea id="userBio" name="userBio" class="form-control"
                  required><?php echo $userInfo['userBio']; ?></textarea>
            </div>
            <br>
            <div>
               <label for="userProfilePicture">Change Profile Avie</label>
               <input type="file" id="userProfilePicture" name="userProfilePicture" class="form-control"
                  accept="image/*">
               <small id="innieHelp" class="form-text text-muted">Don't insert a file to maintain the same avie.</small>
            </div>

            <!-- Work in progress... Ensure this boolean can only be viewed by ADMIN and/or MODS -->
            <br>
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="isModerator">
               <label class="form-check-label" for="isModerator">
                  Make Moderator
               </label>
            </div>
            <!------------>

            <br>
            <div>
               <input type="submit" class="btn btn-primary" name="updateBtn" value="update" />
               <input type="submit" class="btn btn-secondary" name="cancelBtn" value="cancel"
                  onclick="return confirm('This will remove all progress. Leave page?')">
            </div>
         </form>
         <br>
         <?php echo $message ?>
      </div>
   </div>
</body>

</html>