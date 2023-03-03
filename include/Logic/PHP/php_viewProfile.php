<?php
if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}


# -- Important -- #
# Set the session outside of the post request, so that the forms can get pre-filled. 
$userID = $_SESSION['userID'];
$userInfo = $userDatabase->getUserDetails($userID);
$userListLog = $userDatabase->getUserListing($userID);
$deleteList = [];
$userRating = $userDatabase->getAvgRating($userID);
$userRatingCount = $userDatabase->getRatingCount($userID);

#----------------#
if (isPostRequest()) {

   if (isset($_POST['btnDelete'])) {
      header('Location: viewProfile.php');
      $listID = filter_input(INPUT_POST, 'listID');
      $deleteList = $userDatabase->deleteUserLising($listID);
   }

   if (isset($_POST['btnUpdatePP'])) {
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
   }
}
?>