<!DOCTYPE html>
<?php
ob_start();
require "../include/header.php";
require "../include/logic/php/php_requestProduct.php";
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/requestProduct.css">
<div class="container">
   <div class="row requestInfo">
      <div class="col-sm-12 pageTitle">
         About...
      </div>
      <div class="col-sm-5 listImgBox">
         <!-- posted from this user -->
         <input type="hidden" name="sellerID" value="<?= $listDetails['userID']; ?>" />
         <!-- product listID -->
         <input type="hidden" name="p_id" value="<?= $listDetails['listID']; ?>" />
         <div class="listProdPic"><img src="<?= $listDetails['listProdPic']; ?>"
               style="object-fit: contain; object-position: center; width: 250px; height: 250px; background-color: #F6F6F6;">
         </div>
      </div>

      <div class="col-sm-7 listInfoBox">
         <div class="listProdTitle">
            <?= $listDetails['listProdTitle']; ?>
         </div>
         <div class="listProdCat"> Listed in:
            <?= $listDetails['listProdCat']; ?>
         </div>
         <div class="listPostedOn">Posted on:
            <?php echo date("Y-m-d", strtotime($listDetails['listPostedOn'])); ?>
         </div>
         <div class="listState">State:
            <?= $listDetails['listState']; ?>
         </div>
         <div class="listProdPrice">$
            <?= $listDetails['listProdPrice']; ?>
         </div>
         <div class="listCond">
            <?= $listDetails['listCond']; ?>
         </div>

      </div>

      <div class="col-sm-12 listDesc">
         <b>Description</b>
         <?= $listDetails['listDesc']; ?>
      </div>

   </div> <!-- close requestInfo row-->

   <div class="row">
      <div class="col-sm-12 requestForm">
         <!-- message info -->
         <form action="requestProduct.php" method="post" enctype="multipart/form-data">
            <br>
            <!-- hidden listID -->
            <div>
               <input type="hidden" class="form-control" id="listID" name="listID"
                  value="<?= $listDetails['listID']; ?>">
            </div>
            <!-- hidden userID SEND TO -->
            <div>
               <input type="hidden" class="form-control" id="customerID" name="customerID"
                  value="<?php echo $customerID; ?>">
            </div>
            <div>
               <input type="hidden" class="form-control" id="customerInnie" name="customerInnie"
                  value="<?= $customerInfo['userInnie']; ?>">
            </div>
            <div>
               <input type="hidden" class="form-control" id="sellerID" name="sellerID"
                  value="<?= $listDetails['userID']; ?>">
            </div>
            <!-- hidden condition -->
            <div>
               <input type="hidden" class="form-control" id="isMessageReplied" name="isMessageReplied" value="No">
            </div>
            <div>
               <label for="sellerInnie">To:</label>
               <input type="text" class="form-control" id="sellerInnie" name="sellerInnie"
                  value="<?= $sellerInfo['userInnie']; ?>" readonly>
            </div>
            <!-- hidden title -->
            <div>
               <input type="hidden" class="form-control" id="messageTitle" name="messageTitle"
                  value="Requested: <?= $listDetails['listProdTitle']; ?>">
            </div>
            <div>
               <br>
               <label for="messageDesc">Message</label>
               <textarea class="form-control" id="messageDesc" name="messageDesc" rows="3" maxlength="275"
                  required></textarea>
            </div>
            <br>
            <div class="row rowCustomFiles">
               <div class="col-sm-12">
                  <label for="sendPic" class="customFiles" id="customFile1"><i class="fa-solid fa-image fa-lg"></i>
                     Insert Photo
                     <input type="file" id="sendPic" name="sendPic" accept="image/*">
                  </label>
                  <label for="sendPic2" class="customFiles" id="customFile2"> +
                     <input type="file" id="sendPic2" name="sendPic2" accept="image/*">
                  </label>
                  <label for="sendPic3" class="customFiles" id="customFile3"> +
                     <input type="file" id="sendPic3" name="sendPic3" accept="image/*">
                  </label>
                  <label for="sendPic4" class="customFiles" id="customFile4"> +
                     <input type="file" id="sendPic4" name="sendPic4" accept="image/*">
                  </label>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-2">
                  <div class="preview-container">
                     <img id="prevImg" />
                     <span class="remove-btn" id="removeBtn1"><i class="fa-regular fa-square-minus"></i></span>
                  </div>
               </div>
               <div class="col-lg-2">
                  <div class="preview-container">
                     <img id="prevImg2" />
                     <span class="remove-btn" id="removeBtn2"><i class="fa-regular fa-square-minus"></i></span>
                  </div>
               </div>
               <div class="col-lg-2">
                  <div class="preview-container">
                     <img id="prevImg3" />
                     <span class="remove-btn" id="removeBtn3"><i class="fa-regular fa-square-minus"></i></span>
                  </div>
               </div>
               <div class="col-lg-2">
                  <div class="preview-container">
                     <img id="prevImg4" />
                     <span class="remove-btn" id="removeBtn4"><i class="fa-regular fa-square-minus"></i></span>
                  </div>
               </div>
            </div>
            <div class="row rowBtnPost">
               <div class="col-sm-12">
                  <button class="customBtn" name="btnSend">Request</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div> <!-- close container -->

</body>

</html>
<script src="../include/logic/JS/js_photoManagement.js"></script>