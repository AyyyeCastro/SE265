<!DOCTYPE html>
<?php
ob_start();
require '../include/header.php';
require '../include/Logic/php/php_viewProfile.php';
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/viewProfiles.css">
<div class="fullVH">
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
                     <form action="editPP.php" method="POST" enctype="multipart/form-data">
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
                  <div class="col-lg-12">
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
                           <i class="fa-solid fa-star fa-lg"></i>
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
                  <p style="text-align: right;"><a href="editProfile.php"><button class="customBtn"><i
                              class="fa-solid fa-pen-to-square"></i></button></a>
                  <p>
                  <?php } ?>
            </div>
         </div> <!-- Row -->
      </div>

      <div class="productContainer">
         <div class="row rowContainer">
            <?php if (empty($userListLog)): ?>
               <div class="col-md-12 col-sm-12">
                  No products listed for sale.
               </div>
            <?php endif; ?>
            <?php foreach ($userListLog as $row): ?>
               <?php if ($row['isListSold'] != 'YES'): ?>
                  <div class="col-md-4 content">
                     <div class="row">
                        <!-- edit button -->
                        <a href="editListing.php?listID=<?= $row['listID']; ?>"><button class="customBtn showEditListing"
                              name="cancelbtn"><i class="fa-solid fa-pen-to-square"></i></button></a>
                        <form action="viewProfile.php" method="post">
                           <!-- delete button -->
                           <button type="submit" class="customerOtherBtn showDeleteListing" name="btnDelete"
                              onclick="return confirm('Are you sure you want to delete this listing? It is a permenant decision.')"><i
                                 class="fa-solid fa-trash"></i></button>

                           <input type="hidden" id="listID" name="listID" value="<?= $row['listID']; ?>" />
                        </form>
                     </div>

                     <a href="productDetails.php?listID=<?= $row['listID']; ?>">
                        <div class="listProdPic"><img src="<?= $row['listProdPic']; ?>"
                              style="object-fit: contain; object-position: center; max-width: 230px; max-height: 230px; background-color: #F6F6F6;">
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
</div>
</body>

</html>
<script src="../include/logic/JS/js_updatePP.js"></script>