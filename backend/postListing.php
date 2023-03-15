<!DOCTYPE html>
<?php
ob_start();
require '../include/header.php';
require '../include/logic/php/php_postListing.php';
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
            <textarea id="inputProdDesc" class="form-control" name="inputProdDesc" rows="5" placeholder="Type something about your item. You can also include extra descriptionary images."></textarea>
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

         <br>
         <div class="row rowCustomFiles">
            <div class="col-sm-12">
            <small class="form-text text-muted">First photo is required.</small>
               <label for="sendPic" class="customFiles" id="customFile1"><i class="fa-solid fa-image fa-lg"></i>
                  Insert Photo
                  <input type="file" id="sendPic" name="sendPic" accept="image/*" required>
               </label>
               <label for="sendPic2" class="customFiles" id="customFile2"> +
                  <input type="file" id="sendPic2" name="sendPic2" accept="image/*">
               </label>
               <label for="sendPic3" class="customFiles" id="customFile3"> +
                  <input type="file" id="sendPic3" name="sendPic3" accept="image/*">
               </label>
               <label for="sendPic4" class="customFiles" id="customFile4"> +
                  <input type="file" id="sendPic4" name="sendPic4" accept="image/*">
               </label>
            </div>
         </div>
         <div class="row">
            <div class="col-sm-3 col-md-4 col-lg-3">
               <div class="preview-container">
                  <img id="prevImg" />
                  <span class="remove-btn" id="removeBtn1"><i class="fa-regular fa-square-minus"></i></span>
               </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
               <div class="preview-container">
                  <img id="prevImg2" />
                  <span class="remove-btn" id="removeBtn2"><i class="fa-regular fa-square-minus"></i></span>
               </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
               <div class="preview-container">
                  <img id="prevImg3" />
                  <span class="remove-btn" id="removeBtn3"><i class="fa-regular fa-square-minus"></i></span>
               </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
               <div class="preview-container">
                  <img id="prevImg4" />
                  <span class="remove-btn" id="removeBtn4"><i class="fa-regular fa-square-minus"></i></span>
               </div>
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
</body>

</html>
<script src="../include/logic/JS/js_photoManagement.js"></script>