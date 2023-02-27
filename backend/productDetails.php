<!DOCTYPE html>
<?php
ob_start();
//call other files
include_once "../model/userController.php";
include_once "../include/functions.php";
include_once "../include/header.php";

// //if not logged in, kick them
// if (!isUserLoggedIn())
// {
//    header("location: ../login.php"); 
// }

$configFile = '../model/dbconfig.ini';
try {
   $userDatabase = new Users($configFile);
} catch (Exception $error) {
   echo "<h2>" . $error->getMessage() . "</h2>";
}

/* get the list ID from the URL, send it to the method */
$loginID = $_SESSION['userID'];
$listID = $_GET['listID'];
$listDetails = $userDatabase->getListForm($listID);
/* get the $userID thensent it to the method */
$userID = $listDetails['userID'];
$sellerInfo = $userDatabase->getUserDetails($userID);

if (isset($_GET['orderID'])) {
   $orderID = $_GET['orderID'];
   $isAlreadyRated = $userDatabase->isAlreadyRated($orderID);
}

if (isPostRequest()) {

   if (isset($_POST['btnRate'])) {
      $userID = filter_input(INPUT_POST, 'userID');
      $userRating = filter_input(INPUT_POST, 'userRating');
      $orderID = filter_input(INPUT_POST, 'orderID');

      if ($userDatabase->giveUserRating($userID, $userRating, $orderID)) {
         header("location: ../backend/viewProfile.php");
      }
   }
}

?>
<style>
   .container {
      padding: 15px;
   }

   .listProdTitle {
      font-size: 25px;
      max-width: 100%;
      /* limit title width to the same width of the of the image */
   }

   .listProdCat {
      color: #506d90;
      max-width: 250px;
   }

   .listProdPrice {
      font-size: 18px;
      max-width: 250px;
      font-weight: bold;
   }

   .listCond {
      color: #506d90;
      font-size: 13px;
      max-width: 250px;
   }


   .underBtnText {
      margin-top: 10px;
      font-size: 13px;
   }

   .listImgBox {}

   .listInfoBox {}

   .listBuyBox {
      border: 4px solid #F8F8F8;
      border-radius: 25px;
      padding: 15px;
      margin-top: 15px;
   }

   .btnBuyNow {
      margin-top: 15px;
      width: 100%;
      background-color: #4D27B9;
   }

   .listImgBox {
      display: flex;
      flex-direction: row;
      align-items: center;
   }

   .main-img {
      width: 450px;
      height: 450px;
   }

   .thumb-imgs {
      display: flex;
      flex-direction: row;
      align-items: center;
      margin-left: 10px;
      margin-top: 15px;
   }

   .thumb-imgs img {
      cursor: pointer;
   }

   .listDescBox {
      margin-top: 10px;
      padding: 10px;
      background-color: #f8f8f8;
      border-radius: 25px;
   }
</style>


<div class="container">
   <div class="row">
      <div class="col-sm-7 listImgBox">
         <input type="hidden" name="userID" value="<?= $sellerInfo['userID']; ?>" />
         <input type="hidden" name="p_id" value="<?= $listDetails['listID']; ?>" />
         <div class="main-img">
            <img src="<?= $listDetails['listProdPic']; ?>"
               style="object-fit: contain; object-position: center; width: 450px; height: 450px; background-color: #F6F6F6;">
         </div>
      </div>

      <div class="col-sm-5 listInfoBox">
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
            <div class="col-sm-12 listBuyBox">
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
            <div class="col-sm-12 listBuyBox">
               <div class="listProdPrice">$
                  <?= $listDetails['listProdPrice']; ?>
               </div>
               <div class="listCond">
                  <?= $listDetails['listCond']; ?>
               </div>
               <div class="timeListsold">SOLD ON:
                  <?= $listDetails['timeListsold']; ?>
               </div>
               <div class="customerInnie">
                  Buyer: 
               <a href="viewUsers.php?userID=<?= $sellerInfo['userID']; ?>">
                  <?= $listDetails['customerInnie']; ?>
               </a>
               </div>
               <?php if ($sellerInfo['userID'] != $loginID && $isAlreadyRated == false): ?>
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
                  <div class="listSeller">Seller:
                     <?= $sellerInfo['userInnie']; ?>
                  </div>
                  <div class="listState">State:
                     <?= $listDetails['listState']; ?>
                  </div>
               </div>
            </div>
         <?php endif ?>

      </div>
      <div class="col-sm-12">
         <div class="col-sm-6 thumb-imgs">
            <img src="<?= $listDetails['listProdPic']; ?>"
               style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black;">
            <?php if (!empty($listDetails['listProdPic2']) || !empty($listDetails['listProdPic3']) || !empty($listDetails['listProdPic4'])): ?>
               <img src="<?= $listDetails['listProdPic2']; ?>"
                  style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-left: 5px;">
               <img src="<?= $listDetails['listProdPic3']; ?>"
                  style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-left: 5px;">
               <img src="<?= $listDetails['listProdPic4']; ?>"
                  style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-left: 5px;">
            <?php endif ?>
         </div>
      </div>

      <div class="col-sm-12 listDescBox">
         <p class="listDescHeader">Description</p>
         <div class="listDesc">
            <?= $listDetails['listDesc']; ?>
         </div>
      </div>
   </div>
</div>

</body>

</html>
<?php include_once '../include/footer.php'; ?>


<script>
   // JQuery script not by me. Easy enough now that I see it, but this was Google 101.
   $(document).ready(function () {
      $('.thumb-imgs img').click(function () {
         $('.main-img img').attr('src', $(this).attr('src'));
      });
   });
</script>