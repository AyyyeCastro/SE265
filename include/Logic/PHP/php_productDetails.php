<?php
/* get the list ID from the URL, send it to the method */
if (isset($_SESSION['userID'])) {
   $loginID = $_SESSION['userID'];
}
else{
   $loginID ="";
}



$listID = $_GET['listID'];
$listDetails = $userDatabase->getListForm($listID);
/* get the $userID then send it to the method */
$userID = $listDetails['userID'];
$sellerInfo = $userDatabase->getUserDetails($userID);

if (isset($_GET['orderID'])) {
   $orderID = $_GET['orderID'];
   $isAlreadyRated = $userDatabase->isAlreadyRated($orderID);
}

if (isPostRequest()) {
   if (isset($_POST['btnRate'])) {
      $userID = filter_input(INPUT_POST, 'userID');
      $userRating = filter_input(INPUT_POST, 'userRating');
      $orderID = filter_input(INPUT_POST, 'orderID');

      if ($userDatabase->giveUserRating($userID, $userRating, $orderID) ) {
         header('Location: viewPurchaseHistory.php');
      }
   }
}
?>