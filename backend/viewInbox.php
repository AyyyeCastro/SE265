<!DOCTYPE html>
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
   .container {
      padding: 15px;
      min-width: 75%;
   }

   /* Important, sets it so that was "edit" listing buttons only show on a table hover */
   table {
      border-collapse: collapse;
   }

   table a {
      color: black;
   }

   td:after {
      content: '';
      display: block;
      margin-top: 15%;
   }

   .unreplied {
      font-weight: bold;
      background-color: #F0F0FA;
   }

   .replied {
      font-weight: normal;
      color: black;
   }

   .subText {
      color: #506d90;
      font-size: 12px;
      margin-top: 2px;
   }
</style>

<div class="container">
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
            <?php if ($row['isMessageReplied'] == 'No'): ?>
               <tr class="unreplied">
                  <td>
                     <!-- form to manage post requests -->
                     <form action="" method="post">
                        <!-- hidden listID field. -->
                        <input type="hidden" name="customerID" value="<?= $row['customerID']; ?>" />
                        <input type="hidden" name="messageID" value="<?= $row['messageID']; ?>" />
                     </form>
                  </td>
                  <td>
                     <p class="sentFrom">
                        <?php echo $row['customerInnie']; ?>
                     </p>
                  </td>
                  <td>
                     <p class="listID">
                        <?php echo $row['listID']; ?>
                     </p>
                  </td>
                  <td>
                     <a
                        href="viewMessage.php?messageID=<?php echo $row['messageID']; ?>&parentID=<?php echo $row['parentID']; ?>&receiverID=<?= $row['customerID']; ?>&receiverInnie=<?= $row['customerInnie']; ?>">
                        <?php echo $row['messageTitle']; ?>
                     </a>
                     <p class="subText">Unreplied</p>
                  </td>
                  <td>
                     <p class="messageSentOn">
                        <?php echo date("Y-m-d h-i A", strtotime($row['messageSentOn'])); ?>
                     </p>
                  </td>
               </tr>
            <?php else: ?>
               <tr class="replied">
                  <td>
                     <!-- form to manage post requests -->
                     <form action="" method="post">
                        <!-- hidden listID field. -->
                        <input type="hidden" name="customerID" value="<?= $row['customerID']; ?>" />
                        <input type="hidden" name="messageID" value="<?= $row['messageID']; ?>" />
                     </form>
                  </td>
                  <td>
                     <p class="sentFrom">
                        <?php echo $row['customerInnie']; ?>
                     </p>
                  </td>
                  <td>
                     <p class="listID">
                        <?php echo $row['listID']; ?>
                     </p>
                  </td>
                  <td class="">
                     <a
                        href="viewMessage.php?messageID=<?php echo $row['messageID']; ?>&parentID=<?php echo $row['parentID']; ?>&receiverID=<?= $row['customerID']; ?>&receiverInnie=<?= $row['customerInnie']; ?>">
                        <?php echo $row['messageTitle']; ?>
                     </a>
                  </td>
                  <td>
                     <p class="messageSentOn">
                        <?php echo date("Y-m-d h-i A", strtotime($row['messageSentOn'])); ?>
                     </p>
                  </td>
               </tr>
            <?php endif ?>
         <?php endforeach; ?>
         <!-- END for-loop -->
      </tbody>
   </table>
   <!-- END TABLE -->
</div>
</body>

</html>
<?php include_once '../include/footer.php'; ?>