<?php
include_once '../include/functions.php';
include_once '../include/header.php';
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
$userID = $_SESSION['userID'];
$userInfo = $userDatabase->getUserDetails($userID);
$userListLog = $userDatabase->getUserListing($userID);
$deleteList = [];

#----------------#
if (isPostRequest()) {
   # If the delete button is clicked, call for deleteUserListing method.
   # User is prompted for confirmation before function is called.
   if (isset($_POST["deleteBtn"])) {
      $listID = filter_input(INPUT_POST, 'listID');
      $deleteList = $userDatabase->deleteUserLising($listID);
      header('Location: viewProfile.php');
   }
} else {
}
?>