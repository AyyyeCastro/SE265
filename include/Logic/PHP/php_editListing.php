<?php
$message = "";
if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}

// set array
$deleteList = [];
// get logged in user's ID
$userID = $_SESSION['userID'];
// call the function, and set it to $userInfo to gather database details.
$userInfo = $userDatabase->getUserDetails($userID);

if (isGetRequest()) {
   # -- Important -- #
   # Set the session outside of the post request, 
   # so that the forms can get pre-filled. 
   $listID = $_GET['listID'];

   # array to store all of the list details.
   $listDetails = $userDatabase->getListForm($listID);
   $catList = $userDatabase->getAllCategories();
   $condList = $userDatabase->getAllConditions();
}

// visitID = the userID of the user whose list is being edited by a mod/owner. (1)
$visitID = filter_input(INPUT_POST, 'visitID');
// visitCrumb = the base URL of a user's profile. 
// visitCrumb + visitID = the profile url of the user whose list is being edited. 
// This will be used to redirect back to a user's profile after updating their listing. ** IMPORTANT for when mods are editing.
$visitCrumb = 'viewUsers.php?userID=' . $visitID;


if (isPostRequest()) {
   if (isset($_POST['updateBtn'])) { // if updateBtn is clicked ->

      // variables from the updateUserListing() function is declared, as values sent from the HTML form.
      $listID = filter_input(INPUT_POST, 'listID');
      $listProdCat = filter_input(INPUT_POST, 'inputProdCat');
      $listProdPrice = filter_input(INPUT_POST, 'inputProdPrice');
      $listProdTitle = filter_input(INPUT_POST, 'inputProdTitle');
      $listDesc = filter_input(INPUT_POST, 'inputProdDesc');
      $listCond = filter_input(INPUT_POST, 'inputProdCond');
      $listState = filter_input(INPUT_POST, 'inputProdState');


      # -- IMPORTANT!!! -- #
      # Information gathered from the db.
      $listDetails = $userDatabase->getListForm($listID);
      $catList = $userDatabase->getAllCategories();
      $condList = $userDatabase->getAllConditions();


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
         // if updateUserListing() works, then redirect back to the user's profile. 
         header("location: $visitCrumb");
      } else {
         $message = "Error posting new listing, please try again.";
      }
   }
   if (isset($_POST['cancelBtn'])) {
      echo '<script>setTimeout(function() { window.location.href = "viewProfile.php"; }, 2);</script>';
   }
}
?>