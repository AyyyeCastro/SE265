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

<style>
   .container-fluid {
      height: 100vh;
   }

   .inboxContainer {
      margin-top: 15px;
      border-radius: 15px;
      border: 1px solid #E5E5E5;
      box-shadow: 5px 10px 10px #E5E5E5;
      padding: 15px;
   }

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

   .subText {
      color: #506d90;
      font-size: 12px;
      margin-top: 2px;
   }
</style>

<div class="container-fluid">
   <div class="container inboxContainer">
      <!-- BEGIN TABLE -->
      <table class="table table-hover" id="userListLog">
         <thead>
            <tr>
               <th>Date Sold</th>
               <th>Seller</th>
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
                  <a href="viewUsers.php?userID=<?= $row['customerID']; ?>">
                     <p class="sentFrom">
                        <?php echo $row['sellerInnie']; ?>
                     </p>
                  </a>
                  </td>
                  <td>
                     <a href="productDetails.php?listID=<?= $row['listID']; ?>">
                        <p class="sentFrom">
                           <?php echo $row['listProdTitle']; ?>
                        </p>
                     </a>
                  </td>
                  <td>
                     <p class="sentFrom">
                        <?php echo $row['orderID']; ?>
                     </p>
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
<?php include_once '../include/footer.php'; ?>