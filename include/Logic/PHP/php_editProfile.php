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
      $userState = filter_input(INPUT_POST, 'userState');
      $isModerator = filter_input(INPUT_POST, 'isModerator');

      # -- Profile Pictures -- #
      # -- IMPORTANT!!! -- #
      $userInfo = $userDatabase->getUserDetails($userID);

      if ($userDatabase->updateProfile($userName, $userInnie, $userBio, $userID, $userState, $isModerator)) {
         echo '<script>setTimeout(function() { window.location.href = "editProfile.php"; }, 2);</script>';
      } else {
         $message = "Error in updating profile, please try again.";
      }
   }
   if (isset($_POST['updatePwBtn'])) {
      $userPW = filter_input(INPUT_POST, 'userPW');

      if ($userDatabase->updatePW($userPW, $userID)) {
         echo '<script>setTimeout(function() { window.location.href = "editProfile.php"; }, 2);</script>';
      } else {
         $message = "Error in updating profile, please try again.";
      }
   }
   if (isset($_POST['deleteAccBtn'])) {
      $sessionID = $_SESSION['userID'];
      echo $sessionID;


      if ($userDatabase->deleteAccount($sessionID)) {
         echo '<script>setTimeout(function() { window.location.href = "editProfile.php"; }, 2);</script>';
      } else {
         $message = "Error in deleting profile, please try again.";
      }
   }
}

?>