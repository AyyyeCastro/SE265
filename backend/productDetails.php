<?php
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
$listID = $_GET['listID'];
$listDetails = $userDatabase->getListForm($listID);
/* get the $userID thensent it to the method */
$userID = $listDetails['userID'];
$sellerInfo = $userDatabase->getUserDetails($userID);
?>
<style>
   .container {
      padding: 25px;
   }

   .listProdTitle {
      font-weight: bold;
      font-size: 25px;
      max-width: 250px;
      /* limit title width to the same width of the of the image */
   }

   .listProdCat {
      color: #506d90;
      max-width: 250px;
   }

   .listProdPrice {
      padding-top: 3px;
      font-size: 18px;
      max-width: 250px;
   }

   .listCond {
      color: #506d90;
      font-size: 13px;
      max-width: 250px;
   }

   .listState {
      font-size: 13px;
      max-width: 250px;
   }

   .listSeller {
      font-size: 13px;
      color: #506d90;
   }

   .listImgBox {}

   .listInfoBox {}

   .listBuyBox {
      border: 5px solid #F1F1F1;
   }

   .btnBuyNow {
      margin-top: 15px;
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
</style>


<div class="container">
   <div class="row">
      <div class="col-sm listImgBox">
         <input type="hidden" name="userID" value="<?= $sellerInfo['userID']; ?>" />
         <input type="hidden" name="p_id" value="<?= $listDetails['listID']; ?>" />
         <div class="main-img">
            <img src="<?= $listDetails['listProdPic']; ?>"
               style="object-fit: contain; object-position: center; width: 450px; height: 450px; background-color: #F6F6F6;">
         </div>
      </div>

      <div class="col-sm listInfoBox">
         <div class="listProdTitle">
            <?= $listDetails['listProdTitle']; ?>
         </div>
         <div class="listSeller">Seller:
            <?= $sellerInfo['userInnie']; ?>
         </div>
         <div class="listPostedOn">Posted on:
            <?php echo date("Y-m-d", strtotime($listDetails['listPostedOn'])); ?>
         </div>
         <div class="listState">State:
            <?= $listDetails['listState']; ?>
         </div>
         <div class="listProdCat"> Listed in:
            <?= $listDetails['listProdCat']; ?>
         </div>
      </div>

      <div class="col-sm listBuyBox">
         <div class="listProdPrice">$
            <?= $listDetails['listProdPrice']; ?>
         </div>
         <div class="listCond">
            <?= $listDetails['listCond']; ?>
         </div>
         <a href="requestProduct.php?listID=<?= $listDetails['listID']; ?>""><button class=" btn btn-md btn-primary
            btnBuyNow">Request</button></a>
      </div>


      <div class="col-sm-12">
         <div class="col-sm-4 thumb-imgs">
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

      <div class="col-sm-12">
         <hr>
         <b>Description</b>
         <div class="listDesc">
            <?= $listDetails['listDesc']; ?>
         </div>
      </div>
   </div>
</div>


<script>
   // JQuery script not by me. Easy enough now that I see it, but this was Google 101.
   $(document).ready(function () {
      $('.thumb-imgs img').click(function () {
         $('.main-img img').attr('src', $(this).attr('src'));
      });
   });
</script>