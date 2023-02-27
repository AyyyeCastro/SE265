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
            return false;}
        else
        {
            return true;
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
            return false;}
        else
        {
            return true;
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
    
    public function getProfileByName($profileName) 
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_users WHERE userInnie = :profileName");
        $bindParameters = array(":profileName" => $profileName);
        
        if($stmt->execute($bindParameters) && $stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
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

    public function isUserMod($sessionID) 
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_users WHERE userID = :sessionID");
        $bindParameters = array(":sessionID" => $sessionID);
        
        if($stmt->execute($bindParameters) && $stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getCustomerDetails($customerID) 
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_users WHERE userID = :customerID");
        $bindParameters = array(":customerID" => $customerID);
        
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

    public function getUserIdByInnie($userInnie)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT userID FROM plugin_users WHERE userInnie = :userInnie");
        $bindParameters = array(":userInnie" => $userInnie);
        
        
        $stmt->execute($bindParameters);
        return $stmt->fetch();
    }

    public function updateProfile($userName, $userPW, $userInnie, $userBio, $userID, $fileDestination, $userState, $isModerator)
    {
        $userTable = $this->userData; 
        
        if($userPW)
        {
            $salt = random_bytes(32);
            $hashedPW = sha1($salt . $userPW);
            $stmt = $userTable->prepare("UPDATE plugin_users SET userName = :uName, userPW = :uPW, userSalt = :uSalt, userInnie = :uInnie, userBio = :uBio, userPic = :fileDestination, userState=:userState, isModerator=:isModerator WHERE userID = :userID");
            $bindParameters = array(
                ":uName" => $userName,
                ":uPW" => $hashedPW,
                ":uSalt" => $salt,
                ":uInnie" => $userInnie,
                ":uBio" => $userBio ,
                ":userID" => $userID,
                ":fileDestination" => $fileDestination,
                ":userState"=>$userState,
                ":isModerator"=>$isModerator
            );
        }else{
            $stmt = $userTable->prepare("UPDATE plugin_users SET userName = :uName, userInnie = :uInnie, userBio = :uBio, userPic = :fileDestination, userState=:userState WHERE userID = :userID");
            $bindParameters = array(
                ":uName" => $userName,
                ":uInnie" => $userInnie,
                ":uBio" => $userBio ,
                ":userID" => $userID,
                ":fileDestination" => $fileDestination,
                ":userState"=>$userState
            );
        }    
        return $stmt->execute($bindParameters);
    }

    public function updatePP($fileDestination,$userID)
    {
        $isUpdated = false;        
        $userTable = $this->userData; 

        $stmt = $userTable->prepare("UPDATE plugin_users SET userPic = :fileDestination WHERE userID = :userID");

        $bindParameters = array(

            ":fileDestination" => $fileDestination,
            ":userID"=>$userID
        );       

        $isUpdated = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isUpdated);
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
    $listDesc, $listCond, $fileDestination, $listState, 
    $listPostedOn,$fileDestination2, $fileDestination3, $fileDestination4)
    {
        $isListPosted = false;        
        $userTable = $this->userData; 

        $stmt = $userTable->prepare("INSERT INTO plugin_listings SET userID = :userID, listProdCat = :listProdCat, 
        listProdPrice = :listProdPrice,listProdTitle = :listProdTitle, listDesc = :listDesc,
         listCond = :listCond, listProdPic = :fileDestination, listState=:listState, listPostedOn = NOW(), 
         listProdPic2 = :fileDestination2,listProdPic3 = :fileDestination3,listProdPic4 = :fileDestination4");

        $bindParameters = array(
            ":userID" => $userID,
            ":listProdCat" => $listProdCat,
            ":listProdPrice" => $listProdPrice,
            ":listProdTitle" => $listProdTitle,
            ":listDesc" => $listDesc,
            ":listCond" => $listCond,
            ":fileDestination" => $fileDestination,
            ":listState" => $listState,
            ":fileDestination2" => $fileDestination2,
            ":fileDestination3" => $fileDestination3,
            ":fileDestination4" => $fileDestination4,
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
    $listDesc, $listCond, $fileDestination, $listState)
    {
        $isListPosted = false;        
        $userTable = $this->userData; 

        $stmt = $userTable->prepare("UPDATE plugin_listings SET listProdCat = :listProdCat, 
        listProdPrice = :listProdPrice, listProdTitle = :listProdTitle, listDesc = :listDesc,
        listCond = :listCond, listProdPic = :fileDestination, listState =:listState, listUpdatedOn=NOW() WHERE listID = :listID");

        $bindParameters = array(
            ":listID" => $listID,
            ":listProdCat" => $listProdCat,
            ":listProdPrice" => $listProdPrice,
            ":listProdTitle" => $listProdTitle,
            ":listDesc" => $listDesc,
            ":listCond" => $listCond,
            # listProdPic = the :fileDestination -> which equals the $fileDestination. 
            ":fileDestination" => $fileDestination,
            ":listState"=> $listState,
        );       

        $isListPosted = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isListPosted);
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
    ### MESSAGE MANAGEMENT ###

    public function sendMessage($parentID,$customerID, $sellerID, $listID, 
    $messageTitle, $messageDesc, $fileDestination, $customerInnie, 
    $sellerInnie, $fileDestination2, $fileDestination3, $fileDestination4,
    $isMessageReplied)
    {
        $isMsgSent = false;        
        $userTable = $this->userData; 

        $salt = random_bytes(32); 

        $stmt = $userTable->prepare("INSERT INTO plugin_messages SET parentID=:parentID, customerID = :customerID, sellerID = :sellerID, 
        listID = :listID, messageTitle = :messageTitle, messageDesc = :messageDesc, messagePics =:fileDestination, 
        messageSentOn = NOW(), customerInnie=:customerInnie, sellerInnie=:sellerInnie, 
        messagePic2=:fileDestination2,messagePic3=:fileDestination3, messagePic4=:fileDestination4, isMessageReplied=:isMessageReplied");

        $bindParameters = array(
            ":parentID"=>$parentID,
            ":customerID" => $customerID,
            ":sellerID" => $sellerID,
            ":listID" => $listID,
            ":messageTitle" => $messageTitle,
            ":messageDesc" => $messageDesc,
            ":fileDestination" => $fileDestination,
            ":customerInnie"=> $customerInnie,
            ":sellerInnie"=>$sellerInnie,
            ":fileDestination2" => $fileDestination2,
            ":fileDestination3" => $fileDestination3,
            ":fileDestination4" => $fileDestination4,
            ":isMessageReplied"=>$isMessageReplied,
            
        );       

        $isMsgSent = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isMsgSent);
    }

    public function updateIsMessageReplied($priorMessageID, $updateStatus){

        $isMsgSent = false;        
        $userTable = $this->userData; 

        $stmt = $userTable->prepare("UPDATE plugin_messages SET isMessageReplied = :updateStatus 
        WHERE messageID = :priorMessageID");

        $bindParameters = array(
            ":updateStatus"=>$updateStatus,
            ":priorMessageID"=>$priorMessageID
        );

        $isMsgSent = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isMsgSent);
    }
        


    public function getAllMessages($userID){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_messages WHERE (sellerID = :userID) ORDER BY messageSentOn DESC");
        $bindParameters = array(
            ":userID" => $userID,
        );
        $stmt->execute($bindParameters);
        return $stmt->fetchAll();
    }

    public function getMessageCrumbs($listID, $parentID, $messageSentOn){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_messages WHERE (listID=:listID AND parentID = :parentID AND messageSentOn < :messageSentOn) ORDER BY messageSentOn DESC");
        $bindParameters = array(
            ":listID" => $listID,
            ":parentID" => $parentID,
            ":messageSentOn" => $messageSentOn
        );
    
        $stmt->execute($bindParameters);
        return $stmt->fetchAll();
    }
    

    

    public function getMessageDetails($messageID){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_messages WHERE messageID = :messageID");
        $bindParameters = array(
            ":messageID" => $messageID
        );
        $stmt->execute($bindParameters);
        /* learn from mistake:
        use fetch() here, not fetchall();
        */
        return $stmt->fetch();
    }

    
    #############################################################
    #############################################################
    ### NAME SEARCHING ###

    public function findListAdvanced($listProdTitle, $listDesc, $listProdCat, $listCond, $listState) 
    {
        $results = array();                  
        $binds = array();                    
        $isFirstClause = true;              
        $userTable = $this->userData;
 
 
        $sql = "SELECT * FROM plugin_listings";
 
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

         if (isset($listDesc)) 
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
             $sql .= " listDesc LIKE :listDesc";
             $binds['listDesc'] = '%'.$listDesc.'%';
         }
       
         if (isset($listProdCat)) 
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
             $sql .= "  listProdCat LIKE :listProdCat";
            $binds['listProdCat'] = $listProdCat;
        }
 
         if (isset($listCond)) 
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
            $sql .= "  listCond LIKE :listCond";
            $binds['listCond'] = $listCond;
        }

        if (isset($listState)) 
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
            $sql .= " listState LIKE :listState";
            $binds['listState'] = '%'.$listState.'%';
        }
 
 
         $sql .= " ORDER BY listProdTitle";
        
         $stmt = $this->userData->prepare($sql);
       
         if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
             $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         }
 
         return $results;
    }   

    ###############################################
    ########### CONFIRMING SALE ##################

    public function confirmSale($listID,$customerID,$sellerID, $orderID, $customerInnie)
   {
       $isListSold = false;        
       $userTable = $this->userData; 

       $stmt = $userTable->prepare("UPDATE plugin_listings SET isListSold='YES', customerID=:customerID, sellerID=:sellerID,timeListsold=NOW(), orderID = :orderID, customerInnie=:customerInnie WHERE listID =:listID");

       $bindParameters = array(
           ":listID"=>$listID,
           ":customerID"=>$customerID,
           ":sellerID"=>$sellerID,
           ":orderID"=>$orderID,
           ":customerInnie"=>$customerInnie,
       );       

       $isListSold = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
       return ($isListSold);
   }

    public function defaultSaleMsg($parentID, $customerID, $sellerID, $listID, 
    $messageTitle, $messageDesc, $customerInnie, $sellerInnie)
    {
        $isMsgSent = false;        
        $userTable = $this->userData; 

        $salt = random_bytes(32); 

        $stmt = $userTable->prepare("INSERT INTO plugin_messages SET parentID=:parentID, customerID = :customerID, sellerID = :sellerID, 
        listID = :listID, messageTitle = :messageTitle, messageDesc = :messageDesc,messageSentOn = NOW(), 
        customerInnie=:customerInnie, sellerInnie=:sellerInnie");

        $bindParameters = array(
            ":parentID"=>$parentID,
            ":customerID" => $customerID,
            ":sellerID" => $sellerID,
            ":listID" => $listID,
            ":messageTitle" => $messageTitle,
            ":messageDesc" => $messageDesc,
            ":customerInnie"=> $customerInnie,
            ":sellerInnie"=>$sellerInnie,
            
        );       

        $isMsgSent = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isMsgSent);
    }

    public function getSaleHistory($userID){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_listings WHERE userID = :userID AND isListSold = 'Yes' ORDER BY timeListsold DESC");
        $bindParameters = array(
            ":userID" => $userID
        );
        $stmt->execute($bindParameters);
        return $stmt->fetchAll();
    }
    public function getPurchaseHistory($userID){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_listings WHERE sellerID = :userID AND isListSold = 'Yes' ORDER BY timeListsold DESC");
        $bindParameters = array(
            ":userID" => $userID
        );
        $stmt->execute($bindParameters);
        return $stmt->fetchAll();
    }

    ###########################################
    ########### USER RATINGS ##################

    public function giveUserRating($userID,$userRating, $orderID){
        $userTable = $this->userData;
        $stmt = $userTable->prepare("INSERT INTO plugin_user_ratings SET userID=:userID, userRating=:userRating, orderID=:orderID");
        $bindParameters = array(
            ":userID" => $userID,
            "userRating"=>$userRating,
            "orderID"=>$orderID
        );
        $stmt->execute($bindParameters);
        return $stmt->fetchAll();
    }

    function isAlreadyRated($orderID){
        $userTable = $this->userData; 
        $stmt = $userTable->prepare("SELECT count(*) FROM plugin_user_ratings WHERE orderID=:orderID");


        $stmt->bindParam(
            ':orderID', $orderID
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

    public function getAvgRating($userID) {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT AVG(userRating) AS userRating FROM plugin_user_ratings WHERE userID = :userID");
        $stmt->execute(array(':userID' => $userID));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return round($result['userRating'], 1);
        } else {
            return 0;
        }
    }

    function getRatingCount($userID){
        $userTable = $this->userData; 
        $stmt = $userTable->prepare("SELECT count(userID) FROM plugin_user_ratings WHERE userID=:userID");


        $stmt->bindParam(
            ':userID', $userID
        );

        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn(); 
        if($number_of_rows > 0){
            return $number_of_rows;}       
    }
    
}

?>