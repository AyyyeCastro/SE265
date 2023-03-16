<!DOCTYPE html>
<?php
ob_start();
require '../include/header.php';
require '../include/logic/php/php_viewMessage.php';
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/viewMessage.css">
<div class="container">
   <h2>Messaging</h2>

   
   <div class="row profileObject">
   <?php if (!empty($profileInfo)):?>
      <div class="col-md-4">
         <div class="img-container">
            <?php
            $defaultAvie = "../include/default-avie/default-avie.jpg";
            if (is_null($profileInfo['userPic']) || empty($profileInfo['userPic'])) {
               echo "<img src= '$defaultAvie' class='customerPP rounded-circle' alt='profile picture' style='border: solid 2px blue;'>";
            } else {
               echo "<img src='" . $profileInfo['userPic'] . "' class='customerPP rounded-circle' alt='profile picture' style='border: solid 2px blue;'>";
            }
            ?>
         </div>
      </div>

      <div class="col-md-6">
         <h1>
            <?php echo $profileInfo['userInnie']; ?>
         </h1>
         <small id="joinDate" class="form-text text-muted profDetails">
            Joined: <b>
               <?php echo date("Y-m-d", strtotime($profileInfo['userJoined'])); ?>
            </b>
            State: <b>
               <?php echo $profileInfo['userState']; ?>
            </b>
         </small>
         <br>
         <small id="bioTitle" class="form-text text-muted">Biography</small>
         <p>
            <?php echo $profileInfo['userBio']; ?>
         </p>
      </div>
      <?php else: echo '<div class="noProduct">User no longer exists, or could be retrieved.</div>'; ?>
      <?php endif ?>
   </div> <!-- end user's profile -->
   


   <!-- Message -->
   <div class="row MessageContainer">

      <div class="col-lg-12">

         <div class="col-lg-12 msgHistory">
            <?php foreach ($convoDetails as $row): ?>
               <div class="row">
                  <?php if ($row['customerInnie'] == $senderInfo['userInnie']): ?>
                     <span class="selfMsg selfBG">
                        <p class="messageDesc">
                           <?php echo $row['messageDesc']; ?>
                        <p>
                        </p class="messageSentOn">sent:
                        <?php echo date("h:i A", strtotime($row['messageSentOn'])); ?>
                        On
                        <?php echo date("Y-m-d", strtotime($row['messageSentOn'])); ?>
                        </p>
                        <p>
                           <?php if (!empty($row['messagePics'])): ?>
                              <img src="<?= $row['messagePics']; ?>"
                                 style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black;">
                           <?php endif ?>

                           <?php if (!empty($row['messagePic2'])): ?>
                              <img src="<?= $row['messagePic2']; ?>"
                                 style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black;">
                           <?php endif ?>

                           <?php if (!empty($row['messagePic3'])): ?>
                              <img src="<?= $row['messagePic3']; ?>"
                                 style="object-fit: contain; object-position:c enter; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-top: 2px;">
                           <?php endif ?>
                           <?php if (!empty($row['messagePic4'])): ?>
                              <img src="<?= $row['messagePic4']; ?>"
                                 style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-top: 2px;">
                           <?php endif ?>
                        </p>
                     </span>
                  <?php else: ?>
                     <span class="otherMsg otherBG">
                        <p class="messageDesc">
                           <?php echo $row['messageDesc']; ?>
                        </p>
                        </p class="messageSentOn">
                        sent:
                        <?php echo date("h:i A", strtotime($row['messageSentOn'])); ?>
                        On
                        <?php echo date("Y-m-d", strtotime($row['messageSentOn'])); ?>
                        </p>
                        <p>
                           <?php if (!empty($row['messagePics'])): ?>
                              <img src="<?= $row['messagePics']; ?>"
                                 style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black;">
                           <?php endif ?>

                           <?php if (!empty($row['messagePic2'])): ?>
                              <img src="<?= $row['messagePic2']; ?>"
                                 style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black;">
                           <?php endif ?>

                           <?php if (!empty($row['messagePic3'])): ?>
                              <img src="<?= $row['messagePic3']; ?>"
                                 style="object-fit: contain; object-position:c enter; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-top: 2px;">
                           <?php endif ?>
                           <?php if (!empty($row['messagePic4'])): ?>
                              <img src="<?= $row['messagePic4']; ?>"
                                 style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-top: 2px;">
                           <?php endif ?>
                        </p>
                     </span>
                  <?php endif ?>
               </div>
            <?php endforeach; ?>
         </div>

         <div class="newestMessageBox">
            <div class="row-sm-12 newestMessage">
               <p>
                  <?php echo $messageDetails['messageDesc']; ?>
               </p>
               <p class="messageSentOn">sent:
                  <?php echo date("h:i A", strtotime($messageDetails['messageSentOn'])); ?>
                  On
                  <?php echo date("Y-m-d", strtotime($messageDetails['messageSentOn'])); ?>
               </p>
            </div>
            <!-- display sent messages. Only show these divs if messages are sent, otherwise.. why? -->
            <div class="col-sm-12 thumb-imgs" onclick="TestsFunction()">
               <?php if (!empty($messageDetails['messagePics'])): ?>
                  <img src="<?= $messageDetails['messagePics']; ?>"
                     style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black;">
               <?php endif ?>

               <?php if (!empty($messageDetails['messagePic2'])): ?>
                  <img src="<?= $messageDetails['messagePic2']; ?>"
                     style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-left: 5px;">
               <?php endif ?>

               <?php if (!empty($messageDetails['messagePic3'])): ?>
                  <img src="<?= $messageDetails['messagePic3']; ?>"
                     style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-left: 5px;">
               <?php endif ?>
               <?php if (!empty($messageDetails['messagePic4'])): ?>
                  <img src="<?= $messageDetails['messagePic4']; ?>"
                     style="object-fit: contain; object-position: center; width: 100px; height: 100px; background-color: #F6F6F6; border: 1px solid black; margin-left: 5px;">
               <?php endif ?>
            </div>
            <?php if (!empty($messageDetails['messagePics']) || !empty($messageDetails['messagePic2']) || !empty($messageDetails['messagePic3']) || !empty($messageDetails['messagePic4'])): ?>
               <div class="main-img" id="TestsDiv" style="display:none"">
                                                                        <img src=""style=" object-fit: contain;
                  object-position: center; background-color: #F6F6F6; height: 450px; width: 450px;">
               </div>
            <?php endif ?>
         </div>
      </div> <!-- end history and newest message -->

      <?php if (!empty($listDetails)):?>
      <div class="col-lg-12 msgReply">
         <!-- reply -->
         <form action="viewMessage.php" method="post" enctype="multipart/form-data">
            <br>

            <!-- FOR UPDATING OLD MESSAGE CONDITION -->
            <div>
               <input type="hidden" class="form-control" id="priorMessageID" name="priorMessageID"
                  value="<?= $messageDetails['messageID']; ?>" readonly>
            </div>
            <!-- hidden condition: UPDATE Prior message-->
            <div>
               <input type="hidden" class="form-control" id="updateStatus" name="updateStatus" value="Yes">
            </div>
            <!-- END -->


            <div>
               <input type="hidden" class="form-control" id="parentID" name="parentID"
                  value="<?= $messageDetails['parentID']; ?>" readonly>
            </div>
            <!-- hidden listID -->
            <div>
               <input type="hidden" class="form-control" id="listID" name="listID"
                  value="<?= $listDetails['listID']; ?>">
            </div>
            <!-- customer's id (who sent you the message) -->
            <div>
               <input type="hidden" class="form-control" id="sellerID" name="sellerID"
                  value="<?php echo $receiverID ?>">
            </div>
            <div>
               <input type="hidden" class="form-control" id="sellerInnie" name="sellerInnie"
                  value="<?php echo $sellerInnie ?>">
            </div>
            <div>
               <input type="hidden" class="form-control" id="customerID" name="customerID"
                  value="<?php echo $senderInfo['userID'] ?>">
            </div>
            <!-- hidden condition: INSERT FOR THIS MESSAGE -->
            <div>
               <input type="hidden" class="form-control" id="isMessageReplied" name="isMessageReplied" value="No">
            </div>
            <div>
               <input type="hidden" class="form-control" id="customerInnie" name="customerInnie"
                  value="<?php echo $senderInfo['userInnie'] ?>">
            </div>

            <!-- hidden title, autogenerate RE | to mark as a reply.-->
            <div>
               <?php if ($listDetails['isListSold'] != 'YES'): ?>
                  <input type="hidden" class="form-control" id="messageTitle" name="messageTitle"
                     value="RE | Requested: <?= $listDetails['listProdTitle']; ?>">
               <?php else: ?>
                  <input type="hidden" class="form-control" id="messageTitle" name="messageTitle"
                     value="RE | SALE INQUIRY: <?= $listDetails['listProdTitle']; ?>">
               <?php endif; ?>
            </div>
            <?php if ($messageDetails['isMessageReplied']!='Yes'):?>
            <!-- User enter message -->
            <div>
               <textarea class="form-control" id="messageDesc" name="messageDesc" rows="2" maxlength="275"
                  required></textarea>
            </div>
            <!-- User Send Pics -->
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
               <div class="col-sm-3 col-md-4 col-lg-3">
                  <div class="preview-container">
                     <img id="prevImg" />
                     <span class="remove-btn" id="removeBtn1"><i class="fa-regular fa-square-minus"></i></span>
                  </div>
               </div>
               <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="preview-container">
                     <img id="prevImg2" />
                     <span class="remove-btn" id="removeBtn2"><i class="fa-regular fa-square-minus"></i></span>
                  </div>
               </div>
               <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="preview-container">
                     <img id="prevImg3" />
                     <span class="remove-btn" id="removeBtn3"><i class="fa-regular fa-square-minus"></i></span>
                  </div>
               </div>
               <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="preview-container">
                     <img id="prevImg4" />
                     <span class="remove-btn" id="removeBtn4"><i class="fa-regular fa-square-minus"></i></span>
                  </div>
               </div>
            </div>
            <div class="row rowBtnPost">
               <div class="col-sm-12">
                  <button class="customBtn" name="btnSend">Reply Back</button>
               </div>
            </div>
            <?php else: echo '<div class="noProduct">Already replied to this message.</div>'; ?>
            <?php endif ?>
         </form>
         <?php else: echo '<div class="noProduct"> Cannot reply, since product could not be retrieved from the database, or was removed.</div>' ?>
      </div>
      <?php endif ?>
   </div>
