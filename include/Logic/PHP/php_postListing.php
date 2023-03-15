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
$catList = $userDatabase->getAllCategories();
$condList = $userDatabase->getAllConditions();

# ----------------#

if (isPostRequest()) {
   $listProdCat = filter_input(INPUT_POST, 'inputProdCat');
   $catList = $userDatabase->getAllCategories();
   $listProdPrice = filter_input(INPUT_POST, 'inputProdPrice');
   $listProdTitle = filter_input(INPUT_POST, 'inputProdTitle');
   $listDesc = filter_input(INPUT_POST, 'inputProdDesc');
   $listCond = filter_input(INPUT_POST, 'inputProdCond');
   $listState = filter_input(INPUT_POST, 'inputProdState');
   $condList = $userDatabase->getAllConditions();
   $userInfo = $userDatabase->getUserDetails($userID);

   #--- Profile Picture Traveling -- #
   $file = $_FILES['sendPic'];
   if ($file['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination = '../backend/listingUpload/' . $file['name'];
      move_uploaded_file($file['tmp_name'], $fileDestination);
   }
   $file2 = $_FILES['sendPic2'];
   if ($file2['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination2 = '../backend/listingUpload/' . $file2['name'];
      move_uploaded_file($file2['tmp_name'], $fileDestination2);
   }
   $file3 = $_FILES['sendPic3'];
   if ($file3['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination3 = '../backend/listingUpload/' . $file3['name'];
      move_uploaded_file($file3['tmp_name'], $fileDestination3);
   }
   $file4 = $_FILES['sendPic4'];
   if ($file4['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination4 = '../backend/listingUpload/' . $file4['name'];
      move_uploaded_file($file4['tmp_name'], $fileDestination4);
   }
   # ---------------------------------#

   if (
      $userDatabase->postUserListing(
         $userID,
         $listProdCat,
         $listProdPrice,
         $listProdTitle,
         $listDesc,
         $listCond,
         $fileDestination,
         $listState,
         $listPostedOn,
         $fileDestination2,
         $fileDestination3,
         $fileDestination4
      )
   ) {
      header("location: ../backend/viewProfile.php");
   } else {
      $message = "Error posting new listing, please try again.";
   }
}
?>