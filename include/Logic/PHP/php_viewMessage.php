<?php
if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}

# -- Important -- #
# Set the session outside of the post request, so that the forms can get pre-filled. 

/* sender's info */
$userID = $_SESSION['userID'];
$senderInfo = $userDatabase->getUserDetails($userID);

/* receiver's info */
$sellerID = $userID;
$sellerInnie = $_GET['receiverInnie'];

$receiverID = $_GET['receiverID'];

/* message info */
$parentID = $_GET['parentID'];
$messageID = $_GET['messageID'];
$messageDetails = $userDatabase->getMessageDetails($messageID);
$messageSentOn = $messageDetails['messageSentOn'];

/* Get receiver's mini-profile  */
$profileName = $messageDetails['customerInnie'];
$profileInfo = $userDatabase->getProfileByName($profileName);

/* Get requested product info */
$listID = $messageDetails['listID'];
$listDetails = $userDatabase->getListForm($listID);

/* bread crumbs */
$convoDetails = $userDatabase->getMessageCrumbs($listID, $parentID, $messageSentOn);

$deleteMessage = [];
/* Get seller's info (logged in user)
Redeclare $userID as the logged in user's ID -> $sellerID
*/
#----------------#
if (isPostRequest()) {

   if (isset($_POST['btnSend'])) {
      $listID = filter_input(INPUT_POST, 'listID');
      $parentID = $_POST['parentID'];
      /* get the $userID thensent it to the method */
      $sellerID = filter_input(INPUT_POST, 'sellerID');
      $sellerInnie = filter_input(INPUT_POST, 'sellerInnie');
      $customerID = filter_input(INPUT_POST, 'customerID');
      $customerInnie = filter_input(INPUT_POST, 'customerInnie');
      $messageTitle = filter_input(INPUT_POST, 'messageTitle');
      $messageDesc = filter_input(INPUT_POST, 'messageDesc');
      $fileDestination = filter_input(INPUT_POST, 'fileDestination');
      $fileDestination2 = filter_input(INPUT_POST, 'fileDestination2');
      $fileDestination3 = filter_input(INPUT_POST, 'fileDestination3');
      $fileDestination4 = filter_input(INPUT_POST, 'fileDestination4');
      $isMessageReplied = filter_input(INPUT_POST, 'isMessageReplied');

      /* for updateIsRepliedMessage function */
      $priorMessageID = filter_input(INPUT_POST, 'priorMessageID');
      $updateStatus = filter_input(INPUT_POST, 'updateStatus');

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
         && $userDatabase->updateIsMessageReplied($priorMessageID, $updateStatus)
      ) {
         header('Location: viewInbox.php');
         $message = "Your message Was Sent!";

      } else {
         $message = "Error sending message, please try again.";
      }
   }
   if (isset($_POST['btnConfirmSale'])) {
      $listID = filter_input(INPUT_POST, 'listID');
      $listProdCat = filter_input(INPUT_POST, 'listProdCat');
      $listProdPrice = filter_input(INPUT_POST, 'listProdPrice');
      $listProdTitle = filter_input(INPUT_POST, 'listProdTitle');
      $listCond = filter_input(INPUT_POST, 'listCond');
      $orderID = uniqid();
      $isListSold = filter_input(INPUT_POST, 'isListSold');

      /* defaul sale msg */
      $parentID = $_POST['parentID'];
      /* get the $userID thensent it to the method */
      $sellerID = filter_input(INPUT_POST, 'sellerID');
      $sellerInnie = filter_input(INPUT_POST, 'sellerInnie');
      $customerID = filter_input(INPUT_POST, 'customerID');
      $customerInnie = filter_input(INPUT_POST, 'customerInnie');
      $messageTitle = filter_input(INPUT_POST, 'messageTitle');
      $messageDesc = filter_input(INPUT_POST, 'messageDesc');
      $isMessageReplied = filter_input(INPUT_POST, 'isMessageReplied');


      /* for updateIsRepliedMessage function */
      $priorMessageID = filter_input(INPUT_POST, 'priorMessageID');
      $updateStatus = filter_input(INPUT_POST, 'updateStatus');

      if (
         $userDatabase->defaultSaleMsg(
            $parentID,
            $customerID,
            $sellerID,
            $listID,
            $messageTitle,
            $messageDesc,
            $customerInnie,
            $sellerInnie
         )
         && $userDatabase->confirmSale(
            $listID,
            $customerID,
            $sellerID,
            $orderID,
            $customerInnie,
            $sellerInnie
         )
         && $userDatabase->updateIsMessageReplied($priorMessageID, $updateStatus)
      ) {
         header('Location: viewSaleHistory.php');
      } else {
         header('Location: viewSaleHistory.php');
      }
   }

}
?>