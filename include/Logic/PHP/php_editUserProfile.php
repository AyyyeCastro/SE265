<?php
if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}

$message = "";

# -- Important -- #
# Set the session outside of the post request, so that the forms can get pre-filled. 
$userID = $_GET['userID'];

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
      if ($userDatabase->updateProfile($userName, $userInnie, $userBio, $userID, $userState, $isModerator)) {
         header('Location: editUserProfile.php?userID='. $userInfo['userID']);
      } else {
         $message = "Error in updating profile, please try again.";
      }
      
      // I intentionally want mods/admins to have to go to modTools.php to delete an account.
      // I dont like it being accessible at an editProfile menu * for mods *. 
      // Important stuff like this should be more tedious to do, to prevent accidents IMO.
      // PLease note: modTools.php was not a core design/agreement to the project. I added it in the last week!
   }
   if (isset($_POST['updatePwBtn'])) {
      $userID = filter_input(INPUT_POST, 'userID');
      $userPW = filter_input(INPUT_POST, 'userPW');
      echo $userPW;
      echo $userID;

      if ($userDatabase->updatePW($userPW, $userID)) {
         header('Location: viewUsers.php?userID='. $userID);
      } else {
         $message = "Error in updating profile, please try again.";
      }
   }

}

?>