<?php




    /* 
    NOTE:
    THIS IS AN ARTIFACT PAGE FROM PREVIOUS EDITIONS OF THE PROJECT.
    IT IS NOT CURRENTLY IN USE, BUT THE LOGIC HERE MAY STILL BE VALUABLE IN THE FUTURE.
    THIS IS A DEAD PAGE TO THE LIVE PROJECT. */








    

    //reference the files
    include_once '../include/functions.php';
    include_once '../model/userController.php';
    include_once '../include/header.php';

    //if not logged in, kick them
    // if (!isUserLoggedIn())
    // {
    //     header("location: ../login.php"); 
    // }

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
    $defaultAvie = "../include/default-avie/default-avie.jpg";
    $listCollection =[];
    $userInnie="";
    $listCollection = $newUserClass->findUserByInnie($userInnie);
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
    
?>
<!-- END PHP -->

<style>
    .ProfilePics {
      object-fit: cover;/* Do not scale the image */
      object-position: center; /* Center the image within the element */
      width: 200px;
      height: 200px;
      margin-bottom: 1rem;
    }
</style>


<!-- BEGIN HTML -->
    <form method="post" action="searchUsers.php">
    <div class="container">
        <br>
        <!-- title -->
        <h1>Find other sellers!</h1><br><hr>

        <!-- Input values & labels, which get sent to the variables we declared in PHP -->
        <div class="row">
            <div class="col-md-12">
                <h4>Search By</h4>
                <label for="inputUserInnie">Innie:</label>
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
    <!-- END TABLE -->
</body>
 <!-- END BODY -->
</html>


