<?php
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
$parentID = $_GET['parentID'];
$messageID = $_GET['messageID'];
$messageDetails = $userDatabase->getMessageDetails($messageID);
/* Get customer's info */
$userID = $messageDetails['customerID'];
$customerInfo = $userDatabase->getUserDetails($userID);
/* Get requested product info */
$listID = $messageDetails['listID'];
$listDetails = $userDatabase->getListForm($listID);
/* bread crumbs */
$sellerID = $_SESSION['userID'];
$customerID = $userID;
$convoDetails = $userDatabase->getMessageCrumbs($sellerID, $customerID, $listID, $parentID);
$deleteMessage = [];
/* Get seller's info (logged in user)
Redeclare $userID as the logged in user's ID -> $sellerID
*/
$userID = $sellerID;
$sellerInfo = $userDatabase->getUserDetails($userID);

#----------------#
if (isPostRequest()) {
   $listID = filter_input(INPUT_POST, 'listID');
   $parentID = $_POST['parentID'];
   /* get the $userID thensent it to the method */
   $customerID = filter_input(INPUT_POST, 'sellerID');
   $customerInnie = filter_input(INPUT_POST, 'sellerInnie');
   $sellerID = filter_input(INPUT_POST, 'customerID');
   $sellerInnie = filter_input(INPUT_POST, 'customerInnie');
   $messageTitle = filter_input(INPUT_POST, 'messageTitle');
   $messageDesc = filter_input(INPUT_POST, 'messageDesc');
   $fileDestination = filter_input(INPUT_POST, 'fileDestination');
   $fileDestination2 = filter_input(INPUT_POST, 'fileDestination2');
   $fileDestination3 = filter_input(INPUT_POST, 'fileDestination3');
   $fileDestination4 = filter_input(INPUT_POST, 'fileDestination4');


   #--- Profile Picture Traveling -- #
   $file = $_FILES['sendPic'];
   if ($file['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination = '../backend/messageUpload/' . $file['name'];
      move_uploaded_file($file['tmp_name'], $fileDestination);
   }
   $file2 = $_FILES['sendPic2'];
   if ($file2['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination2 = '../backend/messageUpload/' . $file2['name'];
      move_uploaded_file($file2['tmp_name'], $fileDestination2);
   }
   $file3 = $_FILES['sendPic3'];
   if ($file2['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination3 = '../backend/messageUpload/' . $file3['name'];
      move_uploaded_file($file3['tmp_name'], $fileDestination3);
   }
   $file4 = $_FILES['sendPic4'];
   if ($file4['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination4 = '../backend/messageUpload/' . $file4['name'];
      move_uploaded_file($file4['tmp_name'], $fileDestination4);
   }

   if (
      $userDatabase->sendMessage($parentID,$customerID, $sellerID, $listID, 
      $messageTitle, $messageDesc, $fileDestination, $customerInnie, 
      $sellerInnie, $fileDestination2, $fileDestination3, $fileDestination4)
   ) {
      header('Location: viewInbox.php');
      $message = "Your message Was Sent!";

   } else {
      $message = "Error sending message, please try again.";
   }
}
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

   .listID {
      color: #506d90;
      font-size: 13px;
      max-width: 250px;
   }

   .listSeller {
      font-size: 13px;
      color: #506d90;
   }

   .listImgBox {}

   .listInfoBox {}

   .requestInfo {
      margin-top: 15px;
      border: 2px solid #F1F1F1;
      padding: 15px;
   }

   .profileObject {
      border: 5px solid #F1F1F1;
      /* first 3 are the color, last is the opacity */
   }

   .customerPP {
      object-fit: cover;
      /* Do not scale the image */
      object-position: center;
      /* Center the image within the element */
      width: 200px;
      height: 200px;
      margin-bottom: 1rem;
   }

   .MessageContainer {
      margin-top: 15px;
      border: 2px solid #F1F1F1;
   }


   .msgHeader {
      font-weight: bold;
      font-size: 25px;
   }

   .messageDesc {
      background-color: #F8F9FA;
      padding: 30px;
   }

   .messageSentOn {
      font-size: 13px;
   }

   #sendPic,
   #sendPic2,
   #sendPic3,
   #sendPic4 {
      width: 73px;
      height: 25px;
      margin-right: 5px;
      padding: 0px;
      border: 0px;
   }

   .main-img {
      width: 650px;
      height: 650px;
   }

   .thumb-imgs {
      display: flex;
      flex-direction: row;
      align-items: center;
      margin-bottom: 15px;
   }

   .thumb-imgs img {
      cursor: pointer;
   }
</style>

<div class="container">
   <div class="row bg-light profileObject">
      <div class="col-md-4">
         <div class="img-container">
            <?php
            $defaultAvie = "../include/default-avie/default-avie.jpg";
            if (is_null($customerInfo['userPic']) || empty($customerInfo['userPic'])) {
               echo "<img src= '$defaultAvie' class='customerPP rounded-circle' alt='profile picture' style='border: solid 2px blue;'>";
            } else {
               echo "<img src='" . $customerInfo['userPic'] . "' class='customerPP rounded-circle' alt='profile picture' style='border: solid 2px blue;'>";
            }
            ?>
         </div>
      </div>

      <div class="col-md-3">
         <h1>
            <?php echo $customerInfo['userInnie']; ?>
         </h1>
         <small id="joinDate" class="form-text text-muted profDetails">
            Joined: <b>
               <?php echo date("Y-m-d", strtotime($customerInfo['userJoined'])); ?>
            </b>
            State: <b>
               <?php echo $customerInfo['userState']; ?>
            </b>
         </small>
         <br>
         <small id="bioTitle" class="form-text text-muted">Biography</small>
         <p>
            <?php echo $customerInfo['userBio']; ?>
         </p>
      </div>
   </div> <!-- end user's profile -->


   <!-- Message -->
   <div class="row MessageContainer">
      <div class="col-sm-12">
         <div class="row-sm-12 msgHeader">
            <p>Newest Message</p>
         </div>
         <div class="row-sm-12 messageSentOn">
            </p>sent:
            <?php echo date("h-i A", strtotime($messageDetails['messageSentOn'])); ?>
            On
            <?php echo date("Y-m-d", strtotime($messageDetails['messageSentOn'])); ?>
            </p>
         </div>
         <div class="row-sm-12 messageDesc">
            <p>
               <?php echo $messageDetails['messageDesc']; ?>
            </p>

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
                     <img src=""
                        style=" object-fit: contain; object-position: center; width: 650px; height: 650px;
                  background-color: #F6F6F6;">
               </div>
            <?php endif ?>
         </div>
      </div>


      <div class="col-sm-12 msgReply">
         <!-- reply -->
         <form action="viewMessage.php" method="post" enctype="multipart/form-data">
            <br>
            <div>
               <input type="text" class="form-control" id="parentID" name="parentID"
                  value="<?= $messageDetails['parentID']; ?>" readonly>
            </div>
            <!-- hidden listID -->
            <div>
               <input type="text" class="form-control" id="listID" name="listID"
                  value="<?= $listDetails['listID']; ?>">
            </div>
            <!-- customer's id (who sent you the message) -->
            <div>
               <input type="hidden" class="form-control" id="customerID" name="customerID"
                  value="<?php echo $customerInfo['userID']; ?>">
            </div>
            <!-- customer's name (who sent you the message) -->
            <div>
               <input type="hidden" class="form-control" id="customerInnie" name="customerInnie"
                  value="<?= $customerInfo['userInnie']; ?>">
            </div>
            <!-- seller's id (who the message was sent) -->
            <div>
               <input type="hidden" class="form-control" id="sellerID" name="sellerID"
                  value="<?= $listDetails['userID']; ?>">
            </div>
            <!-- seller's name (who the message was sent) -->
            <div>
               <input type="hidden" class="form-control" id="sellerInnie" name="sellerInnie"
                  value="<?= $sellerInfo['userInnie']; ?>" readonly>
            </div>
            <!-- hidden title, autogenerate RE | to mark as a reply.-->
            <div>
               <input type="hidden" class="form-control" id="messageTitle" name="messageTitle"
                  value="RE | Requested: <?= $listDetails['listProdTitle']; ?>">
            </div>
            <!-- User enter message -->
            <div>
               <textarea class="form-control" id="messageDesc" name="messageDesc" rows="2" maxlength="275"
                  required></textarea>
            </div>
            <!-- User Send Pics -->
            <br>


            <div class="container insertPics">
               <div class="row">
                  <div class="col-xs-1">
                     <input type="file" id="sendPic" name="sendPic" class="form-control" accept="image/*">
                  </div>
                  <div class="col-xs-1">
                     <input type="file" id="sendPic2" name="sendPic2" class="form-control" accept="image/*">
                  </div>
                  <div class="col-xs-1">
                     <input type="file" id="sendPic3" name="sendPic3" class="form-control" accept="image/*">
                  </div>
                  <div class="col-xs-1">
                     <input type="file" id="sendPic4" name="sendPic4" class="form-control" accept="image/*">
                  </div>
               </div>
            </div>
            <!-- send -->
            <div class="btnSend">
               <button class="btn btn-outline-primary">Just Reply</button>
            </div>
         </form>
      </div>
   </div>







   <!-- request info -->
   <div class="row requestInfo">
      <div class="col-sm-12">
         <p class="msgHeader">About</p>
      </div>
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
      <div class="col-sm-12">
         <form method="">
            <br>
            <button class="btn btn-outline-primary">Confirm Sale</button>
         </form>
      </div>
   </div> <!-- close requestInfo row-->

   <table class="table table-hover" id="userListLog">
      <thead>
         <tr>
            <th></th> <!-- list id -->
            <th>History</th> <!-- requested title -->
            <th>Time</th>
         </tr>
      </thead>
      <tbody>
         <!-- For every value stored in the array we declared in the PHP section -->
         <?php foreach ($convoDetails as $row): ?>
            <tr>
               <td>
                  <!-- form to manage post requests -->
                  <form action="" method="post">
                     <!-- hidden listID field. -->
                     <input type="hidden" name="customerID" value="<?= $row['customerID']; ?>" />
                     <input type="hidden" name="messageID" value="<?= $row['messageID']; ?>" />
                  </form>
               </td>
               <div class="container">
                  <div class="row">
                     <div class="col-sm">
                        <td>
                           <div class="sentFrom">
                              <?php echo $row['messageDesc']; ?>
                           </div>
                        </td>
                        <td>
                           <div class="messageSentOn">
                              <?php echo date("h-i A Y-m-d", strtotime($row['messageSentOn'])); ?>
                           </div>
                        </td>
                     </div>
                  </div>
            </tr>
         <?php endforeach; ?>
         <!-- END for-loop -->
      </tbody>
   </table>
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

</script>