</div> </div>

<div class="container requestInfoContainer">
   <!-- request info -->
   <div class="row requestInfo">

      <div class="col-sm-12">
         <p class="msgHeader">About</p>
      </div>
      
      <?php if (!empty($listDetails)):?>
      <div class="col-sm listImgBox">
         <!-- posted from this user -->
         <input type="hidden" name="sellerID" value="<?= $listDetails['userID']; ?>" />
         <!-- product listID -->
         <input type="hidden" name="p_id" value="<?= $listDetails['listID']; ?>" />
         <div class="listProdPic"><img src="<?= $listDetails['listProdPic']; ?>"
               style="object-fit: contain; object-position: center; width: 250px; height: 250px; background-color: #F6F6F6;">
         </div>
         <div class="listProdCat"> Listed in:
            <?= $listDetails['listProdCat']; ?>
         </div>
         <div class="listState">
            <?php if ($listDetails['isListSold'] == 'YES'): ?>
               <p class="listIsSold">
                  ORDER ID:
                  <?php echo $listDetails['orderID'] ?>
               </p>
            <?php endif ?>
         </div>
      </div>

      <div class="col-sm listInfoBox">

         <div class="listProdTitle">
            <?= $listDetails['listProdTitle']; ?>
         </div>
         <div class="listID">Product ID:
            <?= $listDetails['listID']; ?>
         </div>
         <div class="listPostedOn">Posted on:
            <?php echo date("Y-m-d", strtotime($listDetails['listPostedOn'])); ?>
         </div>
         <div class="listState">State:
            <?= $listDetails['listState']; ?>
         </div>
         <br>
         <b>Description</b>
         <div class="listDesc">
            <?= $listDetails['listDesc']; ?>
         </div>
         <div class="listProdPrice">$
            <?= $listDetails['listProdPrice']; ?>
         </div>
         <div class="listCond">
            <?= $listDetails['listCond']; ?>
         </div>
      </div>
      
      <!-- If the session ID (logged in User's ID) is equal to the ID of the user who posted the sale -->
      <?php if ($_SESSION['userID'] == $listDetails['userID'] && $listDetails['isListSold'] != 'YES'): ?>
         <div class="col-sm-12">
            <form action="viewMessage.php" method="post" enctype="multipart/form-data">
               <!-- hidden listID -->
               <div>
                  <input type="hidden" class="form-control" id="priorMessageID" name="priorMessageID"
                     value="<?= $messageDetails['messageID']; ?>" readonly>
               </div>
               <!-- hidden condition: UPDATE Prior message-->
               <div>
                  <input type="hidden" class="form-control" id="updateStatus" name="updateStatus" value="Yes">
               </div>
               <div>
                  <input type="hidden" class="form-control" id="parentID" name="parentID"
                     value="<?= $messageDetails['parentID']; ?>" readonly>
               </div>
               <!-- hidden listID -->
               <div>
                  <input type="hidden" class="form-control" id="listID" name="listID"
                     value="<?= $listDetails['listID']; ?>">
               </div>
               <!-- customer's id (who sent you the message) -->
               <div>
                  <input type="hidden" class="form-control" id="sellerID" name="sellerID"
                     value="<?php echo $receiverID ?>">
               </div>
               <div>
                  <input type="hidden" class="form-control" id="sellerInnie" name="sellerInnie"
                     value="<?php echo $sellerInnie ?>">
               </div>
               <div>
                  <input type="hidden" class="form-control" id="customerID" name="customerID"
                     value="<?php echo $senderInfo['userID'] ?>">
               </div>
               <!-- hidden condition: INSERT FOR THIS MESSAGE -->
               <div>
                  <input type="hidden" class="form-control" id="customerInnie" name="customerInnie"
                     value="<?php echo $senderInfo['userInnie'] ?>">
               </div>

               <!-- hidden title, autogenerate RE | to mark as a reply.-->
               <div>
                  <input type="hidden" class="form-control" id="messageTitle" name="messageTitle"
                     value="RE | SALE CONFIRMED: <?= $listDetails['listProdTitle']; ?>">
               </div>
               <div>
                  <input type="hidden" class="form-control" id="messageDesc" name="messageDesc"
                     value="<?php echo $senderInfo['userInnie'] ?> HAS CONFIRMED THE SALE OF THE BELOW ITEM.">
               </div>

               <!-- send -->
               <div class="btnConfirmSale">
                  <button class="customBtn" name="btnConfirmSale">Confirm Sale</button>
               </div>
            </form>
         </div>
      <?php endif ?>
   </div> <!-- close requestInfo row-->
   <?php else: echo '<div class="noProduct">Product could not be retrieved from the database, or was removed.</div>'; ?>
   <?php endif ?>
</div>
</body>

</html>
<script src="../include/logic/JS/js_viewMessages.js"></script>