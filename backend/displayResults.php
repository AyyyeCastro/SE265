<!DOCTYPE html>
<?php
require "../include/header.php";
require '../include/logic/php/php_displayResults.php';
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/displayResults.css">
<div class="container-fluid">
   <div class="container fullVH">

      <?php if ($search_option == 'Products' || $search_option == $selected || $search_option == $selected): ?>
         <form method="get" action="displayResults.php" class="filterContainer">
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
               <div class="col-xs-4 filterBtns">
                  <!-- Search with criteria entered -->
                  <button class="customBtn" type="submit" name="search" value="Search">Apply</button>
                  <a href="displayResults.php"><button type="button" class="customerOtherBtn"
                        onclick="resetFilters()">Reset
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
               <?php if (empty($listArray)): ?>

                  <div class="col-lg-12 displayMsg">
                     No products listed for sale or that match your criteria.
                  </div>
               <?php endif; ?>
               <?php foreach ($listArray as $row): ?>
                  <?php if ($row['isListSold'] != 'YES'): ?>
                     <div class="col-lg-6 content">
                        <input type="hidden" name="p_id" value="<?= $row['listID']; ?>" />
                        <div class="listState">
                           <?= $row['listState']; ?>
                        </div>
                        <a href="productDetails.php?listID=<?= $row['listID']; ?>">
                           <div class="listProdPic"><img src="<?= $row['listProdPic']; ?>"
                                 style="object-fit: contain; object-position: center; width: 330px; height: 230px; background-color: #F6F6F6;">
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
         </div>
         <?php if ($pageCount > 1): ?>
            <div class="container">
               <div class="col-lg-12">
                  <div class="row pageCountCountainer justify-content-center" role="group">
                     <?php for ($i = 1; $i <= $pageCount; $i++): ?>
                        <?php if ($i == $onPage): ?>
                           <button type="button" class="customBtn">
                              <?= $i ?>
                           </button>
                        <?php else: ?>
                           <a href="displayResults.php?page=<?= $i ?>" class="customerOtherBtn"><?= $i ?></a>
                        <?php endif ?>
                     <?php endfor ?>
                  </div>
               <?php endif; ?>
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
                        <td><a href="viewUsers.php?userID=<?= $row['userID']; ?>" style="font-size: 20px;"><?=
                             $row['userInnie']; ?></a></td>
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
   </div>
   </body>

   </html>