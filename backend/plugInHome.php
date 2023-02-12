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

?>
<style>
   body {
      background: #E3E6E6;
   }

   .container-fluid {
      background-color: #F8F8F8;
      padding: 35px;
   }

   .container {
      padding-bottom: 15px;
      min-width: 75%;
   }


   .bg3 {
      margin-top: 15px;
      height: 500px;
   }

   .carousel-item img {
      height: 100%;
      width: 100%;
      object-fit: contain;
      /* Do not scale the image */
      object-position: center;
      /* Center the image within the element */
      border-radius: 10px;
   }

   .prev,
   .next {}

   .carousel-control-prev-icon {
      height: 50px;
      width: 50px;
   }

   .carousel-control-next-icon {
      height: 50px;
      width: 50px;
   }

   .row2 {
      margin-top: 15px;
      height: 80%;
   }

   .row3 {
      margin-top: 15px;
      border: 2px solid green;
   }
   .container-fluid{
      border: 6px solid purple;
      max-height: 40%;
      min-width: 100%;
      background-color: #F8F8F8;
      padding: 35px;
   }

   .row2Titles {
      font-size: 18px;
      font-weight: bold;
   }

   .cat1 {
      padding: 25px;
      background-color: #F8F8F8;
      height: 100%;
      border-radius: 25px;
   }

   .cat2 {
      padding: 25px;
      background-color: #F8F8F8;
      height: 100%;
      border-radius: 25px;
      margin-left: 15px;
   }

   .cat3 {
      padding: 25px;
      background-color: #F8F8F8;
      height: 100%;
      border-radius: 25px;
      margin-left: 15px;
   }

   .cat4 {
      padding: 25px;
      background-color: #F8F8F8;
      height: 100%;
      border-radius: 25px;
      margin-left: 15px;
   }

   .cat5 {
      border: 1px solid red;
      padding: 25px;
      background-color: #F8F8F8;
      border-radius: 25px;
   }

   .cat6 {
      border: 1px solid red;
      padding: 25px;
      background-color: #F8F8F8;
      height: 100%;
      border-radius: 25px;
   }

   .cat7 {
      border: 1px solid red;
      padding: 25px;
      background-color: #F8F8F8;
      height: 100%;
      border-radius: 25px;
   }


</style>

<div class="container-fluid">
   <div class="col-12 slideShow">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
         <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
         </ol>
         <div class="carousel-inner">
            <div class="carousel-item active">
               <a href="#">
                  <img src="../include/slideshow/shopAcc.png" alt="First slide">
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
                  href="http://localhost/SE266/REPO-Folder/SE265/backend/displayResults.php?search_option=Products&inputName=Moodswings+In+to+Order&search=Search">
                  <img src="../include/slideshow/shopMusic.png" alt="Third slide">
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

<div class="container">
   <div class="row row2">
      <div class="col cat1" style="box-sizing: border-box;">
         <p class="row2Titles">Home Decor</p>
         <img src="../include/categories/decor.jpg" alt="homeDecor.jpg" id="catFeatureImg"
            style="object-fit: contain; object-position: center; width: 100%; height: 90%;">
      </div>
      <div class="col cat2" style="box-sizing: border-box;">
         <p class="row2Titles">Albums</p>
         <img src="../include/categories/albums.jpg" alt="albums.jpg" id="catFeatureImg"
            style="object-fit: contain; object-position: center; width: 100%; height: 90%;">
      </div>
      <div class="col cat3" style="box-sizing: border-box;">
         <p class="row2Titles">Culinary Tools</p>
         <img src="../include/categories/culinary.jpg" alt="culinary.jpg" id="catFeatureImg"
            style="object-fit: contain; object-position: center; width: 100%; height: 90%;">
      </div>
      <div class="col cat4" style="box-sizing: border-box;">
         <p class="row2Titles">Clothes</p>
         <img src="../include/categories/clothes.jpg" alt="clothes.jpg" id="catFeatureImg"
            style="object-fit: contain; object-position: center; width: 100%; height: 90%;">
      </div>
   </div>
</div>

<div class="container-fluid">
   <div class="row row3">
      <div class="col-sm-6 cat5">
         <p class="row2Titles">Kids</p>
         <img src="../include/categories/kids.jpg" alt="homeDecor.jpg" id="catFeatureImg"
            style="object-fit: contain; object-position: center; width: 100%; height: 90%;">
      </div>
      <div class="col-sm-3  cat6">
         <p class="row2Titles">Artwork</p>
         <img src="../include/categories/canvas-paint.jpg" alt="culinary.jpg" id="catFeatureImg"
            style="object-fit: contain; object-position: center; width: 100%; height: 90%;">
      </div>
      <div class="col-sm-3 cat7">
         <p class="row2Titles">Feature: Kelico's shop</p>
         <img src="../include/categories/fashion.png" alt="fashion.png" id="catFeatureImg"
            style="object-fit: contain; object-position: center; width: 100%; height: 90%;">
      </div>
   </div>
</div>



</body>

</html>
<?php include_once '../include/footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
   integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
   integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
   integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>




<!-- Why does this .php page have closing tags for body and html? 
This is because the metadata and starting divs were created in header.php ("include" folder), and referenced with PHP above. -->