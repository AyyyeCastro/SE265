<?php








// NOTE. modTools was not a core design/agreement to the project. This was done at the last minute for extra work! 
// There may be some unknown (to me) bugs.







if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}
$message = "";
$catList = $userDatabase->getAllCategories();
$userList = $userDatabase->getAllUsers();
$condList = $userDatabase->getAllConditions();

if (isPostRequest()) {

   if (isset($_POST['updateCatBtn'])) {
      $oldCat = filter_input(INPUT_POST, 'oldCat');
      $newCat = filter_input(INPUT_POST, 'inputCat');

      if ($userDatabase->modUpdateCat($newCat, $oldCat)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
   }

   if (isset($_POST['deleteCatBtn'])) {
      $inputCat = filter_input(INPUT_POST, 'inputCat');

      if ($userDatabase->modDeleteCat($inputCat)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
   }
   if (isset($_POST['insertCatBtn'])) {
      $inputCat = filter_input(INPUT_POST, 'inputCat');

      if ($userDatabase->modNewCat($inputCat)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
   }

   if (isset($_POST['updateUserBtn'])) {
      $oldInnie = filter_input(INPUT_POST, 'userInnie');
      $newInnie = filter_input(INPUT_POST, 'inputInnie');

      if ($userDatabase->modUpdateUser($newInnie, $oldInnie)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
      else{
         echo '<div class="container" id="warnMod" style="color: red;font-size: 52px;><div class="row"><div class="col-md-12">User Innie doesnt match or was an admin.</div></div></div>';
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 3500);</script>';
      }
   }
   if (isset($_POST['deleteUserBtn'])) {
      $inputInnie = filter_input(INPUT_POST, 'inputInnie');
      echo $inputInnie;

      if ($userDatabase->modDeleteUser($inputInnie)){
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
      else{
         echo '<div class="container" id="warnMod" style="color: red;font-size: 52px;><div class="row"><div class="col-md-12">User Innie doesnt match or was an admin.</div></div></div>';
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 3500);</script>';
      }
   }
   if (isset($_POST['updateCondBtn'])) {
      $oldCond = filter_input(INPUT_POST, 'oldCond');
      $newCond = filter_input(INPUT_POST, 'inputCond');

      if ($userDatabase->modUpdateCond($newCond, $oldCond)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
      else{
         echo 'error updating cond';
      }
   }
   if (isset($_POST['deleteCondBtn'])) {
      $inputCond = filter_input(INPUT_POST, 'inputCond');

      if ($userDatabase-> modDeleteCond($inputCond)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
      else{
         echo 'error deleting cond';
      }
   }
   if (isset($_POST['insertCondBtn'])) {
      $inputCond = filter_input(INPUT_POST, 'inputCond');

      if ($userDatabase->modNewCond($inputCond)) {
         echo '<script>setTimeout(function() { window.location.href = "modTools.php"; }, 2);</script>';
      }
      else{
         echo 'error deleting cond';
      }
   }


   
}
?>