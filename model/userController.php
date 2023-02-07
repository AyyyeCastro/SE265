<?php

class Users
{
    private $userData;

    const saltPW = "saltedPW";


    public function __construct($configFile) 
    {
        if ($ini = parse_ini_file($configFile))
        {
            $userDB = new PDO( "mysql:host=" . $ini['servername'] . 
                                ";port=" . $ini['port'] . 
                                ";dbname=" . $ini['dbname'], 
                                $ini['username'], 
                                $ini['password']);

            $userDB->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $userDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->userData = $userDB;
        }
        else
        {
            throw new Exception( "<h2>Creation of database object failed!</h2>", 0, null );
        }
    } 

    public function getAllStates(){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT stateName FROM plugin_states");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function userSignup($userName, $PW, $userInnie, $userBio, $userState)
    {
        $isUserAdded = false;        
        $userTable = $this->userData; 

        $salt = random_bytes(32); 

        $stmt = $userTable->prepare("INSERT INTO plugin_users SET userName = :uName, userPW = :uPW, userSalt = :uSalt, userInnie = :uInnie, userBio = :uBio, userState =:uState, userJoined = NOW()");

        $bindParameters = array(
            ":uName" => $userName,
            ":uPW" => sha1($salt . $PW),
            ":uSalt" => $salt,
            ":uInnie" => $userInnie,
            ":uBio" => $userBio,
            ":uState" => $userState,
            #":fileDestination" => $fileDestination
        );       

        #---- Important to notes ----#
            # userBio will not be filled by the user during this sign up. It will be a hidden form in signUp.php with a default value of "Say something about your self".
            # This is just to have the MySQL column (userBio) injected upon signup, and automatically relate the bio with the userID upon signing up. 
            # This will allow for an easy update script in a future function.
        
        $isUserAdded = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);

        return ($isUserAdded);
    }


    function userUniqueInnie($userInnie){
        $userTable = $this->userData; 
        $stmt = $userTable->prepare("SELECT count(*) FROM plugin_users WHERE userInnie=:userInnie");


        $stmt->bindParam(
            ':userInnie', $userInnie
        );

        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn(); 
        if($number_of_rows > 0){
            return true;}
        else
        {
            return false;
        }
    }

    function userUniqueUN($userName){
        $userTable = $this->userData; 
        $stmt = $userTable->prepare("SELECT count(*) FROM plugin_users WHERE userName=:userName");


        $stmt->bindParam(
            ':userName', $userName
        );

        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn(); 
        if($number_of_rows > 0){
            return true;}
        else
        {
            return false;
        }
    }


    public function getDatabaseRef()
    {
        return $this->userData;
    }
 

    public function isUserTrue($userName, $PW)
    {
        $isUserTrue = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("SELECT userPW, userSalt FROM plugin_users WHERE userName =:userName");
 
        $stmt->bindValue(':userName', $userName);

        $ifUserFound = ($stmt->execute() && $stmt->rowCount() > 0);

        if ($ifUserFound)
        {
            $results = $stmt->fetch(PDO::FETCH_ASSOC); 
            $hashPW = sha1( $results['userSalt'] . $PW);
            $isUserTrue = ($hashPW == $results['userPW']);
        }
        return $isUserTrue;
    }
    
    public function getUserDetails($userID) 
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_users WHERE userID = :userID");
        $bindParameters = array(":userID" => $userID);
        
        if($stmt->execute($bindParameters) && $stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getUserId($username)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT userID FROM plugin_users WHERE userName = :username");
        $bindParameters = array(":username" => $username);
        $stmt->execute($bindParameters);
        $user = $stmt->fetch();
        return $user['userID'];
    }

    public function updateProfile($userName, $PW, $userInnie, $userBio, $userID, $fileDestination)
    {
        $userTable = $this->userData; 
        
        if($PW)
        {
            $salt = random_bytes(32);
            $hashedPW = sha1($salt . $PW);
            $stmt = $userTable->prepare("UPDATE plugin_users SET userName = :uName, userPW = :uPW, userSalt = :uSalt, userInnie = :uInnie, userBio = :uBio, userPic = :fileDestination WHERE userID = :userID");
            $bindParameters = array(
                ":uName" => $userName,
                ":uPW" => $hashedPW,
                ":uSalt" => $salt,
                ":uInnie" => $userInnie,
                ":uBio" => $userBio ,
                ":userID" => $userID,
                ":fileDestination" => $fileDestination
            );
        }else{
            $stmt = $userTable->prepare("UPDATE plugin_users SET userName = :uName, userInnie = :uInnie, userBio = :uBio, userPic = :fileDestination WHERE userID = :userID");
            $bindParameters = array(
                ":uName" => $userName,
                ":uInnie" => $userInnie,
                ":uBio" => $userBio ,
                ":userID" => $userID,
                ":fileDestination" => $fileDestination
            );
        }    
        return $stmt->execute($bindParameters);
    }


