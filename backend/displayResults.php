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
   try 
   {
      $userDatabase = new Users($configFile);
   } 
   catch ( Exception $error ) 
   {
      echo "<h2>" . $error->getMessage() . "</h2>";
   }   

   $defaultAvie = "../include/default-avie/default-avie.jpg";
   $listCollection =[];
   $listProdTitle="";
   $userInnie="";
   $listCollection = $userDatabase->findUserByInnie($userInnie);
   $prodTitle="";
   // Fill the listings before criteria
   $userListLog = $userDatabase->findListBySearch($listProdTitle);
   $deleteList=[];
   if (isPostRequest()) 
   {
        // if they clicked the search button ->
        if (isset($_POST["search"]))
        {
            $search_option = $_POST['search_option'];
            // if the user selected to search for sellers
            if ($search_option == 'Products') 
            {
               // declare the variables to nothing first...
               $listProdTitle ="";
               //... have the user's input (from form below) allign with the declared variables. 
               $listProdTitle  = $_POST['inputName'];
               // have the array (declared above) store the info, and send it to the findOneCollection function.
               $userListLog = $userDatabase->findListBySearch($listProdTitle);
            }
            else {
            // declare the variables to nothing first...
            $userInnie="";
            //... have the user's input (from form below) allign with the declared variables. 
            $userInnie = $_POST['inputName'];
            // have the array (declared above) store the info, and send it to the findOneCollection function.
            $listCollection = $userDatabase->findUserByInnie($userInnie);
           }
        }
        else
        {
            //Otherwise gather all records.
           $userListLog = $userDatabase->findListBySearch($listProdTitle);
        }
    }
?>
<style>
    .ProfilePics {
      object-fit: cover;/* Do not scale the image */
      object-position: center; /* Center the image within the element */
      width: 200px;
      height: 200px;
      margin-bottom: 1rem;
    }
</style>


   <!-- WORK IN PROGRESS... Display all user listings at once w/ no criteria added. 
   Work on search bar and drill down next --> 
   <!-- Perhaps include sellers name? -->
   <div class="container">

      <?php if ($search_option == 'Products'): ?>
      <br>
      <div class="row">
         <p><?php if (isPostRequest()){if (isset($_POST["search"])){echo 'Results for: '. '<b>' .$listProdTitle .'</b>';}} ?></p>
      </div>      
      <table class="table table-hover" id="userListLog">
         <thead>
            <tr>
            <th></th> <!-- listID -->
            <th></th> <!-- image -->
            <th>Title</th>
            <th>Price</th>
            <th>Description</th>
            <th>Condition</th>
            <th>Category</th>
            </tr>
         </thead>
         <tbody>
            <!-- For every value stored in the array we declared in the PHP section -->
            <?php
            foreach ($userListLog as $row): ?>
            <tr>
            <td>
               <form action="" method="post">
               <input type="hidden" name="p_id" value="<?= $row['listID']; ?>" />
               </form>   
            </td>
            <!-- Display it's value, AND IMPORTANTLY set the links to lead to the user's profile according by userID -->
            <td><img src="<?= $row['listProdPic']; ?>" style="height: 200px; width: 200px;"></td>
            <td><?= $row['listProdTitle']; ?></td>
            <td><?= $row['listProdPrice']; ?></td>
            <td><?= $row['listDesc']; ?></td>
            <td><?= $row['listCond']; ?></td>
            <td><?= $row['listProdCat']; ?></td>
            </tr>
            <?php endforeach;?>
            <?php else: ?>
            <br>
            <div class="row">
               <p><?php if (isPostRequest()){if (isset($_POST["search"])){echo 'Results for: '. '<b>' .$userInnie .'</b>';}} ?></p>
            </div>                     
               <table class="table table-hover">

               <tbody>
                  <!-- For every value stored in the array we declared in the PHP section -->
               <?php foreach ($listCollection as $row): ?>
                  <tr>
                     <td>
                           <form action="" method="post">
                              <input type="hidden" name="p_id" value="<?= $row['userID']; ?>" />
                           </form>   
                     </td>
                     <!-- Display it's value, AND IMPORTANTLY set the links to lead to the user's profile according by userID -->
                     <td><img src="<?php echo (is_null($row['userPic']) || empty($row['userPic'])) ? $defaultAvie : $row['userPic']; ?>" class="ProfilePics rounded-circle" alt="profile picture" style="border: solid 2px blue;"></td>
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