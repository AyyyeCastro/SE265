<?php
ob_start();
require '../include/header.php';

if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}

$message = "";

# -- Important -- #
# Set the session outside of the post request, so that the forms can get pre-filled. 
$userID = $_GET['userID'];
$userInfo = $userDatabase->getUserDetails($userID);
# ----------------#

if (isPostRequest()) {
   $userID = filter_input(INPUT_POST, 'userID');

   #--- Profile pictures -- #
   $file = $_FILES['userProfilePicture'];
   $fileDestination = '../uploaded/' . $file['name'];
   move_uploaded_file($file['tmp_name'], $fileDestination);
   # ---------------------- #

   if ($userDatabase->updatePP($fileDestination, $userID)) {
      header("location: ../backend/viewProfile.php");
   } else {
      $message = "Error in updating profile, please try again.";
   }
} else {
   $fileDestination = null;
}
$userPic = (!is_null($fileDestination)) ? $fileDestination : $userInfo['userPic'];
?>