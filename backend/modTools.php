<?php
require '../include/header.php';
require '../include/logic/php/php_modTools.php';
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/modTools.css">
<div class="container-fluid">
   <div class="container">
      <div class="row">
         <div class="col-md-6">
            <form method="POST" action="modTools.php" class="formContainer">
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
                  <small class="form-text text-muted">Type a new name to update, or re-type the chosen category to
                     delete.</small>
               </div>
               <div class="form-group">
                  <button type="submit" class="customBtn" name="updateCatBtn"
                     onclick="return confirm('Do you want to update the category?')">
                     <i class="fa-solid fa-square-pen fa-xl"></i> Update
                  </button>
                  <button type="submit" class="customerOtherBtn" name="deleteCatBtn"
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
                  <small class="form-text text-muted">Type a new user Innie to update, or re-type the chosen user to
                     delete.</small>
               </div>
               <div class="form-group">
                  <button type="submit" class="customBtn" name="updateUserBtn"
                     onclick="return confirm('Do you want to update the category?')">
                     <i class="fa-solid fa-square-pen fa-xl"></i> Update Innie
                  </button>
                  <button type="submit" class="customerOtherBtn" name="deleteUserBtn"
                     onclick="return confirm('Are you sure you want to delete this user? It is a permenant decision.')">
                     <i class="fa-solid fa-trash fa-xl"></i> Delete User
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>