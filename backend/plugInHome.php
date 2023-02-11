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
   .bg1 {
      background-color: white;
      height: 50vh;
      padding: 10px;
   }

   .bg2 {
      background-color: gray;
      height: 25vh;
   }

   .bg3 {
      background-color: white;
      height: 25vh;
   }

   .carousel-item img {
      height: 100%;
      width: 100%;
      object-fit: contain;
      /* Do not scale the image */
      object-position: center;
      /* Center the image within the element */
      background-color: #ededed;
      padding: 15px;
   }

   .prev,
   .next {
      background-color: #ededed;
      opacity: 15%;
   }
   }
</style>

<div class="container-fluid bg1">
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

<div class="container-fluid bg2">
</div>
<div class="container-fluid bg3">
</div>


</body>

</html>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
   integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
   integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
   integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>




<!-- Why does this .php page have closing tags for body and html? 
This is because the metadata and starting divs were created in header.php ("include" folder), and referenced with PHP above. -->