<!DOCTYPE html>
<?php
ob_start();
require '../include/header.php';
require '../include/logic/php/php_editProfile.php';
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/editProfiles.css">
<div class="container-fluid">
   <div class="container editProfContainer">
      <h1>Account Information</h1>
      <!-- SUPER important. enctype="multipart/form-data" in order to allow inserting profile pics -->
      <form action="editProfile.php" method="POST" enctype="multipart/form-data">

         <div class="row displayContent">
            <div class="col-md-12">
               <label for="username">Username</label>
               <input type="text" id="userName" name="userName" class="form-control"
                  value="<?php echo $userInfo['userName']; ?>" required>
               <small id="userHelp" class="form-text text-muted">Remember, this is your login username. Keep this
                  private.</small>
            </div>
         </div>

         <div class="row displayContent">
            <div class="col-md-12">
               <select class="form-control" id="userState" name="userState">
                  <?php
                  $selectedState = (isset($_GET["listState"])) ? $_GET["listState"] : $userInfo['userState'];
                  echo '<option value="" ' . (($selectedState == '') ? 'selected' : '') . '>All States</option>';
                  foreach ($stateList as $states) {
                     $selected = ($states['stateName'] == $selectedState) ? 'selected' : '';
                     echo '<option value="' . $states['stateName'] . '" ' . $selected . '>' . $states['stateName'] . '</option>';
                  }
                  ?>
               </select>
            </div>

         </div>

         <div class="row displayContent">
            <div class="col-md-12">
               <label for="userInnie">Your Innie Handle (@)</label>
               <input type="text" id="userInnie" name="userInnie" class="form-control"
                  value="<?php echo $userInfo['userInnie']; ?>" maxlength="15" required>
               <small id="innieHelp" class="form-text text-muted">Your public handle, and what people will see you
                  as.</small>
            </div>
         </div>

         <div class="row displayContent">
            <div class="col-md-12">
               <label for="userBio">Bio</label>
               <textarea id="userBio" name="userBio" class="form-control"
                  required><?php echo $userInfo['userBio']; ?></textarea>
            </div>
         </div>



         <!--  Ensure this can only be viewed by ADMIN and/or MODS -->
         <?php if ($userInfo['isModerator'] == 'YES' || $userInfo['isOwner'] == 'YES'): ?>
            <div class="row displayContent">
               <div class="col-md-12">
                  <label for="isModerator">Is Moderator:</label>
                  <select name="isModerator" id="isModerator">
                     <option value="YES" <?php if ($userInfo['isModerator'] == 'YES') {
                        echo 'selected';
                     } ?>>YES</option>
                     <option value="NO" <?php if ($userInfo['isModerator'] == 'NO') {
                        echo 'selected';
                     } ?>>NO</option>
                  </select>
               </div>
            </div>
            <?php else: ?>
               <input type="hidden" id="isModerator" name="isModerator" class="form-control"
                  value="NO" required>
         <?php endif ?>
         
         <!------------>


         <div class="row rowBtnPost">
            <div class="col-sm-12">
               <a href="viewProfile.php" class=""
                  onclick="return confirm('This will remove all progress. Leave page?')">Cancel</a>
               <input type="submit" class="customBtn" name="updateBtn" value="update" />
            </div>
         </div>
      </form>

      <form action="editProfile.php" method="POST" enctype="multipart/form-data">
         <br><br><br>
         <div class="row displayContent">
            <div class="col-md-12">
               <label for="userPW">Password</label>
               <input type="text" id="userPW" name="userPW" class="form-control"
                  placeholder="Enter New Password" required>
               <small id="innieHelp" class="form-text text-muted"></small>
               <input type="submit" class="customerOtherBtn" name="updatePwBtn" value="Change Password" onclick="return confirm('Confirm password change?')" />
            </div>
         </div>
      </form>

      
      <form action="editProfile.php" method="POST" enctype="multipart/form-data">
         <div class="row displayContent">
            <div class="col-md-12">
               <label for="inputInnie">Delete account</label>
               <input type="hidden" id="userPW" name="userPW" class="form-control"
                  placeholder="Retype Your Innie Handle to DELETE Your Account" required value="<?php echo $userInfo['userID']?> ">
               <small id="innieHelp" class="form-text text-muted"></small>
               <input type="submit" class="customerOtherBtn" name="deleteAccBtn" value="Delete Account" onclick="return confirm('Are you sure you wish to DELETE your account? This is permenant.')"/>
            </div>
         </div>
      </form>

      <br>
      <?php echo $message ?>
   </div>
</div>
</body>

</html>


<script>
   document.getElementById('userProfilePicture').onchange = function () {
      var src = URL.createObjectURL(this.files[0])
      document.getElementById('newUserPP').src = src

      // Add an indicator to let the user know that the photo is ready to be submitted
      document.getElementById("photoIndicator").innerHTML = "Check to apply updated picture.";
      document.getElementById("btnUpdatePPBox").innerHTML = "<button type='submit' class='btn btn-primary btnUpdatePP'><i class='fa-solid fa-square-check fa-xl'></i></button>";

   }

</script>

<!-- currently listening to: https://youtu.be/IMgkGBKy6r0?t=166 - Andrew @ 8:48 PM 2023.03.01 -->