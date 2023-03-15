<!DOCTYPE html>
<?php
ob_start();
require "../include/header.php";
require "../include/logic/php/php_productDetails.php";
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/productDetails.css">
<?php if (empty($listDetails)){
   header('Location: plugInHome.php');
   }?>
<div class="container">
   <div class="row">
      <div class="col-md-7 listImgBox">
         <input type="hidden" name="userID" value="<?= $sellerInfo['userID']; ?>" />
         <input type="hidden" name="p_id" value="<?= $listDetails['listID']; ?>" />
         <div class="main-img">
            <img src="<?= $listDetails['listProdPic']; ?>"
               style="object-fit: contain; object-position: center; width: 450px; height: 450px; background-color: #F6F6F6;">
         </div>
      </div>

      <div class="col-lg-5 listInfoBox">
         <div class="listProdTitle">
            <?= $listDetails['listProdTitle']; ?>
         </div>
         <div class="listPostedOn">Posted on:
            <?php echo date("Y-m-d", strtotime($listDetails['listPostedOn'])); ?>
         </div>
         <div class="listProdCat"> Listed in:
            <?= $listDetails['listProdCat']; ?>
         </div>

         <?php if ($listDetails['isListSold'] != 'YES'): ?>
            <div class="col-md-12 listBuyBox">
               <div class="listProdPrice">$
                  <?= $listDetails['listProdPrice']; ?>
               </div>
               <div class="listCond">
                  <?= $listDetails['listCond']; ?>
               </div>
               <div class="btnRequest">
                  <a href="requestProduct.php?listID=<?= $listDetails['listID']; ?>""><button class=" btn btn-md
                     btn-primary btnBuyNow">Request</button></a>
               </div>
               <div class="underBtnText">
                  <div class="listSeller">Seller:
                     <?= $sellerInfo['userInnie']; ?>
                  </div>
                  <div class="listState">State:
                     <?= $listDetails['listState']; ?>
                  </div>
               </div>
            </div>
         <?php else: ?>
            <div class="col-md-12 listBuyBox">
               <div class="listProdPrice">$
                  <?= $listDetails['listProdPrice']; ?>
               </div>
               <div class="listCond">
                  <?= $listDetails['listCond']; ?>
               </div>
              
               <?php if ($sellerInfo['userID'] != $loginID && $isAlreadyRated == false && isset($_SESSION['userID'])): ?>
                  <form action="productDetails.php" method="post">
                     <div class="form-group">
                        <label for="userRating">Transaction Rating:</label>
                        <select class="form-control" id="userRating" name="userRating">
                           <option value="1">1 star</option>
                           <option value="2">2 stars</option>
                           <option value="3">3 stars</option>
                           <option value="4">4 stars</option>
                           <option value="5">5 stars</option>
                        </select>
                     </div>
                     <input type="hidden" name="userID" value="<?php echo $sellerInfo['userID']; ?>">
                     <input type="hidden" name="orderID" value="<?php echo $orderID ?>">
                     <button type="submit" class="btn btn-outline-primary" name="btnRate">Rate Seller</button>
                  </form>
               <?php endif ?>
               <div class="underBtnText">
                  <div class="listState">State:
                     <?= $listDetails['listState']; ?>
                  </div>
                  <div class="timeListsold">SOLD ON:
                  <?= $listDetails['timeListsold']; ?>
               </div>
               <div class="customerInnie">
                  Seller:
                  <a href="viewUsers.php?userID=<?= $sellerInfo['userID']; ?>">
                     <?= $sellerInfo['userInnie']; ?>
                  </a>
               </div>
               <div class="listSeller">Buyer:
                  <a href="viewUsers.php?userID=<?= $listDetails['sellerID']; ?>">
                     <?= $listDetails['sellerInnie']; ?>
                  </a>
               </div>
               </div>
            </div>
         <?php endif ?>

      </div>
      <div class="col-md-12">
         <div class="col-md-6 thumb-imgs">
            <img src="<?= $listDetails['listProdPic']; ?>"
               style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black;">
            <?php if (!empty($listDetails['listProdPic2'])): ?>
               <img src="<?= $listDetails['listProdPic2']; ?>"
                  style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-left: 5px;">
            <?php endif ?>
            <?php if (!empty($listDetails['listProdPic3'])): ?>  
               <img src="<?= $listDetails['listProdPic3']; ?>"
                  style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-left: 5px;">
            <?php endif ?>
            <?php if (!empty($listDetails['listProdPic4'])): ?>
               <img src="<?= $listDetails['listProdPic4']; ?>"
                  style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-left: 5px;">
            <?php endif ?>
         </div>
      </div>

      <div class="col-md-12 listDescBox">
         <p class="listDescHeader">Description</p>
         <div class="listDesc">
            <?= $listDetails['listDesc']; ?>
         </div>
      </div>
   </div>
</div>

</body>

</html>


<script>
   // JQuery script not by me. Easy enough now that I see it, but this was Google 101.
   $(document).ready(function () {
      $('.thumb-imgs img').click(function () {
         $('.main-img img').attr('src', $(this).attr('src'));
      });
   });
</script>`