<!DOCTYPE html>
<?php
ob_start();
include_once '../include/functions.php';
include_once '../include/header.php';
include_once '../model/userController.php';

if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   header("location: ../login.php");
   exit;
}


$message = "";
$configFile = '../model/dbconfig.ini';
try {
   $userDatabase = new Users($configFile);
} catch (Exception $error) {
   echo "<h2>" . $error->getMessage() . "</h2>";
}

# -- Important -- #
# Set the session outside of the post request, so that the forms can get pre-filled. 
$userID = $_SESSION['userID'];
$userInfo = $userDatabase->getUserDetails($userID);
$userListLog = $userDatabase->getUserListing($userID);
$deleteList = [];
$userRating = $userDatabase->getAvgRating($userID);
$userRatingCount = $userDatabase->getRatingCount($userID);

#----------------#
if (isPostRequest()) {

   if (isset($_POST['btnDelete'])) {
      header('Location: viewProfile.php');
      $listID = filter_input(INPUT_POST, 'listID');
      $deleteList = $userDatabase->deleteUserLising($listID);
   }

   if (isset($_POST['btnUpdatePP'])) {
      $userID = filter_input(INPUT_POST, 'userID');

      #--- Profile pictures -- #
      $file = $_FILES['userProfilePicture'];
      $fileDestination = '../uploaded/' . $file['name'];
      move_uploaded_file($file['tmp_name'], $fileDestination);
      # ---------------------- #

      if ($userDatabase->updatePP($fileDestination, $userID)) {
         header("location: ../backend/viewProfile.php");
      } else {
         $message = "Error in updating profile, please try again.";
      }
   }
}
?>
<style>
   .container {
      padding: 15px;
      min-width: 75%;
      height: 100%;
   }

   .profileContainer {
      padding: 15px;
      background-color: #F8F8F8;
      border-bottom: 1px solid rgba(186, 186, 186, 0.4);
      /* first 3 are the color, last is the opacity */
      background-clip: padding-box;
      -webkit-background-clip: padding-box;
      border-radius: 15px;
      border: 1px solid #E5E5E5;
      box-shadow: 5px 10px 10px #E5E5E5;
   }

   .productContainer {
      margin-top: 15px;
      border-radius: 15px;
      border: 1px solid #E5E5E5;
      box-shadow: 5px 10px 10px #E5E5E5;
      padding: 15px;
   }

   /* Important, sets it so that was "edit" listing buttons only show on a table hover */

   .ProfilePics {
      object-fit: cover;
      /* Do not scale the image */
      object-position: center;
      /* Center the image within the element */
      width: 200px;
      height: 200px;
      border: solid 2px blue;
   }

   .newUserPP {
      object-fit: cover;
      /* Do not scale the image */
      object-position: center;
      margin-top: 1px;
      border: solid 2px blue;
      /* Center the image within the element */
      width: 97%;
      height: 97%;
   }


   .img-overlay {
      position: absolute;
      margin-left: 15px;
      top: 0;
      left: 0;
      width: 200px;
      height: 200px;
      pointer-events: all;
   }

   .img-overlay:hover {
      opacity: 20%;
      background-color: #F8F8F8;
   }


   .btnUpdatePP {
      Display: inline-block;
      position: absolute;
      top: 140px;
      left: 170px;
      pointer-events: all;
      background-color: purple;
   }

   input[type="file"] {
      display: none;
   }


   .custom-file-upload {
      height: 100%;
      width: 100%;
      display: inline-block;
      cursor: pointer;
   }

   .profDetails {
      word-spacing: 7px;
   }

   .listProdTitle {
      font-size: 18px;
      max-width: 250px;
      /* limit title width to the same width of the of the image */
   }

   .listProdCat {
      max-width: 250px;
   }

   .listProdPrice {
      padding-top: 3px;
      font-weight: bold;
      font-size: 18px;
      max-width: 250px;
   }

   .listCond {
      color: #506d90;
      font-size: 13px;
      max-width: 250px;
   }

   .listID {
      color: #506d90;
      font-size: 13px;
      max-width: 250px;
   }

   .listState {
      font-size: 13px;
      max-width: 250px;
   }

   .showEdit {
      display: none;
   }

   .content {
      max-width: 250px;
      min-height: 400px;
      border: 1px #F5F5F5 solid;
      margin: 5px;
   }

   .content:hover .showEdit {
      display: inline-block;
   }

   .userRating {
      margin-top: 5px;
      color: gold;
   }

   .userRatingCount{
      display: none;
      color: orange;
      font-size: 13px;
   }
   .userRating:hover .hideCount{
      display: inline-block;
   }

   .userBio {
      margin-top: 15px;
   }