    public function findUserByInnie($userInnie) 
    {
        $results = array();                  
        $binds = array();                    
        $isFirstClause = true;              
        $userTable = $this->userData;
 
 
        $sql = "SELECT userID, userName, userInnie, userBio, userPic FROM plugin_users";
 
         if (isset($userInnie)) 
         {
             if ($isFirstClause)
             {
                 $sql .= " WHERE ";
                 $isFirstClause = false;
             }
             else
             {
                 $sql .= " AND ";
             }
             $sql .= " userInnie LIKE :userInnie";
             $binds['userInnie'] = '%'.$userInnie.'%';
         }
       
 
         $sql .= " ORDER BY userInnie";
        
         $stmt = $this->userData->prepare($sql);
       
         if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
             $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         }
 
 
        return $results;
    }   
     

    #######################################################################################
    #######################################################################################
    ################# -- BEGINNING OF USER LISTING CONTROLLER -- ##########################
    #######################################################################################
    #######################################################################################

    public function getAllCategories(){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT catGenre FROM plugin_categories");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllConditions(){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT condType FROM plugin_conditions");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllListings(){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_listings ORDER BY listProdPrice DESC");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    
    public function postUserListing($userID, $listProdCat, $listProdPrice, $listProdTitle, 
    $listDesc, $listCond, $fileDestination)
    {
        $isListPosted = false;        
        $userTable = $this->userData; 

        $stmt = $userTable->prepare("INSERT INTO plugin_listings SET userID = :userID, listProdCat = :listProdCat, 
        listProdPrice = :listProdPrice,listProdTitle = :listProdTitle, listDesc = :listDesc,
         listCond = :listCond, listProdPic = :fileDestination");

        $bindParameters = array(
            ":userID" => $userID,
            ":listProdCat" => $listProdCat,
            ":listProdPrice" => $listProdPrice,
            ":listProdTitle" => $listProdTitle,
            ":listDesc" => $listDesc,
            ":listCond" => $listCond,
            ":fileDestination" => $fileDestination,
        );       

        $isListPosted = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isListPosted);
    }

    public function getUserListing($userID){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_listings WHERE userID = :userID ORDER BY listProdPrice DESC");
        $bindParameters = array(
            ":userID" => $userID
        );
        $stmt->execute($bindParameters);
        return $stmt->fetchAll();
    }

    public function updateUserListing($listID, $listProdCat, $listProdPrice, $listProdTitle, 
    $listDesc, $listCond, $fileDestination)
    {
        $isListPosted = false;        
        $userTable = $this->userData; 

        $stmt = $userTable->prepare("UPDATE plugin_listings SET listProdCat = :listProdCat, 
        listProdPrice = :listProdPrice, listProdTitle = :listProdTitle, listDesc = :listDesc,
        listCond = :listCond, listProdPic = :fileDestination WHERE listID = :listID");

        $bindParameters = array(
            ":listID" => $listID,
            ":listProdCat" => $listProdCat,
            ":listProdPrice" => $listProdPrice,
            ":listProdTitle" => $listProdTitle,
            ":listDesc" => $listDesc,
            ":listCond" => $listCond,
            # listProdPic = the :fileDestination -> which equals the $fileDestination. 
            ":fileDestination" => $fileDestination,
        );       

        $isListPosted = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isListPosted);
        var_dump($isListPosted);
    }


    public function getListForm($listID) 
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_listings WHERE listID = :listID");
        $bindParameters = array(":listID" => $listID);
        
        if($stmt->execute($bindParameters) && $stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    
    public function deleteUserLising($listID) 
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("DELETE FROM plugin_listings WHERE listID = :listID");
        $bindParameters = array(":listID" => $listID);
        
        if($stmt->execute($bindParameters) && $stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }


    #############################################################
    #############################################################
    ### NAME SEARCHING ###

    public function findListBySearch($listProdTitle) 
    {
        $results = array();                  
        $binds = array();                    
        $isFirstClause = true;              
        $userTable = $this->userData;
 
 
        $sql = "SELECT listID, listProdCat, listProdPrice, listProdTitle, listDesc, listCond, listProdPic FROM plugin_listings";
 
        # Note: Change listDesc to listProdDesc when u get a chance.. 
         if (isset($listProdTitle)) 
         {
             if ($isFirstClause)
             {
                 $sql .= " WHERE ";
                 $isFirstClause = false;
             }
             else
             {
                 $sql .= " AND ";
             }
             $sql .= " listProdTitle LIKE :listProdTitle";
             $binds['listProdTitle'] = '%'.$listProdTitle.'%';
         }
       
 
         $sql .= " ORDER BY listProdTitle";
        
         $stmt = $this->userData->prepare($sql);
       
         if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
             $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         }
 
 
        return $results;
    }  

    public function findListByCat($listProdCat) 
    {
        $results = array();                  
        $binds = array();                    
        $isFirstClause = true;              
        $userTable = $this->userData;
 
 
        $sql = "SELECT listID, listProdCat, listProdPrice, listProdTitle, listDesc, listCond, listProdPic FROM plugin_listings";
 
        # Note: Change listDesc to listProdDesc when u get a chance.. 
         if (isset($listProdTitle)) 
         {
             if ($isFirstClause)
             {
                 $sql .= " WHERE ";
                 $isFirstClause = false;
             }
             else
             {
                 $sql .= " AND ";
             }
             $sql .= " listProdCat LIKE :listProdCat";
             $binds['listProdCat'] = '%'.$listProdCat.'%';
         }
       
 
         $sql .= " ORDER BY listProdCat";
        
         $stmt = $this->userData->prepare($sql);
       
         if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
             $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         }
 
 
        return $results;
    }  



}
?>