<!DOCTYPE html>
<?php
ob_start();
require '../include/header.php';
require '../include/logic/php/php_viewPurchaseHistory.php';
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/viewPurchaseHistory.css">
<div class="container-fluid fullVH">
   <div class="container inboxContainer">
      <!-- BEGIN TABLE -->
      <table class="table table-hover" id="userListLog">
         <thead>
            <tr>
               <th>Bought On</th>
               <th>Product</th> <!-- requested title -->
               <th>Order ID</th> <!-- time sent -->
            </tr>
         </thead>
         <tbody>
            <!-- For every value stored in the array we decl2ared in the PHP section -->
            <?php foreach ($listDetails as $row): ?>
               <tr>
                  <td>
                     <p class="sentFrom">
                        <?php echo $row['timeListsold']; ?>
                     </p>
                  </td>
                  <td>
                     <p class="sentFrom">
                        <?php echo $row['listProdTitle']; ?>
                     </p>
                  </td>
                  <td>
                     <a href="productDetails.php?listID=<?= $row['listID']; ?>&orderID=<?php echo $row['orderID']; ?>">
                        <p class="customLink">
                           <?php echo $row['orderID']; ?>
                        </p>
                     </a>
                  </td>
               </tr>
            <?php endforeach; ?>
            <!-- END for-loop -->
         </tbody>
      </table>
      <!-- END TABLE -->
   </div>
</div>
</body>
</html>