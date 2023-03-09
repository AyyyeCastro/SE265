<?php
$message = "";
if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}
## IMPORTANT -- A DELETE BUTTON WILL BE NEEDED. 
## NOT IMPLEMENTED YET.
$deleteList = [];
$userID = $_SESSION['userID'];
$userInfo = $userDatabase->getUserDetails($userID);

if (isGetRequest()) {
   # -- Important -- #
   # Set the session outside of the post request, 
   # so that the forms can get pre-filled. 
   $listID = $_GET['listID'];
   #echo '<br>' . $listID . ' -- this is the list id from the GET<br>';

   # array to store all of the list details.
   $listDetails = $userDatabase->getListForm($listID);
   $catList = $userDatabase->getAllCategories();
   $condList = $userDatabase->getAllConditions();


   # DEBUG - DUMP THE listDetails array.
   #echo '<br><br> this is the listDetails container <br><br>';
   #var_dump($listDetails);
   #echo '<br><br>';

}

if (isPostRequest()) {
   if (isset($_POST['updateBtn'])) {
      $listID = filter_input(INPUT_POST, 'listID');

      $listProdCat = filter_input(INPUT_POST, 'inputProdCat');
      $listProdPrice = filter_input(INPUT_POST, 'inputProdPrice');
      $listProdTitle = filter_input(INPUT_POST, 'inputProdTitle');
      $listDesc = filter_input(INPUT_POST, 'inputProdDesc');
      $listCond = filter_input(INPUT_POST, 'inputProdCond');
      $listState = filter_input(INPUT_POST, 'inputProdState');


      # -- IMPORTANT!!! -- #
      $listDetails = $userDatabase->getListForm($listID);
      $catList = $userDatabase->getAllCategories();
      $condList = $userDatabase->getAllConditions();

      #--- Profile Picture Traveling -- #

      if (
         $userDatabase->updateUserListing(
            $listID,
            $listProdCat,
            $listProdPrice,
            $listProdTitle,
            $listDesc,
            $listCond,
            $listState
        )
      ) {
         echo '<script>setTimeout(function() { window.location.href = "viewProfile.php"; }, 2);</script>';
      } else {
         $message = "Error posting new listing, please try again.";
      }
   }
   if (isset($_POST['cancelBtn'])) {
      echo '<script>setTimeout(function() { window.location.href = "viewProfile.php"; }, 2);</script>';
   }
}
?>