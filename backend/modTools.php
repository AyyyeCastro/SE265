<?php
ob_start();
require '../include/header.php';
require '../include/logic/php/php_modTools.php';

$userID = $_SESSION['userID'];
$modCheck = $userDatabase->getUserDetails($userID);

if ($modCheck['isModerator']== 'YES'):
?>


<!-- PLEASE NOTE:
THIS WAS EXTRA WORK I DID IN WEEK 8/9. It was not originally a core design -->


<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/modTools.css">
<div class="container-fluid">
   <div class="container">
      <div class="row">
         <div class="col-md-6">
            <form method="POST" action="modTools.php" class="formContainer">
            <div class="form-group">
                  <h2>CATEGORY MANAGEMENT<h2>
               </div>
               <div class="form-group">
                  <label for="oldCat">Category to Update/Delete</label>
                  <select class="form-control" name="oldCat">
                     <option value="" disabled selected>Choose category</option>
                     <?php
                     foreach ($catList as $category) {
                        echo '<option value="' . $category['catGenre'] . '">' . $category['catGenre'] . '</option>';
                     }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label for="inputCat">Category Name:</label>
                  <input type="text" class="form-control" name="inputCat" required>
                  <small class="form-text text-muted">
                     Select a category and type it's updated name. Type a category and click 'new', for a new category. Select a category and re-type it's name to delete.
                  </small>
               </div>
               <div class="form-group">
                  <button type="submit" class="customBtn" name="updateCatBtn"
                     onclick="return confirm('Do you want to update the category?')">
                     <i class="fa-solid fa-square-pen fa-xl"></i> Update
                  </button>
                  <button type="submit" class="warningBtn" name="deleteCatBtn"
                     onclick="return confirm('Are you sure you want to delete this category? It is a permenant decision.')">
                     <i class="fa-solid fa-trash fa-xl"></i> Delete
                  </button>
                  <button type="submit" class="customerOtherBtn" name="insertCatBtn"
                     onclick="return confirm('Insert this new category?')">
                     <i class="fa-solid fa-circle-plus"></i> New
                  </button>
               </div>
            </form>
         </div>

         <div class="col-md-6">
            <form method="POST" action="modTools.php" class="formContainer" id='userForm'>
            <div class="form-group">
                  <h2>CONDITION MANAGEMENT<h2>
               </div>
               <div class="form-group">
                  <label for="oldCond">Category to Update/Delete</label>
                  <select class="form-control" name="oldCond">
                     <option value="" disabled selected>Choose category</option>
                     <?php
                     foreach ($condList as $condition) {
                        echo '<option value="' . $condition['condType'] . '">' . $condition['condType'] . '</option>';
                     }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label for="inputCond">Product Condition:</label>
                  <input type="text" class="form-control" name="inputCond" required>
                  <small class="form-text text-muted">
                  Select a condition and type the updated name. Select a condition and re-type the name to delete.
                  </small>
               </div>
               <div class="form-group">
                  <button type="submit" class="customBtn" name="updateCondBtn"
                     onclick="return confirm('Do you want to update this condition?')">
                     <i class="fa-solid fa-square-pen fa-xl"></i> Update
                  </button>
                  <button type="submit" class="warningBtn" name="deleteCondBtn"
                     onclick="return confirm('Are you sure you want to delete this condition? It is a permenant decision.')">
                     <i class="fa-solid fa-trash fa-xl"></i> Delete
                  </button>
                  <button type="submit" class="customerOtherBtn" name="insertCondBtn"
                     onclick="return confirm('Insert this new condition?')">
                     <i class="fa-solid fa-circle-plus"></i> New
                  </button>
               </div>
            </form>
         </div>

         <div class="col-md-12">
            <form method="POST" action="modTools.php" class="formContainer" id='userForm'>
            <div class="form-group">
                  <h2>USER MANAGEMENT<h2>
               </div>
               <div class="form-group">
                  <label for="userInnie">Users to Update/Delete</label>
                  <select class="form-control" name="userInnie">
                     <option value="" disabled selected>Choose user</option>
                     <?php
                     foreach ($userList as $users) {
                        echo '<option value="' . $users['userInnie'] . '">' . $users['userInnie'] . '</option>';
                     }
                     ?>
                  </select>
               </div>
               <div class="form-group">
                  <label for="inputInnie">User innie:</label>
                  <input type="text" class="form-control" name="inputInnie" required>
                  <small class="form-text text-muted">
                  Select a user and type their updated Innie. Select a user and re-type their innie to delete.
                  </small>
               </div>
               <div class="form-group">
                  <button type="submit" class="customBtn" name="updateUserBtn"
                     onclick="return confirm('Do you want to update this users Innie?')">
                     <i class="fa-solid fa-square-pen fa-xl"></i> Update
                  </button>
                  <button type="submit" class="warningBtn" name="deleteUserBtn"
                     onclick="return confirm('Are you sure you want to delete this user? It is a permenant decision.')">
                     <i class="fa-solid fa-trash fa-xl"></i> Delete User
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php else: header("location: ../backend/viewProfile.php"); ?>
<?php endif ?>


