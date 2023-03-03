<?php
$message = "";

$catList = $userDatabase->getAllCategories();
$userList = $userDatabase->getAllUsers();

if (isPostRequest()) {

   if (isset($_POST['updateCatBtn'])) {
      $oldCat = filter_input(INPUT_POST, 'oldCat');
      $newCat = filter_input(INPUT_POST, 'inputCat');

      if ($userDatabase->updateListCat($newCat, $oldCat)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
   }

   if (isset($_POST['deleteCatBtn'])) {
      $inputCat = filter_input(INPUT_POST, 'inputCat');

      if ($userDatabase->deleteListCat($inputCat)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
   }
   if (isset($_POST['insertCatBtn'])) {
      $inputCat = filter_input(INPUT_POST, 'inputCat');

      if ($userDatabase->insertNewCat($inputCat)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
   }

   if (isset($_POST['updateUserBtn'])) {
      $oldInnie = filter_input(INPUT_POST, 'oldInnie');
      $newInnie = filter_input(INPUT_POST, 'inputInnie');

      if ($userDatabase->modUpdateUser($newInnie, $oldInnie) && $oldInnie !== 'Plugin.com') {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
      else{
         echo '<div class="container" id="warnMod" style="color: red;font-size: 52px;><div class="row"><div class="col-md-12"> You can not edit the admin. </div></div></div>';
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 3500);</script>';
      }
   }
   if (isset($_POST['deleteUserBtn'])) {
      $inputInnie = filter_input(INPUT_POST, 'inputInnie');

      if ($userDatabase->modDeleteUser($inputInnie) && $inputInnie !== 'Plugin.com') {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
      else{
         echo '<div class="container" id="warnMod" style="color: red;font-size: 52px;><div class="row"><div class="col-md-12"> You can not edit the admin. </div></div></div>';
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 3500);</script>';
      }
   }
}
?>