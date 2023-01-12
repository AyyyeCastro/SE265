<?php

    //reference the files
    include_once '../include/functions.php';
    include_once '../model/userController.php';
    include_once '../include/header.php';

    //if not logged in, kick them
    if (!isUserLoggedIn())
    {
        header("location: ../login.php"); 
    }

    // call the class & db connection
    $configFile = '../model/dbconfig.ini';
    try 
    {
        $newUserClass = new Users($configFile);
    } 
    catch ( Exception $error ) 
    {
        echo "<h2>" . $error->getMessage() . "</h2>";
    }   


    //Arrays to store info 
    $listCollection =[];
    $deleteList=[];
    if (isPostRequest()) 
    {
        // if they clicked the search button ->
        if (isset($_POST["search"]))
        {
            // declare the variables to nothing first...
            $userInnie="";
            //... have the user's input (from form below) allign with the declared variables. 
            $userInnie = $_POST['inputUserInnie'];
            // have the array (declared above) store the info, and send it to the findOneCollection function.
            $listCollection = $newUserClass->findUserByInnie($userInnie);
        }
        else
        {
            //Otherwise gather all records.
            $listCollection = $newUserClass->findUserByInnie($userInnie);
        }
    }
    

   //  // if they clicked the delete button, delete the record w/ delete function.
   //  if (isPostRequest()) 
   //  {
   //      if (isset($_POST["delete"]))
   //      {
   //          $id = filter_input(INPUT_POST, 'p_id');
   //          $deleteList = $newCollectionClass->deleteCollection($id);
   //          header('Location: searchCollections.php');
   //      }  
   //  }
?>
<!-- END PHP -->


<!-- BEGIN HTML -->
    <form method="post" action="searchUsers.php">
    <div class="container">
        <!-- title -->
        <h1>Find your friends!</h1><br><hr>

        <!-- Input values & labels, which get sent to the variables we declared in PHP -->
        <div class="row">
            <div class="col-md-12">
                <label for="inputUserInnie">Enter other user's Innie:</label>
                <input type="text" name="inputUserInnie" value=<?php if (isPostRequest()){if (isset($_POST["search"])){echo $userInnie;}} ?>>
            </div>
        </div>

        <!-- Buttons -->
        <div class="rowContainer"><br>
            <div class="col1"></div>
            <div class="col2">
                <!-- Search with criteria entered -->
                <input type="submit" name="search" value="Search" class="btn btn-primary"> 
                <!-- Reset the search filter -->
                <a href="searchUsers.php"><input type="button" name="refresh" value="Reset Filter" class="btn btn-success"></a>
            </div> 
        </div>
    </form>
    <br>
    <!-- BEGIN TABLE -->
    <table class="table table-hover">
        <thead>
            <tr>
               <th>id (will get hidden)</th>
                <th>User Avie</th>
                <th>User Innie</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <!-- For every value stored in the array we declared in the PHP section -->
        <?php foreach ($listCollection as $row): ?>
            <tr>
                <td>
                    <form action="" method="post">
                        <input type="text" name="p_id" value="<?= $row['userID']; ?>" />
                    </form>   
                </td>
                <!-- Display it's value -->
                <td><?php echo '<img src="'. $row['userPic'] . '" style="height: 220; width: 220px;">'; ?></td>
                <td><?php echo $row['userInnie']; ?></td>
                <td><a href='viewProfile.php?userID=<?= $row['userID']; ?>' class='btn btn-primary'>View Profile</a></td>

            </tr>
        <?php endforeach; ?>
        <!-- END for-loop -->
        </tbody>
    </table>
    <!-- END TABLE -->
</body>
 <!-- END BODY -->
</html>


