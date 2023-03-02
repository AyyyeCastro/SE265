<!DOCTYPE html>
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

// set the default avie url.
$defaultAvie = "../include/default-avie/default-avie.jpg";

// declare arrays
$selected = "";
$search_option = "";
$userArray = [];
$listProdTitle = "";
$userInnie = "";
$prodTitle = "";
$listState = "";
$listProdTitle = "";
$listProdCat = "";
$listCond = "";
$listDesc = "";

/* idk why i had this */
// $userID = $_SESSION['userID'];
// $userInfo = $userDatabase->getUserDetails($userID);


// Fill the listings before criteria
$userArray = $userDatabase->findUserByInnie($userInnie);
$listArray = $userDatabase->findListAdvanced($listProdTitle, $listDesc, $listProdCat, $listCond, $listState);
// Get all of the category genres from the database. Fills dropdown list.
$catList = $userDatabase->getAllCategories();
// Get all of the condition types from the database. Fills dropdown list.
$condList = $userDatabase->getAllConditions();
// Get all of the States from the database. Fills dropdown list.
$stateList = $userDatabase->getAllStates();


// IMPORTANT
// Why Get request? 
// It stores the results of the user's search into the URL. 
// This allows the user to copy the URL, and share it to other sources, with the same results showing.
{
   // if they clicked the search button ->
   if (isset($_GET["search"])) {
      $search_option = filter_input(INPUT_GET, 'search_option');
      // if the user selected to search for sellers
      if ($search_option == 'Products' || $search_option == $selected || $search_option == $selected) {
         // declare the variables to nothing first...
         $listProdTitle = "";
         $listDesc = "";
         //... have the user's input (from form below) allign with the declared variables. 
         $listProdTitle = $_GET['inputName'];
         $listDesc = $_GET['inputName'];
         $listProdCat = filter_input(INPUT_GET, 'listProdCat');
         $listCond = filter_input(INPUT_GET, 'listCond');
         $listState = filter_input(INPUT_GET, 'listState');
         // have the array (declared above) store the info, and send it to the findOneCollection function.
         $listArray = $userDatabase->findListAdvanced($listProdTitle, $listDesc, $listProdCat, $listCond, $listState);
      }
      if ($search_option == 'Sellers') {
         // declare the variables to nothing first...
         $userInnie = "";
         //... have the user's input (from form below) allign with the declared variables. 
         $userInnie = $_GET['inputName'];
         // have the array (declared above) store the info, and send it to the findOneCollection function.
         $userArray = $userDatabase->findUserByInnie($userInnie);
      }
   } else {
      //Otherwise gather all records.
      $listArray = $userDatabase->getAllListings();
   }
}
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/displayResults.css">
<div class="container">
   <?php if ($search_option == 'Products' || $search_option == $selected || $search_option == $selected): ?>
      <form method="get" action="displayResults.php">
         <div class="row">
            <input type="hidden" name="inputName" value="<?php echo $listProdTitle; ?>">

            <div class="col-sm-3">
               <select class="form-control" id="listProdCat" name="listProdCat">
                  <?php
                  $selectedCat = (isset($_GET["listProdCat"])) ? $_GET["listProdCat"] : '';
                  echo '<option value="" disabled ' . (($selectedCat == '') ? 'selected' : '') . '>Choose Category</option>';
                  foreach ($catList as $category) {
                     $selected = ($category['catGenre'] == $selectedCat) ? 'selected' : '';
                     echo '<option value="' . $category['catGenre'] . '" ' . $selected . '>' . $category['catGenre'] . '</option>';
                  }
                  ?>
               </select>
            </div>

            <div class="col-sm-3">
               <select class="form-control" id="listCond" name="listCond">
                  <?php
                  $selectedCond = (isset($_GET["listCond"])) ? $_GET["listCond"] : '';
                  echo '<option value="" disabled ' . (($selectedCond == '') ? 'selected' : '') . '>Choose Condition</option>';
                  foreach ($condList as $condition) {
                     $selected = ($condition['condType'] == $selectedCond) ? 'selected' : '';
                     echo '<option value="' . $condition['condType'] . '" ' . $selected . '>' . $condition['condType'] . '</option>';
                  }
                  ?>
               </select>
            </div>



            <div class="col-sm-3">
               <select class="form-control" id="listState" name="listState">
                  <?php
                  $selectedState = (isset($_GET["listState"])) ? $_GET["listState"] : $userInfo['userState'];
                  echo '<option value="" ' . (($selectedState == '') ? 'selected' : '') . '>All States</option>';
                  foreach ($stateList as $states) {
                     $selected = ($states['stateName'] == $selectedState) ? 'selected' : '';
                     echo '<option value="' . $states['stateName'] . '" ' . $selected . '>' . $states['stateName'] . '</option>';
                  }
                  ?>
               </select>
            </div>
         </div>

         <div class="row">
            <!-- Buttons -->
            <div class="col-sm-4 filterBtns">
               <!-- Search with criteria entered -->
               <button class="customBtn" type="submit" name="search" value="Search">Apply</button>
               <a href="displayResults.php"><button type="button" class="customerOtherBtn" onclick="resetFilters()">Reset
                     Filter</button></a>
            </div>
         </div>
      </form>


      <div class="row resultFor">
         <div class="col-md-12">
            <?php if (isGetRequest()) {
               if (isset($_GET["search"])) {
                  echo 'Results for: ' . $listProdCat . ' ' . $listCond . ' ' . '<b>' . $listProdTitle . '</b>' . $listState;
               }
            } ?>
            </p>
         </div>


         <div class="row">
            <?php foreach ($listArray as $row): ?>
               <?php if ($row['isListSold'] != 'YES'): ?>
                  <div class="col-sm content">
                     <input type="hidden" name="p_id" value="<?= $row['listID']; ?>" />
                     <div class="listState">
                        <?= $row['listState']; ?>
                     </div>
                     <a href="productDetails.php?listID=<?= $row['listID']; ?>">
                        <div class="listProdPic"><img src="<?= $row['listProdPic']; ?>"
                              style="object-fit: contain; object-position: center; width: 230px; height: 230px; background-color: #F6F6F6;">
                        </div>
                        <div class="listProdTitle">
                           <?= $row['listProdTitle']; ?>
                        </div>
                     </a>
                     <div class="listProdCat">
                        <?= $row['listProdCat']; ?>
                     </div>
                     <div class="listProdPrice">$
                        <?= $row['listProdPrice']; ?>
                     </div>
                     <div class="listCond">
                        <?= $row['listCond']; ?>
                     </div>
                  </div>
               <?php endif ?>
            <?php endforeach; ?>
         </div>
      <?php endif; ?>

      <?php if ($search_option == 'Sellers'): ?>
         <div class="row resultFor">
            <p>
               <?php if (isPostRequest()) {
                  if (isset($_POST["search"])) {
                     echo 'Results for: ' . '<b>' . $userInnie . '</b>';
                  }
               } ?>
            </p>
         </div>
         <table class="table table-hover">

            <tbody>
               <!-- For every value stored in the array we declared in the PHP section -->
               <?php foreach ($userArray as $row): ?>
                  <tr>
                     <td>
                        <form action="" method="post">
                           <input type="hidden" name="p_id" value="<?= $row['userID']; ?>" />
                        </form>
                     </td>
                     <!-- Display it's value, AND IMPORTANTLY set the links to lead to the user's profile according by userID -->
                     <td><img
                           src="<?php echo (is_null($row['userPic']) || empty($row['userPic'])) ? $defaultAvie : $row['userPic']; ?>"
                           class="ProfilePics rounded-circle" alt="profile picture" style="border: solid 2px blue;"></td>
                     <td><a href="viewUsers.php?userID=<?= $row['userID']; ?>" style="font-size: 20px;"><?= $row['userInnie']; ?></a></td>
                  </tr>
               <?php endforeach; ?>
               <!-- END for-loop -->
            </tbody>
         </table>
      <?php endif; ?>
      <!-- END for-loop -->
      </tbody>
      </table>
   </div>
   </body>

   </html>

   <!-- Why does this .php page have closing tags for body and html? 
This is because the metadata and starting divs were created in header.php ("include" folder), and referenced with PHP above. -->