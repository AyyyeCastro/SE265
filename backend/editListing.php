<!DOCTYPE html>
<?php
ob_start();
require '../include/header.php';
require '../include/logic/php/php_editListing.php';
$modCheck = $userDatabase->getUserDetails($userID);


if ($_SESSION['userID'] == $listDetails['userID'] || $modCheck['isModerator']== 'YES'):
?>

<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/editListing.css">
<div class="container-fluid">
   <div class="container editListingContainer">
      <form action="editListing.php" method="post" enctype="multipart/form-data">
         <input type="hidden" name="visitID" value="<?php echo $listDetails['userID']; ?>">

         <div>
            <input type="hidden" id="listID" name="listID" value="<?= $listDetails['listID']; ?>" />
         </div>

         <div class="row displayContent">
            <div class="col-md-12">
               <!-- product state. This is a hidden field. Value gathered automatically from user's profile state -->
               <input type="disabled" class="form-control" id="inputProdState" name="inputProdState"
                  value="<?php echo $userInfo['userState']; ?>" readonly>
            </div>
         </div>

         <div class="row displayContent">
            <div class="col-md-12">
               <label for="inputProdCat">Product Category:</label>
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
         </div>

         <div class="row displayContent">
            <div class="col-md-12">
               <label for="inputProdPrice">Product price:</label>
               <input type="text" class="form-control" id="inputProdPrice" name="inputProdPrice"
                  value="<?php echo $listDetails['listProdPrice']; ?>" required>
            </div>
         </div>

         <div class="row displayContent">
            <div class="col-md-12">
               <label for="inputProdTitle">Product Name/Title:</label>
               <input type="text" class="form-control" id="inputProdTitle" name="inputProdTitle"
                  value="<?php echo $listDetails['listProdTitle']; ?>" required>
            </div>
         </div>

         <div class="row displayContent">
            <div class="col-md-12">
               <label for="inputProdDesc">Product Description:</label>
               <textarea id="inputProdDesc" class="form-control" name="inputProdDesc" rows="5"
                  required><?php echo $listDetails['listDesc']; ?></textarea>
               <script>
                  tinymce.init({
                  selector: '#inputProdDesc',
                  plugins: 'quickbars table image link lists media autoresize help',
                  toolbar: 'undo redo | formatselect | bold italic | alignleft aligncentre alignright alignjustify | indent outdent | bullist numlist',
                  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                  });
                  tinymce.init({
                     selector: '#inputProdDesc',
                     height: 200,
                     menubar: false,
                     plugins: [
                        'quickbars, advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount',
                        'autoresize','emoticons','fullscreen','hr', 'image', 'preview'
                     ],quickbars_image_toolbar: true,
                     toolbar: 'formatselect  undo redo | formatselect | bold italic backcolor image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent hr | removeformat | fullscreen preview | emoticons table',
                     content_css: '//www.tiny.cloud/css/codepen.min.css'
                  });
               </script>
            </div>
         </div>

         <div class="row displayContent">
            <div class="col-md-12">
               <label for="inputProdCond">Product Condition:</label>
               <select class="form-control" id="inputProdCond" name="inputProdCond" required>
                  <option value="" disabled>Choose category</option>
                  <?php
                  foreach ($condList as $condition) {
                     $selected = ($condition['condType'] == $listDetails['listCond']) ? 'selected' : '';
                     echo '<option value="' . $condition['condType'] . '" ' . $selected . '>' . $condition['condType'] . '</option>';
                  }
                  ?>
               </select>
            </div>
         </div>
         <div class="row rowOfBtns">
            <div class="col-md-12 text-right postBtns">
               <a href="viewProfile.php" class=""
                  onclick="return confirm('This will remove all progress. Leave page?')">Cancel</a>
               <input type="submit" class="customBtn" name="updateBtn" value="Update" />
            </div>
         </div>
      </form>
   </div> <!-- main div -->
</div>
</body>

</html>
<?php else: header("location: ../backend/viewProfile.php"); ?>
<?php endif ?>
