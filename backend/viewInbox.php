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
$userID = $_SESSION['userID'];
$userInfo = $userDatabase->getUserDetails($userID);
$userListLog = $userDatabase->getUserListing($userID);
$messageLog = $userDatabase->getAllMessages($userID);
$deleteMessage = [];
/* maybe bread crumbs.. */
?>

<style>
   .profileObject {
      border-bottom: 1px solid rgba(186, 186, 186, .4);
      /* first 3 are the color, last is the opacity */
      background-clip: padding-box;
      -webkit-background-clip: padding-box;
   }

   /* Important, sets it so that was "edit" listing buttons only show on a table hover */
   table {
      width: 50%;
      border-collapse: collapse;
   }

   td:after {
      content: '';
      display: block;
      margin-top: 20%;
   }

   td .content-img {}

   table a:link {
      font-weight: bold;
      color: #6A99CD;
   }

   table a:visited {
      font-weight: normal;
   }
</style>

<div class="container">
   <div id="mainDiv">
      <!-- BEGIN TABLE -->
      <table class="table table-hover" id="userListLog">
         <thead>
            <tr>
               <th></th> <!-- list id -->
               <th>From</th>
               <th>Product ID</th>
               <th>For</th> <!-- requested title -->
               <th>Recieved</th>
               <th></th> <!-- time sent -->
            </tr>
         </thead>
         <tbody>
            <!-- For every value stored in the array we decl2ared in the PHP section -->
            <?php foreach ($messageLog as $row): ?>

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
                                 <?php echo $row['customerInnie']; ?>
                              </div>
                           </td>
                           <td>
                              <div class="listID">
                                 <?php echo $row['listID']; ?>
                              </div>
                           </td>
                           <td>
                              <a
                                 href="viewMessage.php?messageID=<?php echo $row['messageID']; ?>&parentID=<?php echo $row['parentID'];?>&receiverID=<?= $row['customerID']; ?>&receiverInnie=<?= $row['customerInnie']; ?>">
                                 <div class="messageTitle">
                                    <?php echo $row['messageTitle']; ?>
                                 </div>
                              </a>
                           </td>
                           <td>
                              <div class="messageSentOn">
                                 <?php echo date("Y-m-d h-i A", strtotime($row['messageSentOn'])); ?>
                              </div>
                           </td>
                        </div>
                     </div>

               </tr>
            <?php endforeach; ?>
            <!-- END for-loop -->
         </tbody>
      </table>
      <!-- END TABLE -->
   </div> <!-- main div -->
</div>
</body>

</html>