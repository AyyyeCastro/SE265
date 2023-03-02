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
$listDetails = $userDatabase->getPurchaseHistory($userID);
/* maybe bread crumbs.. */
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