</style>
<div class="container viewProfileContainer">
   <div class="profileContainer">
      <div class="row">
         <div class="col-md-4">
            <img id="newUserPP" class="newUserPP rounded-circle img-overlay" />
            <div class="img-container">
               <?php
               $defaultAvie = "../include/default-avie/default-avie.jpg";
               if (is_null($userInfo['userPic']) || empty($userInfo['userPic'])) {
                  echo "<img src= '$defaultAvie' class='ProfilePics rounded-circle' alt='profile picture'>";
               } else {
                  echo "<img src='" . $userInfo['userPic'] . "' class='ProfilePics rounded-circle' alt='profile picture'>";
               }
               ?>

               <div class="changePPBox">
                  <form action="editUserPic.php" method="POST" enctype="multipart/form-data">
                     <div>
                        <input type="hidden" id="userID" name="userID" class="form-control"
                           value="<?php echo $userID ?>" required>
                     </div>
                     <div class="img-overlay">
                        <label class="custom-file-upload">
                           <input type="file" id="userProfilePicture" name="userProfilePicture" class="form-control"
                              accept="image/*" required>
                        </label>
                     </div>
                     <br>
                     <div id="btnUpdatePPBox">
                     </div>
                     <p id="photoIndicator"></p>
                  </form>
               </div>
            </div>
         </div>

         <div class="col-md-7">
            <h1>
               <?php echo $userInfo['userInnie']; ?>
            </h1>
            <small id="joinDate" class="form-text text-muted profDetails">
               Joined: <b>
                  <?php echo date("Y-m-d", strtotime($userInfo['userJoined'])); ?>
               </b>
               State: <b>
                  <?php echo $userInfo['userState']; ?>
               </b>
            </small>
            <div class="row userRating showCount">
               <div class="col-lg-3">
               <!-- 0 star -->
               <?php if ($userRating == 0): ?>
                  <?php for ($i = 0; $i < 5; $i++): ?>
                     <i class="fa-regular fa-star fa-lg"></i>
                  <?php endfor; ?>
               <?php endif ?>

               <!-- 1 stars -->
               <?php if ($userRating == 1): ?>
                  <!-- solid -->
                  <i class="fa-solid fa-star fa-lg"></i>
                  <!-- outline -->
                  <?php for ($i = 0; $i < 4; $i++): ?>
                     <i class="fa-regular fa-star fa-lg"></i>
                  <?php endfor; ?>
               <?php endif ?>

               <!-- 1.5 stars -->
               <?php if ($userRating == 1.5): ?>
                  <!-- solid -->
                     <i class="fa-solid fa-star fa-lg"></i>
                     <i class="fa-solid fa-star-half-stroke fa-lg"></i>
                  <!-- outline -->
                  <?php for ($i = 0; $i < 3; $i++): ?>
                     <i class="fa-regular fa-star fa-lg"></i>
                  <?php endfor; ?>
               <?php endif ?>

               <!-- 2 stars -->
               <?php if ($userRating == 2): ?>
                  <!-- solid -->
                  <?php for ($i = 0; $i < 2; $i++): ?>
                     <i class="fa-solid fa-star fa-lg"></i>
                  <?php endfor; ?>
                  <!-- outline -->
                  <?php for ($i = 0; $i < 3; $i++): ?>
                     <i class="fa-regular fa-star fa-lg"></i>
                  <?php endfor; ?>
               <?php endif ?>

               <!-- 2.5 stars -->
               <?php if ($userRating == 2.5): ?>
                  <!-- solid -->
                  <i class="fa-solid fa-star fa-lg"></i>
                  <i class="fa-solid fa-star fa-lg"></i>
                  <i class="fa-solid fa-star-half-stroke fa-lg"></i>
                  <!-- outline -->
                  <i class="fa-regular fa-star fa-lg"></i>
                  <i class="fa-regular fa-star fa-lg"></i>
               <?php endif ?>

               <!-- 3 stars -->
               <?php if ($userRating == 3): ?>
                  <!-- solid -->
                  <?php for ($i = 0; $i < 3; $i++): ?>
                     <i class="fa-solid fa-star fa-lg"></i>
                  <?php endfor; ?>
                  <!-- outline -->
                  <?php for ($i = 0; $i < 2; $i++): ?>
                     <i class="fa-regular fa-star fa-lg"></i>
                  <?php endfor; ?>
               <?php endif ?>

               <!-- 3.5 stars -->
               <?php if ($userRating == 3.5): ?>
                  <!-- solid -->
                  <i class="fa-solid fa-star fa-lg"></i>
                  <i class="fa-solid fa-star fa-lg"></i>
                  <i class="fa-solid fa-star fa-lg"></i>
                  <i class="fa-solid fa-star-half-stroke fa-lg"></i>
                  <!-- outline -->
                  <i class="fa-regular fa-star fa-lg"></i>
               <?php endif ?>

               <!-- 4 stars -->
               <?php if ($userRating == 4): ?>
                  <!-- solid -->
                  <?php for ($i = 0; $i < 4; $i++): ?>
                     <i class="fa-solid fa-star fa-lg"></i>
                  <?php endfor; ?>
                  <!-- outline -->
                  <?php for ($i = 0; $i < 1; $i++): ?>
                     <i class="fa-regular fa-star fa-lg"></i>
                  <?php endfor; ?>
               <?php endif ?>

               <!-- 4.5 stars -->
               <?php if ($userRating == 4.5): ?>
                  <!-- solid -->
                  <i class="fa-solid fa-star fa-lg"></i>
                  <i class="fa-solid fa-star fa-lg"></i>
                  <i class="fa-solid fa-star fa-lg"></i>
                  <i class="fa-solid fa-star fa-lg"></i>
                  <!-- outline -->
                  <i class="fa-solid fa-star-half-stroke fa-lg"></i>
               <?php endif ?>

               <!-- 5 stars -->
               <?php if ($userRating == 5): ?>
                  <!-- solid -->
                  <?php for ($i = 0; $i < 5; $i++): ?>
                     <i class="fa-solid fa-star fa-lg"></i>>
                  <?php endfor; ?>
               <?php endif ?>
            </div>
               <div class="col-lg userRatingCount hideCount">
                  <?php echo $userRatingCount ?> Product Reviewers
               </div>

            </div>
            <small class="form-text text-muted userBio">Biography</small>
            <p>
               <?php echo $userInfo['userBio']; ?>
            </p>
         </div>
         <div class="col-md-1">
            <!-- Check if the currently logged in user's ID matches the ID of the profile being viewed -->
            <?php if ($_SESSION['userID'] === $userInfo['userID']) { ?>
               <p style="text-align: right;"><a href="editProfile.php"><button class="btn btn-secondary"><i
                           class="fa-solid fa-pen-to-square"></i></button></a>
               <p>
               <?php } ?>
         </div>
      </div> <!-- Row -->
   </div>

   <div class="productContainer">
      <div class="active">
         <a href="viewPurchaseHistory.php"><button class="btn"><i
                  class="fa-sharp fa-solid fa-file-invoice-dollar fa-xl"></i></button>Purchases</a>
         <a href="viewSaleHistory.php"><button class="btn"><i
                  class="fa-solid fa-clock-rotate-left fa-lg"></i></button>Sales</a>
      </div>
      <div class="row">
         <?php foreach ($userListLog as $row): ?>
            <?php if ($row['isListSold'] != 'YES'): ?>
               <div class="col-sm-3 content">
                  <div class="row">
                     <!-- edit button -->
                     <a href="editListing.php?listID=<?= $row['listID']; ?>"><button class="btn btn-primary showEdit"
                           name="cancelbtn"><i class="fa-solid fa-pen-to-square"></i></button></a>
                     <form action="viewProfile.php" method="post">
                        <!-- delete button -->
                        <button type="submit" class="btn btn-warning showEdit" name="btnDelete"
                           onclick="return confirm('Are you sure you want to delete this listing? It is a permenant decision.')"><i
                              class="fa-solid fa-trash"></i></button>

                        <input type="hidden" id="listID" name="listID" value="<?= $row['listID']; ?>" />
                     </form>
                  </div>
                  <a href="productDetails.php?listID=<?= $row['listID']; ?>">
                     <div class="listProdPic"><img src="<?= $row['listProdPic']; ?>"
                           style="object-fit: contain; object-position: center; width: 230px; height: 230px; background-color: #F6F6F6;">
                     </div>
                     <div class="listProdTitle">
                        <?= $row['listProdTitle']; ?>
                     </div>
                  </a>
                  <div class="listProdCat">
                     <?= $row['listProdCat']; ?>
                  </div>
                  <div class="listProdPrice">$
                     <?= $row['listProdPrice']; ?>
                  </div>
                  <div class="listCond">
                     <?= $row['listCond']; ?>
                  </div>
                  <div class="listID">
                     Product:
                     <?= $row['listID']; ?>
                  </div>
               </div>
            <?php endif; ?>
         <?php endforeach; ?>
      </div>
   </div>
</div>
</body>

</html>
<?php include_once '../include/footer.php'; ?>


<script>
   document.getElementById('userProfilePicture').onchange = function () {
      var src = URL.createObjectURL(this.files[0])
      document.getElementById('newUserPP').src = src

      // Add an indicator to let the user know that the photo is ready to be submitted
      document.getElementById("photoIndicator").innerHTML = "Check to apply updated picture.";
      document.getElementById("btnUpdatePPBox").innerHTML = "<button type='submit' class='btn btn-primary btnUpdatePP'><i class='fa-solid fa-square-check fa-xl'></i></button>";

   }

</script>