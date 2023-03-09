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
$userListLog = $userDatabase->getUserListing($userID);
$messageLog = $userDatabase->getAllMessages($userID);
$deleteMessage = [];

if (isPostRequest()) {

   if (isset($_POST['btnHideMsg'])) {

      $parentID = filter_input(INPUT_POST, 'parentID');

      if($userDatabase->inboxHideConvo($parentID)){
         echo '<script>setTimeout(function() { window.location.href = "viewInbox.php"; }, 2);</script>';
      }

   }
}
?>