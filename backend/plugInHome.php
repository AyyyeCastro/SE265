<!DOCTYPE html>
<?php
include_once "../model/userController.php";
include_once "../include/functions.php";
include_once "../include/header.php";
?>
<link rel="stylesheet" href="../include/stylesheets/global.css">
<link rel="stylesheet" href="../include/stylesheets/plugInHome.css">
<div class="container-fluid row1container-fluid">
   <div class="container">
      <div class="col-12">
         <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
               <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
               <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">
               <a
                     href="http://localhost/SE266/REPO-Folder/SE265/backend/displayResults.php?search_option=Products&inputName=Moodswings+In+to+Order&search=Search">
                     <img src="../include/slideshow/shopMusic.png" alt="First slide">
                  </a>
               </div>
               <div class="carousel-item">
                  <a
                     href="http://localhost/SE266/REPO-Folder/SE265/backend/displayResults.php?search_option=Products&inputName=JUJU&search=Search">
                     <img src="../include/slideshow/shopManga.png" alt="Second slide">
                  </a>
               </div>
               <div class="carousel-item">
                  <a
                     href="#">
                     <img src="../include/slideshow/shopAcc.png" alt="Third slide">
                  </a>
               </div>
            </div>
            <a class="carousel-control-prev prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next next" href="#carouselExampleIndicators" role="button" data-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="sr-only">Next</span>
            </a>
         </div>
      </div>
   </div>
</div>

<div class="container-fluid row2Container-fluid">
   <div class="container">
      <div class="row row2">
         <div class="col-md-3">
            <div class="col-md-12 cat1">
               <a href="displayResults.php?inputName=&listProdCat=Home+Decoration&listState=&search=Search">
                  <img src="../include/categories/decor.jpg" alt="homeDecor.jpg" id="catFeatureImg" class="row2Imgs">
                  <p class="row2Titles">Home Decor</p>
               </a>
            </div>
         </div>
         <div class="col-md-3">
            <div class="col-md-12 cat2">
               <a href="displayResults.php?inputName=&listProdCat=Album+CDs&listState=&search=Search">
                  <img src="../include/categories/albums.jpg" alt="albums.jpg" id="catFeatureImg" class="row2Imgs">
                  <p class="row2Titles">Albums</p>
               </a>
            </div>
         </div>
         <div class="col-md-3">
            <div class="col-md-12 cat3">
               <a href="displayResults.php?inputName=&listProdCat=Culinary+Tools&listState=&search=Search">
                  <img src="../include/categories/culinary.jpg" alt="culinary.jpg" id="catFeatureImg" class="row2Imgs">
                  <p class="row2Titles">Culinary Tools</p>
               </a>
            </div>
         </div>
         <div class="col-md-3">
            <div class="col-md-12 cat4">
               <a href="displayResults.php?inputName=&listProdCat=Clothing&listState=&search=Search">
                  <img src="../include/categories/clothes.jpg" alt="clothes.jpg" id="catFeatureImg" class="row2Imgs">
                  <p class="row2Titles">Clothes</p>
               </a>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="container-fluid">
   <div class="container">
      <div class="row row3">
         <div class="col-md-6 outerCat5">
            <div class="col-md-12 cat5">
               <a href="displayResults.php?inputName=&listProdCat=Consoles&listState=&search=Playstation">
                  <img src="../include/categories/playstation5.jpg" alt="consoles.jpg" id="catFeatureImg"
                     class="row3Imgs">
                  <p class="row3Titles">Playstation 5</p>
               </a>
            </div>
         </div>
         <div class="col-md-3 outerCat6">
            <div class="col-md-12 cat6">
               <a href="displayResults.php?inputName=&listProdCat=Artwork&listState=&search=Search">
                  <img src="../include/categories/art1.jpg" alt="artwork.jpg" id="catFeatureImg" class="row3Imgs">
                  <p class="row3Titles">Artwork</p>
               </a>
            </div>
         </div>
         <div class="col-md-3 outerCat7">
            <div class="col-md-12 cat7">
               <a href="viewUsers.php?userID=58">
                  <img src="../include/categories/highground.png" alt="kellyStore.png" id="catFeatureImg"
                     class="row3Imgs">
                  <p class="row3Titles">Feature: HiGround</p>
               </a>
            </div>
         </div>
      </div>
   </div>
   <?php include_once '../include/footer.php'; ?>
</div>
</body>

</html>




<!-- Why does this .php page have closing tags for body and html? 
This is because the metadata and starting divs were created in header.php ("include" folder), and referenced with PHP above. -->