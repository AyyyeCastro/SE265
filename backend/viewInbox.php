<!DOCTYPE html>
<?php
require '../include/header.php';
require '../include/logic/php/php_viewInbox.php';
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/viewInbox.css">
<div class="fullVH">
   <div class="container inboxContainer">
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
                  <tr class="unreplied <?php if (strpos($row['messageTitle'], 'RE | SALE CONFIRMED:') !== false) echo 'completedSale'; ?>">
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
                  <tr class="replied <?php if (strpos($row['messageTitle'], 'RE | SALE CONFIRMED:') !== false) echo 'completedSale'; ?>"">
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
                        <a href="viewMessage.php?messageID=<?php echo $row['messageID']; ?>&parentID=<?php echo $row['parentID']; ?>&receiverID=<?= $row['customerID']; ?>&receiverInnie=<?= $row['customerInnie']; ?>" class="customLink">
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
</div>
</body>

</html>