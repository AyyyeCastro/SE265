<?php
if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}

$message = "";
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
         header("location: ../backend/viewProfile.php");
      } else {
         $message = "Error in updating profile, please try again.";
      }
   }
}

?>