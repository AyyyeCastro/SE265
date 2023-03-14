<?php
$message = "";

$userID = filter_input(INPUT_GET, 'userID');
if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   $_SESSION['visitCrumb'] = 'backend/viewUsers.php?userID=' . $userID;
   header("location: ../login.php");
   exit;
}

$userInfo = $userDatabase->getUserDetails($userID);
$userListLog = $userDatabase->getUserListing($userID);
$userRating = $userDatabase->getAvgRating($userID);
$userRatingCount = $userDatabase->getRatingCount($userID);

$sessionID = $_SESSION['userID'];
$modCheck = $userDatabase->isUserMod($sessionID);

# ----------------#
?>