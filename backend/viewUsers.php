<?php
include_once '../include/functions.php';
include_once '../include/header.php';
include_once '../model/userController.php';

if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn']) {
   // work in progress... If not logged in when viewing prorfiles 
   // -> redirect to login w/ a prompt on why they should be logged in..
   echo "Please login before viewing profiles..";
   exit;
}


$message = "";
$configFile = '../model/dbconfig.ini';
try {
   $userDatabase = new Users($configFile);
} catch (Exception $error) {
   echo "<h2>" . $error->getMessage() . "</h2>";
}


$userID = filter_input(INPUT_GET, 'userID');
$userInfo = $userDatabase->getUserDetails($userID);
$userListLog = $userDatabase->getUserListing($userID);


# ----------------#
?>

<style>
   .profileObject {
      border-bottom: 1px solid rgba(186, 186, 186, .4);
      /* first 3 are the color, last is the opacity */
      background-clip: padding-box;
      -webkit-background-clip: padding-box;
   }

   /* Important, sets it so that was "edit" listing buttons only show on a table hover */

   .showRequest {
      display: none;
   }

   tr:hover .showRequest {
      display: inline-block;
   }

   table {
      width: 50%;
      border-collapse: collapse;
   }

   td:after {
      content: '';
      display: block;
      margin-top: 20%;
   }

   td .content-img {}

   .ProfilePics {
      object-fit: cover;
      /* Do not scale the image */
      object-position: center;
      /* Center the image within the element */
      width: 200px;
      height: 200px;
      margin-bottom: 1rem;
   }

   .profDetails {
      word-spacing: 7px;
   }

   .listProdTitle {
      font-weight: bold;
      font-size: 18px;
      max-width: 250px;
      /* limit title width to the same width of the of the image */
   }

   .listProdCat {}

   .listProdPrice {
      font-weight: bold;
      font-size: 18px;
   }

   .listCond {
      font-size: 13px;
   }

   .listState {
      font-size: 13px;
   }

   .btnRequest {
      margin-top: 15px;
   }
</style>

<div class="container">
   <div id="mainDiv">
      <div id="profileHeader">
         <br>
         <div class="container-fluid bg-light">
            <div class="container">
               <div class="row" style="padding: 10px;">
                  <div class="col-md-4">
                     <div class="img-container">
                        <?php
                        $defaultAvie = "../include/default-avie/default-avie.jpg";
                        if (is_null($userInfo['userPic']) || empty($userInfo['userPic'])) {
                           echo "<img src= '$defaultAvie' class='ProfilePics rounded-circle' alt='profile picture' style='border: solid 2px blue;'>";
                        } else {
                           echo "<img src='" . $userInfo['userPic'] . "' class='ProfilePics rounded-circle' alt='profile picture' style='border: solid 2px blue;'>";
                        }
                        ?>
                     </div>
                  </div>

                  <div class="col-md-7" style="padding: 10px;">
                     <h1>
                        <?php echo $userInfo['userInnie']; ?>
                     </h1>
                     <small id="joinDate" class="form-text text-muted profDetails">
                        Joined: <b>
                           <?php echo date("Y-m-d", strtotime($userInfo['userJoined'])); ?>
                        </b>
                        State: <b>
                           <?php echo $userInfo['userState']; ?>
                        </b>
                     </small>
                     <br>
                     <small id="bioTitle" class="form-text text-muted">Biography</small>
                     <p>
                        <?php echo $userInfo['userBio']; ?>
                     </p>
                  </div>

                  <!-- The following code would be inside the 'profileHeader' div in your viewProfile.php file, most likely in the same area where you have the "Edit" button currently -->

               </div> <!-- Row -->
            </div> <!-- container -->
         </div> <!-- container bg -->
      </div> <!-- div profileHeader -->
      <br>

      <!-- BEGIN TABLE -->
      <table class="table table-hover" id="userListLog">
         <thead>
            <tr>
               <th></th> <!-- listID, edit/delete buttons-->
               <th></th> <!-- prodImg, prodTitle, and prodCondition -->
               <th>Desc</th>
               <th>Category</th>
               <th></th>
            </tr>
         </thead>
         <tbody>
            <!-- For every value stored in the array we declared in the PHP section -->
            <?php
            foreach ($userListLog as $row): ?>
               <tr>
                  <td>
                     <!-- form to manage post requests -->
                     <form>
                        <input type="hidden" name="listID" value="<?= $row['listID']; ?>" />
                     </form>
                  </td>
                  <td>
                     <div class="container">
                        <div class="row">
                           <div class="col-sm">
                              <a href="productDetails.php?listID=<?= $row['listID']; ?>">
                                 <div class="listProdPic"><img src="<?= $row['listProdPic']; ?>"
                                       style="object-fit: contain; object-position: center; width: 250px; height: 250px; background-color: #F6F6F6;">
                                 </div>
                                 <div class="listProdTitle">
                                    <?= $row['listProdTitle']; ?>
                                 </div>
                                 <div class="listProdPrice">$
                                    <?= $row['listProdPrice']; ?>
                                 </div>
                                 <div class="listCond">
                                    <?= $row['listCond']; ?>
                                 </div>
                              </a>
                           </div>
                        </div>
                  </td>
                  <td>
                     <div class="content, listDesc">
                        <?= $row['listDesc']; ?>
                     </div>
                  </td>
                  <td>
                     <div class="content, listProdCat ">
                        <?= $row['listProdCat']; ?>
                     </div>
                  </td>
               <?php endforeach; ?>
               <!-- END for-loop -->
         </tbody>
      </table>
      <!-- END TABLE -->
   </div> <!-- main div -->
</div>
</body>

</html>