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
      background-color: red;
   }

   .container-fluid {
      background-color: #F8F8F8;
      padding: 35px;
   }

   .container {
      min-width: 75%;
      padding-bottom: 15px;
   }

   .row1container-fluid {
      margin-top: -1px;
   }

   .row2Container-fluid {
      background-color: #E3E6E6;
   }
   .row4Container-fluid {
      background-color: #E3E6E6;
   }


   .carousel-item img {
      max-height: 650px;
      width: 100%;
      object-fit: cover;
      /* Do not scale the image */
      object-position: center;
      /* Center the image within the element */
      border-radius: 15px;
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

   .row2Titles {
      margin-top: 15px;
      min-width: 200px;
      font-size: 18px;
      font-weight: bold;
   }

   .row3Titles {
      margin-top: 15px;
      min-width: 200px;
      font-size: 18px;
      font-weight: bold;
   }

   .row4Titles {
      min-width: 200px;
      font-size: 18px;
      font-weight: bold;
   }

   .row2Imgs {
      object-fit: contain;
      object-position: center;
      width: 100%;
      height: 90%;
   }

   .row3Imgs {
      object-fit: cover;
      object-position: center;
      width: 100%;
      height: 90%;
   }

   .row4Imgs {
      object-fit: cover;
      object-position: center;
      width: 100%;
      height: 100%;
      border-radius: 15px;
   }

   .cat1 {
      margin-top: 15px;
      padding: 25px;
      background-color: #F8F8F8;
      border-radius: 25px;
   }

   .cat2 {
      margin-top: 15px;
      padding: 25px;
      background-color: #F8F8F8;
      border-radius: 25px;

   }

   .cat3 {
      margin-top: 15px;
      padding: 25px;
      background-color: #F8F8F8;
      border-radius: 25px;

   }

   .cat4 {
      margin-top: 15px;
      padding: 25px;
      background-color: #F8F8F8;
      border-radius: 25px;

   }

   .cat5 {
      height: 100%;
      padding: 25px;
      border-radius: 25px;
   }

   .outerCat6 {}

   .outerCat7 {}

   .cat6 {
      height: 100%;
      padding: 25px;
      border-radius: 25px;
   }

   .cat7 {
      height: 100%;
      padding: 25px;
      border-radius: 25px;
   }

   .cat8 {
      height: 650px;
      padding: 25px;
      border-radius: 25px;
      background-color: #F8F8F8;
   }

   footer {
      border-top: 1px solid white;
   }

   .higroundLogo {
      color: #FFA14A;
      width: 250px;
      position: absolute;
      margin-left: 45px;
      top: 465px;
      left: 0;
      pointer-events: all;
   }
   .featuredBtnOverlay{
      border-radius: 10px;
      background-color: #FFA14A;
      color: white;
      width: 240px;
      position: absolute;
      top: 510px;
      left: 45px;
      pointer-events: all;

   }
   .featuredBtnOverlay:hover{
      background-color: #F8F8F8;
      color: orange;
   }
</style>

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
               <a href="viewUsers.php?userID=14">
                  <img src="../include/categories/kellyStore.jpg" alt="kellyStore.png" id="catFeatureImg"
                     class="row3Imgs">
                  <p class="row3Titles">Feature: Kelico's shop</p>
               </a>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="container-fluid row4Container-fluid">
   <div class="container">
      <div class="row row4">
         <div class="col-md-12 cat8">
            <a href="viewUsers.php?userID=58">
               <img src="../include/categories/highground.png" alt="hiGround.jpg" id="catFeatureImg" class="row4Imgs">
               <!-- This logo is a direct copy from their website... Any and all rights belong to them.
                        They have a unique path to EACH LETTER in their logo... What... -->
               <svg class="higroundLogo">
                  <path
                     d="M9.44284 21.6829L11.6029 17.6643C11.8281 17.2451 11.2884 16.8354 10.9341 17.1573L5.48254 22.0953C5.04586 22.4996 4.36201 22.7362 3.63696 22.7362H1.14048C0.252026 22.7362 -0.293133 22.0601 0.166888 21.5328L7.15646 13.5173L14.2243 5.41252C14.6665 4.90546 15.7252 4.90546 16.1674 5.41252L19.9862 9.69341C20.1895 9.92192 19.7803 10.1734 19.4795 10.0058L18.6062 9.51763C18.1626 9.27019 17.7479 8.95243 17.2536 8.80911C16.7373 8.65902 16.1042 8.87266 16.1056 9.49735C16.1056 9.78265 16.269 10.0328 16.394 10.2789C16.523 10.5331 16.6466 10.7886 16.7771 11.0415C17.1561 11.7771 17.5378 12.5126 17.9059 13.255C18.1791 13.8012 18.4524 14.3475 18.7257 14.8938C18.9028 15.2467 19.3038 15.4306 19.6924 15.3386C19.9272 15.2832 20.1236 15.1466 20.2238 14.9289C20.3982 14.5503 20.6687 14.2907 21.1123 14.4732L21.7069 14.7545C22.0007 14.8938 22.4044 14.814 22.55 14.5882L22.8617 14.027C22.9661 13.8648 23.2888 13.8499 23.422 14.0027L30.2234 21.5341C30.6835 22.0628 30.1369 22.7376 29.2498 22.7376H26.6449C26.3387 22.7376 26.0379 22.6672 25.7633 22.5334L21.3265 20.3564C21.0477 20.2199 20.7223 20.4308 20.7415 20.7377L20.8184 21.9844C20.8445 22.3955 20.3721 22.7376 19.7803 22.7376H10.4782C9.69688 22.7376 9.15996 22.1913 9.44284 21.6842V21.6829Z"
                     fill="currentColor"></path>
                  <path
                     d="M11.401 2.43911L12.4336 2.7785C12.9637 2.95293 12.9074 3.70742 12.3581 3.80343L11.5822 3.93999C11.0824 4.02788 10.6842 4.39702 10.5647 4.88244L10.3381 5.80325C10.2022 6.35357 9.40571 6.34952 9.27663 5.79649L9.06653 4.89731C8.95118 4.40378 8.54746 4.02653 8.04212 3.93864L7.25803 3.80207C6.706 3.70607 6.65107 2.94887 7.1825 2.7758L8.22064 2.43911C8.62985 2.3066 8.94431 1.97938 9.05692 1.56833L9.40022 0.305426C9.51007 -0.0988652 10.0923 -0.102922 10.209 0.300018L10.5784 1.58591C10.6938 1.98614 11.0027 2.30525 11.4037 2.43776L11.401 2.43911Z"
                     fill="currentColor"></path>
                  <path
                     d="M38.3364 5.02173H46.3326V9.22555H54.5786V5.02173H62.5747V22.7362H54.5786V12.4234H46.3326V22.7362H38.3364V5.02173Z"
                     fill="currentColor"></path>
                  <path d="M64.4585 5.02173H72.4038V22.7362H64.4585V5.02173Z" fill="currentColor"></path>
                  <path
                     d="M79.473 21.9372C77.6577 21.1583 76.2378 20.0712 75.2134 18.6771C74.189 17.2831 73.6768 15.6835 73.6768 13.8797C73.6768 12.076 74.2343 10.4764 75.3507 9.08233C76.4671 7.68827 78.0161 6.60114 79.9976 5.82231C81.9791 5.04347 84.2202 4.65405 86.7194 4.65405C88.5183 4.65405 90.2087 4.9042 91.792 5.40449C93.3739 5.90479 94.7196 6.61061 95.8278 7.5206C96.936 8.43059 97.6899 9.48527 98.0895 10.6819L90.6193 11.6663C90.4696 11.3053 90.2114 11.0064 89.8448 10.7685C89.4782 10.5305 89.0291 10.3547 88.4949 10.2398C87.9621 10.1248 87.362 10.068 86.696 10.068C85.7293 10.068 84.8628 10.2235 84.098 10.5359C83.3317 10.8482 82.7357 11.2904 82.3114 11.865C81.8871 12.4397 81.6743 13.1117 81.6743 13.8824C81.6743 14.6532 81.9283 15.3265 82.4364 15.8998C82.9445 16.4745 83.6476 16.9167 84.5484 17.229C85.4478 17.5413 86.4722 17.6968 87.6216 17.6968C88.5046 17.6968 89.2873 17.6144 89.9698 17.4508C90.6522 17.2871 91.207 17.0492 91.6313 16.7368C92.0556 16.4258 92.3179 16.0486 92.4182 15.6051H84.422V12.4073H100.114V22.7403H93.8669L93.5922 20.0834C92.6928 21.1002 91.5888 21.8587 90.2815 22.359C88.9742 22.8593 87.4293 23.1095 85.6469 23.1095C83.3482 23.1095 81.2911 22.7201 79.4758 21.9412L79.473 21.9372Z"
                     fill="currentColor"></path>
                  <path
                     d="M132.502 21.9856C130.461 21.2392 128.882 20.1697 127.767 18.7743C126.651 17.3802 126.093 15.7482 126.093 13.8782C126.093 12.0081 126.651 10.3761 127.767 8.98204C128.884 7.58798 130.461 6.51844 132.502 5.7707C134.543 5.02431 136.903 4.65112 139.585 4.65112C142.267 4.65112 144.627 5.02431 146.668 5.7707C148.708 6.51708 150.286 7.58798 151.403 8.98204C152.519 10.3761 153.077 12.0081 153.077 13.8782C153.077 15.7482 152.518 17.3802 151.403 18.7743C150.286 20.1683 148.708 21.2392 146.668 21.9856C144.627 22.732 142.265 23.1052 139.585 23.1052C136.904 23.1052 134.541 22.732 132.502 21.9856ZM142.471 17.2491C143.295 16.9543 143.937 16.5189 144.395 15.9456C144.854 15.3723 145.082 14.6827 145.082 13.8795C145.082 13.0763 144.853 12.3867 144.395 11.8134C143.937 11.2401 143.295 10.8047 142.471 10.51C141.647 10.2152 140.685 10.0665 139.585 10.0665C138.485 10.0665 137.524 10.2138 136.698 10.51C135.875 10.8047 135.232 11.2401 134.775 11.8134C134.316 12.3881 134.088 13.0763 134.088 13.8795C134.088 14.6827 134.317 15.3723 134.775 15.9456C135.233 16.5203 135.875 16.9543 136.698 17.2491C137.522 17.5438 138.485 17.6926 139.585 17.6926C140.685 17.6926 141.646 17.5452 142.471 17.2491Z"
                     fill="currentColor"></path>
                  <path
                     d="M160.051 22.0601C158.227 21.3638 156.798 20.3415 155.765 18.9975C154.733 17.6521 154.216 16.0295 154.216 14.1257V5.02173H162.212V13.8796C162.212 14.6017 162.391 15.2534 162.749 15.8362C163.108 16.419 163.599 16.8733 164.224 17.2019C164.849 17.5304 165.552 17.694 166.336 17.694C167.12 17.694 167.826 17.5304 168.46 17.2019C169.094 16.8733 169.585 16.419 169.935 15.8362C170.285 15.2548 170.46 14.6017 170.46 13.8796V5.02173H178.456V14.1257C178.456 16.0282 177.944 17.6521 176.919 18.9975C175.895 20.3429 174.467 21.3638 172.635 22.0601C170.802 22.7565 168.704 23.1053 166.339 23.1053C163.974 23.1053 161.879 22.7565 160.055 22.0601H160.051Z"
                     fill="currentColor"></path>
                  <path
                     d="M180.177 5.02173H189.571L198.866 16.2161V5.02173H206.362V22.7362H196.968L187.673 11.3457V22.7362H180.177V5.02173Z"
                     fill="currentColor"></path>
                  <path
                     d="M123.225 17.0773C122.945 16.7393 122.649 16.4527 122.338 16.2187C122.07 16.0186 121.797 15.8766 121.522 15.786C122.106 15.594 122.637 15.3452 123.115 15.0343C123.848 14.5583 124.418 13.9647 124.826 13.2508C125.234 12.5368 125.438 11.7377 125.438 10.8521C125.438 9.73655 125.109 8.73596 124.451 7.8503C123.793 6.96465 122.865 6.27235 121.665 5.7707C120.466 5.27041 119.083 5.02026 117.518 5.02026H101.701V22.7361H109.697V17.3234H113.082C113.732 17.3234 114.324 17.4343 114.856 17.6561C115.389 17.8778 115.848 18.2348 116.231 18.727L119.428 22.7374H127.817L123.227 17.0787L123.225 17.0773ZM109.696 13.1412V9.45124H114.693C115.226 9.45124 115.701 9.52967 116.117 9.68517C116.533 9.84066 116.859 10.0584 117.092 10.3369C117.325 10.6154 117.442 10.9359 117.442 11.2969C117.442 11.6579 117.317 12.0027 117.067 12.2813C116.817 12.5598 116.48 12.7735 116.055 12.9208C115.631 13.0682 115.168 13.1426 114.668 13.1426H109.696V13.1412Z"
                     fill="currentColor"></path>
                  <path
                     d="M208.263 5.02173H221.23C223.512 5.02173 225.524 5.39086 227.264 6.12914C229.003 6.86741 230.353 7.9045 231.312 9.24177C232.269 10.579 232.748 12.1245 232.748 13.8796C232.748 15.6347 232.269 17.1802 231.312 18.5175C230.353 19.8548 229.005 20.8919 227.264 21.6301C225.522 22.3684 223.512 22.7375 221.23 22.7375H208.263V5.02173ZM219.982 17.5696C220.947 17.5696 221.813 17.4223 222.58 17.1261C223.346 16.8314 223.942 16.4041 224.366 15.847C224.791 15.2899 225.003 14.6328 225.003 13.8783C225.003 13.1238 224.791 12.468 224.366 11.9096C223.942 11.3525 223.346 10.9252 222.58 10.6304C221.813 10.3357 220.947 10.1869 219.982 10.1869H216.009V17.5683H219.982V17.5696Z"
                     fill="currentColor"></path>
               </svg>
            
            <button class="btn featuredBtnOverlay">View Shop</button>
            </a>
         </div>
      </div>
   </div>
   <?php include_once '../include/footer.php'; ?>
</div>
</body>
</html>




<!-- Why does this .php page have closing tags for body and html? 
This is because the metadata and starting divs were created in header.php ("include" folder), and referenced with PHP above. -->