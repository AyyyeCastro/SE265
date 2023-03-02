<!DOCTYPE html>
<?php
ob_start();
include_once '../include/header.php';
include_once '../include/functions.php';
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
$catList = $userDatabase->getAllCategories();
$condList = $userDatabase->getAllConditions();

# ----------------#


if (isPostRequest()) {
   $listProdCat = filter_input(INPUT_POST, 'inputProdCat');
   $catList = $userDatabase->getAllCategories();
   $listProdPrice = filter_input(INPUT_POST, 'inputProdPrice');
   $listProdTitle = filter_input(INPUT_POST, 'inputProdTitle');
   $listDesc = filter_input(INPUT_POST, 'inputProdDesc');
   $listCond = filter_input(INPUT_POST, 'inputProdCond');
   $listState = filter_input(INPUT_POST, 'inputProdState');
   $condList = $userDatabase->getAllConditions();


   # -- Profile Pictures -- #
   # -- IMPORTANT!!! -- #
   $userInfo = $userDatabase->getUserDetails($userID);

   #--- Profile Picture Traveling -- #
   $file = $_FILES['inputProdPic'];
   if ($file['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination = '../backend/listingUpload/' . $file['name'];
      move_uploaded_file($file['tmp_name'], $fileDestination);
   }
   $file2 = $_FILES['inputProdPic2'];
   if ($file2['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination2 = '../backend/listingUpload/' . $file2['name'];
      move_uploaded_file($file2['tmp_name'], $fileDestination2);
   }
   $file3 = $_FILES['inputProdPic3'];
   if ($file3['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination3 = '../backend/listingUpload/' . $file3['name'];
      move_uploaded_file($file3['tmp_name'], $fileDestination3);
   }
   $file4 = $_FILES['inputProdPic4'];
   if ($file4['error'] != UPLOAD_ERR_NO_FILE) {
      $fileDestination4 = '../backend/listingUpload/' . $file4['name'];
      move_uploaded_file($file4['tmp_name'], $fileDestination4);
   }
   # ---------------------------------#

   if (
      $userDatabase->postUserListing(
         $userID,
         $listProdCat,
         $listProdPrice,
         $listProdTitle,
         $listDesc,
         $listCond,
         $fileDestination,
         $listState,
         $listPostedOn,
         $fileDestination2,
         $fileDestination3,
         $fileDestination4
      )
   ) {
      header("location: ../backend/viewProfile.php");
   } else {
      $message = "Error posting new listing, please try again.";
   }
}
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/postListing.css">
<div class="fullVH">
   <div class="container postListingContainer">
      <form action="postListing.php" method="post" enctype="multipart/form-data">

         <div>
            <!-- product state. This is a hidden field. Value gathered automatically from user's profile state -->
            <input type="disabled" class="form-control" id="inputProdState" name="inputProdState"
               value="<?php echo $userInfo['userState']; ?>" readonly>
         </div>
         <br>
         <div>
            <select class="form-control" id="inputProdCat" name="inputProdCat" required>
               <option value="" disabled selected>Choose category</option>
               <?php
               foreach ($catList as $category) {
                  $selected = ($category['catGenre'] == $listDetails['listProdCat']) ? 'selected' : '';
                  echo '<option value="' . $category['catGenre'] . '" ' . $selected . '>' . $category['catGenre'] . '</option>';
               }
               ?>
            </select>
         </div>
         <br>
         <div>
            <label for="inputProdCond">Product Condition:</label> <!-- listCondition in the db -->
            <select class="form-control" id="inputProdCond" name="inputProdCond" required>
               <option value="" disabled selected>Choose Condition</option>
               <?php
               foreach ($condList as $condition) {
                  $selected = ($condition['condType'] == $listDetails['listProdCat']) ? 'selected' : '';
                  echo '<option value="' . $condition['condType'] . '" ' . $condition . '>' . $condition['condType'] . '</option>';
               }
               ?>
            </select>
         </div>
         <br>
         <div>
            <label for="inputProdPrice">Product price:</label>
            <input type="text" class="form-control" id="inputProdPrice" name="inputProdPrice" placeholder="9.99"
               pattern="^\d*(\.\d{0,2})?$" title="Numbers only. Up to two decimal places. No commas." required>
         </div>
         <br>
         <div>
            <label for="inputProdTitle">Product Name/Title:</label>
            <input type="text" class="form-control" id="inputProdTitle" name="inputProdTitle" maxlength="120" required>
         </div>
         <br>
         <div>
            <label for="inputProdDesc">Product Description:</label> <!-- listSummary in the db -->
            <textarea id="inputProdDesc" class="form-control" name="inputProdDesc" rows="5"></textarea>
            <script>
               tinymce.init({
                  selector: '#inputProdDesc',
                  height: 200,
                  menubar: false,
                  plugins: [
                     'advlist autolink lists link image charmap print preview anchor',
                     'searchreplace visualblocks code fullscreen',
                     'insertdatetime media table paste code help wordcount'
                  ],
                  toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                  content_css: '//www.tiny.cloud/css/codepen.min.css'
               });
            </script>
         </div>

         <br>
         <div class="row rowCustomFiles">
            <div class="col-sm-12">
               <label for="inputProdPic" class="customFiles"><i class="fa-solid fa-image fa-lg"></i> Insert Photo
                  <input type="file" id="inputProdPic" name="inputProdPic" accept="image/*">
               </label>
               <label for="inputProdPic2" class="customFiles"> +
                  <input type="file" id="inputProdPic2" name="inputProdPic2" accept="image/*">
               </label>
               <label for="inputProdPic3" class="customFiles"> +
                  <input type="file" id="inputProdPic3" name="inputProdPic3" accept="image/*">
               </label>
               <label for="inputProdPic4" class="customFiles"> +
                  <input type="file" id="inputProdPic4" name="inputProdPic4" accept="image/*">
               </label>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-2">
               <img id="prevImg" />
            </div>
            <div class="col-lg-2">
               <img id="prevImg2" />
            </div>
            <div class="col-lg-2">
               <img id="prevImg3" />
            </div>
            <div class="col-lg-2">
               <img id="prevImg4" />
            </div>
         </div>
         <div class="row rowBtnPost">
            <div class="col-sm-12">
               <a href="plugInHome.php" style="padding: 15px;">Cancel</a>
               <input type="submit" class="customBtn" value="Post Listing">
            </div>
         </div>
      </form>
   </div> <!-- main div -->
</div>
<?php include_once '../include/footer.php'; ?>
</body>

</html>
<script>
   document.getElementById('inputProdPic').onchange = function () {
      var src = URL.createObjectURL(this.files[0])
      document.getElementById('prevImg').src = src
      document.getElementById('prevImg').style = "height: 150px; width: 150px;"
   }
   document.getElementById('inputProdPic2').onchange = function () {
      var src = URL.createObjectURL(this.files[0])
      document.getElementById('prevImg2').src = src
      document.getElementById('prevImg2').style = "height: 150px; width: 150px;"
   }
   document.getElementById('inputProdPic3').onchange = function () {
      var src = URL.createObjectURL(this.files[0])
      document.getElementById('prevImg3').src = src
      document.getElementById('prevImg3').style = "height: 150px; width: 150px;"
   }
   document.getElementById('inputProdPic4').onchange = function () {
      var src = URL.createObjectURL(this.files[0])
      document.getElementById('prevImg4').src = src
      document.getElementById('prevImg4').style = "height: 150px; width: 150px;"
   }
</script>