<?php
/* get the list ID from the URL, send it to the method */
$parentID = NULL;
$listID = "";
$listID = $_GET['listID'];
$listDetails = $userDatabase->getListForm($listID);
/* get the seller's info */
$userID = $listDetails['userID'];
$sellerInfo = $userDatabase->getUserDetails($userID);
/* get customer's info */
$customerID = $_SESSION['userID'];
$customerInfo = $userDatabase->getCustomerDetails($customerID);
/* Set empty arrays */
$fileDestination = "";

if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   $_SESSION['visitCrumb'] = 'backend/productDetails.php?listID=' . $listID;
   header("location: ../login.php");
   exit;
}

if (isPostRequest()) {
   $parentID = uniqid();
   $listID = filter_input(INPUT_POST, 'listID');
   $customerID = $_SESSION['userID'];
   /* get the $userID thensent it to the method */
   $sellerID = filter_input(INPUT_POST, 'sellerID');
   $sellerInnie = filter_input(INPUT_POST, 'sellerInnie');
   $customerInnie = filter_input(INPUT_POST, 'customerInnie');
   $messageTitle = filter_input(INPUT_POST, 'messageTitle');
   $messageDesc = filter_input(INPUT_POST, 'messageDesc');
   $fileDestination = filter_input(INPUT_POST, 'fileDestination');
   $listDetails = $userDatabase->getListForm($listID);
   $sellerInfo = $userDatabase->getUserDetails($userID);
   $customerInfo = $userDatabase->getCustomerDetails($customerID);
   $fileDestination = filter_input(INPUT_POST, 'fileDestination');
   $fileDestination2 = filter_input(INPUT_POST, 'fileDestination2');
   $fileDestination3 = filter_input(INPUT_POST, 'fileDestination3');
   $fileDestination4 = filter_input(INPUT_POST, 'fileDestination4');
   $isMessageReplied = filter_input(INPUT_POST, 'isMessageReplied');
   echo $isMessageReplied;

   #--- Profile Picture Traveling -- #
   $file = $_FILES['sendPic'];
   if ($file['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination = '../backend/messageUpload/' . $file['name'];
      move_uploaded_file($file['tmp_name'], $fileDestination);
   }
   $file2 = $_FILES['sendPic2'];
   if ($file2['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination2 = '../backend/messageUpload/' . $file2['name'];
      move_uploaded_file($file2['tmp_name'], $fileDestination2);
   }
   $file3 = $_FILES['sendPic3'];
   if ($file3['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination3 = '../backend/messageUpload/' . $file3['name'];
      move_uploaded_file($file3['tmp_name'], $fileDestination3);
   }
   $file4 = $_FILES['sendPic4'];
   if ($file4['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination4 = '../backend/messageUpload/' . $file4['name'];
      move_uploaded_file($file4['tmp_name'], $fileDestination4);
   }

   if (
      $userDatabase->sendMessage(
         $parentID,
         $customerID,
         $sellerID,
         $listID,
         $messageTitle,
         $messageDesc,
         $fileDestination,
         $customerInnie,
         $sellerInnie,
         $fileDestination2,
         $fileDestination3,
         $fileDestination4,
         $isMessageReplied
      )
   ) {
      header("location: displayResults.php");
      $message = "Your Request Was Sent!";

   } else {
      $message = "Error sending message, please try again.";
   }
}
?>