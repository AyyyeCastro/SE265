<?php

class Users
{
    private $userData;

    const saltPW = "saltedPW";


    public function __construct($configFile) // $configFile declared in header.php
    {
        if ($ini = parse_ini_file($configFile)) {
            $userDB = new PDO(
                "mysql:host=" . $ini['servername'] .
                ";port=" . $ini['port'] .
                ";dbname=" . $ini['dbname'],
                $ini['username'],
                $ini['password']
            );

            $userDB->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $userDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->userData = $userDB;
        } else {
            throw new Exception("<h2>Creation of database object failed!</h2>", 0, null);
        }
    }

    // fetches all states from the plugin_states database.
    public function getAllStates()
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT stateName FROM plugin_states");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Inserts signup information to the database.
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


    // compare the signed up userInnie to ones store in the db. If the userInniq exists already, an error will show in signup.php.
    function userUniqueInnie($userInnie)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT count(*) FROM plugin_users WHERE userInnie=:userInnie");


        $stmt->bindParam(
            ':userInnie',
            $userInnie
        );

        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        if ($number_of_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    // compare the signed up userName to ones store in the db. If the userName exists already, an error will show in signup.php.
    function userUniqueUN($userName)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT count(*) FROM plugin_users WHERE userName=:userName");


        $stmt->bindParam(
            ':userName',
            $userName
        );

        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        if ($number_of_rows > 0) {
            return false;
        } else {
            return true;
        }
    }


    public function getDatabaseRef()
    {
        return $this->userData;
    }


    // compare login info to the db. If the information is correct, allow login.
    public function isUserTrue($userName, $PW)
    {
        $isUserTrue = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("SELECT userPW, userSalt FROM plugin_users WHERE userName =:userName");

        $stmt->bindValue(':userName', $userName);

        $ifUserFound = ($stmt->execute() && $stmt->rowCount() > 0);

        if ($ifUserFound) {
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashPW = sha1($results['userSalt'] . $PW);
            $isUserTrue = ($hashPW == $results['userPW']);
        }
        return $isUserTrue;
    }

    // get's user details by their userInnie. (acceptable since innie is a unique identifer)
    public function getProfileByName($profileName)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_users WHERE userInnie = :profileName");
        $bindParameters = array(":profileName" => $profileName);

        if ($stmt->execute($bindParameters) && $stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // gets user details by the userID.
    public function getUserDetails($userID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_users WHERE userID = :userID");
        $bindParameters = array(":userID" => $userID);

        if ($stmt->execute($bindParameters) && $stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Get all users from the db. 
    public function getAllUsers()
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT userInnie FROM plugin_users ORDER BY userInnie ASC");

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
    // modTools.php function, used to update userInnie.
    // IMPORTANT NOTE: WHERE userInnie = :oldInnie AND isOwner ='NO'
    // isOwner is plugin's profile. Mods can not update the userInnie of an owner. (they are of higher clearance).
    // same logic can be used to create elevated roles, such as 'admins'. 
    public function modUpdateUser($newInnie, $oldInnie)
    {
        $isInnieUpdated = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("UPDATE plugin_users SET userInnie = :newInnie 
        WHERE userInnie = :oldInnie AND isOwner ='NO'");
        // where userInnie = oldInnie, means that the selected userInnie from the dropdown is a match to one in the db.
        // newInnie updates the userInnie of the user selected from the dropdown. 

        $bindParameters = array(
            ":newInnie" => $newInnie,
            ":oldInnie" => $oldInnie
        );

        $isInnieUpdated = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isInnieUpdated);
    }

    
    // modTools.php function, used to update categories.
    public function modUpdateCat($newCat, $oldCat)
    {
        $isCatUpdated = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("UPDATE plugin_categories SET catGenre = :newCat 
        WHERE catGenre = :oldCat");

        $bindParameters = array(
            ":newCat" => $newCat,
            ":oldCat" => $oldCat
        );

        $isCatUpdated = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isCatUpdated);
    }
    // modTools.php function, used to update conditions.
    public function modUpdateCond($newCond, $oldCond)
    {
        $isCondUpdated = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("UPDATE plugin_conditions SET condType = :newCond 
        WHERE condType = :oldCond");

        $bindParameters = array(
            ":newCond" => $newCond,
            ":oldCond" => $oldCond
        );

        $isCondUpdated = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isCondUpdated);
    }

    // modTools.php function, used to delete conditions.
    public function modDeleteCond($inputCond)
    {
        $isCondDeleted = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("DELETE FROM plugin_conditions WHERE condType = :inputCond");

        $bindParameters = array(
            ":inputCond" => $inputCond
        );

        $isCondDeleted = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isCondDeleted);
    }

    // modTools.php function, used to delete user accounts.
    public function modDeleteUser($inputInnie)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("DELETE FROM plugin_users WHERE userInnie = :inputInnie AND isOwner = 'NO'");
        $bindParameters = array(":inputInnie" => $inputInnie);

        if ($stmt->execute($bindParameters) && $stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Get's the userID from the logged in session['userID']. Where this function is called, it checks if isModerator =='YES'. 
    public function isUserMod($sessionID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_users WHERE userID = :sessionID");
        $bindParameters = array(":sessionID" => $sessionID);

        if ($stmt->execute($bindParameters) && $stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Get's the userID from the logged in session['userID']. Where this function is called, it checks if isModerator =='YES'. 
    public function headerModCheck($sessionID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_users WHERE userID = :sessionID");
        $bindParameters = array(":sessionID" => $sessionID);

        if ($stmt->execute($bindParameters) && $stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user['isModerator'] == 'YES') {
                return true;
            }
        }
        return false;
    }


    // Get's the details of a customer for a transaction. (Customer may be synonymous as 'receiver' in functionality)
    public function getCustomerDetails($customerID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_users WHERE userID = :customerID");
        $bindParameters = array(":customerID" => $customerID);

        if ($stmt->execute($bindParameters) && $stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // gets the userID where the userName is a match. Acceptable since userNames are also unique identifiers. 
    public function getUserId($username)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT userID FROM plugin_users WHERE userName = :username");
        $bindParameters = array(":username" => $username);
        $stmt->execute($bindParameters);
        $user = $stmt->fetch();
        return $user['userID'];
    }

    // gets the userID where the userInnie is a match. Acceptable since userInnie are also unique identifiers. 
    public function getUserIdByInnie($userInnie)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT userID FROM plugin_users WHERE userInnie = :userInnie");
        $bindParameters = array(":userInnie" => $userInnie);


        $stmt->execute($bindParameters);
        return $stmt->fetch();
    }


    // Why those functions over the general getUserDetails? I personally like it when code is more readable/understandable 
    // to the situation. I dont mind re-doing a method that gatheres the same data, but in a more specific way to whats needed. 
    // for me readability > minimalism. 


    // Updates the user's database information when their userID is a match.
    public function updateProfile($userName, $userInnie, $userBio, $userID, $userState, $isModerator)
    {

        $userTable = $this->userData;
        $stmt = $userTable->prepare("UPDATE plugin_users SET userName = :uName, userInnie = :uInnie, 
        userBio = :uBio, userState=:userState, isModerator=:isModerator
        WHERE userID = :userID");

        $bindParameters = array(
            ":uName" => $userName,
            ":uInnie" => $userInnie,
            ":uBio" => $userBio,
            ":userID" => $userID,
            ":userState" => $userState,
            ":isModerator" => $isModerator
        );

        return $stmt->execute($bindParameters);
    }

    // User can delete their accounts. UserID must match the logged in $_Session['userID']
    public function deleteAccount($sessionID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("DELETE FROM plugin_users WHERE userID = :sessionID");
        $bindParameters = array(":sessionID" => $sessionID);

        if ($stmt->execute($bindParameters) && $stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    // Whent the user delete's their account, delete all listings tied to their account.
    public function deleteAccountListings($sessionID)
    {
        $isListingDeleted = false;
        $userTable = $this->userData;
        $stmt = $userTable->prepare("DELETE FROM plugin_listings WHERE userID = :sessionID");
        $bindParameters = array(":sessionID" => $sessionID);

        $isListingDeleted = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isListingDeleted);
    }

    // Allows user to update their password.
    public function updatePW($userPW, $userID)
    {
        $userTable = $this->userData;

        $salt = random_bytes(32);
        $hashedPW = sha1($salt . $userPW);
        $stmt = $userTable->prepare("UPDATE plugin_users SET userPW = :uPW, userSalt = :uSalt WHERE userID = :userID");
        $bindParameters = array(
            ":uPW" => $hashedPW,
            ":uSalt" => $salt,
            ":userID" => $userID,
        );

        return $stmt->execute($bindParameters);
    }

    // Allows user to update their profile picture.
    public function updatePP($fileDestination, $userID)
    {
        $isUpdated = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("UPDATE plugin_users SET userPic = :fileDestination WHERE userID = :userID");

        $bindParameters = array(

            ":fileDestination" => $fileDestination,
            ":userID" => $userID
        );

        $isUpdated = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isUpdated);
    }

    // user for the search functionality. Finds a user by their userInnie. (again -> unique identifier)
    public function findUserByInnie($userInnie)
    {
        $results = array();
        $binds = array();
        $isFirstClause = true;
        $userTable = $this->userData;


        $sql = "SELECT userID, userName, userInnie, userBio, userPic FROM plugin_users";

        if (isset($userInnie)) {
            if ($isFirstClause) {
                $sql .= " WHERE ";
                $isFirstClause = false;
            } else {
                $sql .= " AND ";
            }
            $sql .= " userInnie LIKE :userInnie";
            $binds['userInnie'] = '%' . $userInnie . '%';
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
    ################# -- BEGINNING OF USER LISTINGS (MAIN)-- ##########################
    #######################################################################################
    #######################################################################################


    // functions are self explanitory here :D 
    public function getAllCategories()
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT catGenre FROM plugin_categories ORDER BY catGenre ASC");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllConditions()
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT condType FROM plugin_conditions");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllListings()
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_listings ORDER BY listProdPrice DESC");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    // for modTools.php
    public function modDeleteCat($inputCat)
    {
        $isCatDeleted = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("DELETE FROM plugin_categories WHERE catGenre = :inputCat");

        $bindParameters = array(
            ":inputCat" => $inputCat
        );

        $isCatDeleted = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isCatDeleted);
    }

    // for modTools.php
    public function modNewCat($inputCat)
    {
        $isCatPosted = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("INSERT INTO plugin_categories SET catGenre = :inputCat");

        $bindParameters = array(
            ":inputCat" => $inputCat,
        );

        $isCatPosted = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isCatPosted);
    }

    // for modTools.php
    public function modNewCond($inputCond)
    {
        $iCondPosted = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("INSERT INTO plugin_conditions SET condType = :inputCond");

        $bindParameters = array(
            ":inputCond" => $inputCond,
        );

        $iCondPosted = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($iCondPosted);
    }

    // Important. Take note of how the listing pictures are stored to fileDestinationX.
    // This is the logic for how pictures are stored in most functions. 

    public function postUserListing(
        $userID,
        $listProdCat,
        $listProdPrice,
        $listProdTitle,
        $listDesc,
        $listCond,
        $fileDestination,
        $listState,
        $listPostedOn,
        $fileDestination2,
        $fileDestination3,
        $fileDestination4
    )
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

    public function getUserListing($userID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_listings WHERE userID = :userID ORDER BY listProdPrice DESC");
        $bindParameters = array(
            ":userID" => $userID
        );
        $stmt->execute($bindParameters);
        return $stmt->fetchAll();
    }

    public function updateUserListing(
        $listID,
        $listProdCat,
        $listProdPrice,
        $listProdTitle,
        $listDesc,
        $listCond,
        $listState
    )
    {
        $isListPosted = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("UPDATE plugin_listings SET listProdCat = :listProdCat, 
        listProdPrice = :listProdPrice, listProdTitle = :listProdTitle, listDesc = :listDesc,
        listCond = :listCond, listState =:listState, listUpdatedOn=NOW() WHERE listID = :listID");

        $bindParameters = array(
            ":listID" => $listID,
            ":listProdCat" => $listProdCat,
            ":listProdPrice" => $listProdPrice,
            ":listProdTitle" => $listProdTitle,
            ":listDesc" => $listDesc,
            ":listCond" => $listCond,
            ":listState" => $listState,
        );

        $isListPosted = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isListPosted);
    }


    public function getListForm($listID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_listings WHERE listID = :listID");
        $bindParameters = array(":listID" => $listID);

        if ($stmt->execute($bindParameters) && $stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }


    public function deleteUserLising($listID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("DELETE FROM plugin_listings WHERE listID = :listID");
        $bindParameters = array(":listID" => $listID);

        if ($stmt->execute($bindParameters) && $stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    #############################################################
    #############################################################
    ### MESSAGE MANAGEMENT ###

    public function sendMessage(
        $parentID,
        $customerID,
        $sellerID,
        $listID,
        $messageTitle,
        $messageDesc,
        $fileDestination,
        $customerInnie,
        $sellerInnie,
        $fileDestination2,
        $fileDestination3,
        $fileDestination4,
        $isMessageReplied
    )
    {
        $isMsgSent = false;
        $userTable = $this->userData;

        $salt = random_bytes(32);

        $stmt = $userTable->prepare("INSERT INTO plugin_messages SET parentID=:parentID, customerID = :customerID, sellerID = :sellerID, 
        listID = :listID, messageTitle = :messageTitle, messageDesc = :messageDesc, messagePics =:fileDestination, 
        messageSentOn = NOW(), customerInnie=:customerInnie, sellerInnie=:sellerInnie, 
        messagePic2=:fileDestination2,messagePic3=:fileDestination3, messagePic4=:fileDestination4, isMessageReplied=:isMessageReplied");

        $bindParameters = array(
            ":parentID" => $parentID,
            ":customerID" => $customerID,
            ":sellerID" => $sellerID,
            ":listID" => $listID,
            ":messageTitle" => $messageTitle,
            ":messageDesc" => $messageDesc,
            ":fileDestination" => $fileDestination,
            ":customerInnie" => $customerInnie,
            ":sellerInnie" => $sellerInnie,
            ":fileDestination2" => $fileDestination2,
            ":fileDestination3" => $fileDestination3,
            ":fileDestination4" => $fileDestination4,
            ":isMessageReplied" => $isMessageReplied,

        );

        $isMsgSent = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isMsgSent);
    }

    // Every message sent from a request sets isMessageReplied == 'NO'.
    // This allows manipulation of CSS where a message is replied to, or not.
    // When a user replies to a message, this updates the previous isMessageReplied to 'YES'. 
    public function updateIsMessageReplied($priorMessageID, $updateStatus)
    {

        $isMsgSent = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("UPDATE plugin_messages SET isMessageReplied = :updateStatus 
        WHERE messageID = :priorMessageID");

        $bindParameters = array(
            ":updateStatus" => $updateStatus,
            ":priorMessageID" => $priorMessageID
        );

        $isMsgSent = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isMsgSent);
    }
    // note: the cycle is repeated.
    // 1: first message: isMessageReplied == 'NO'.
    // 2: reply message: isMessageReplied == 'YES' FOR THE PREVIOUS messageID (1). isMessageReplied == 'NO' for the new messageID (2).


    // Hides the conversation from everyone involved in the message. 
    // Does NOT delete the message from the database. 
    // In the future, modTools.php for a more elevated admin could retrieve messages if needed (?). 
    public function inboxHideConvo($parentID)
    {

        $isMsgHidden = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("UPDATE plugin_messages SET isMessageHidden = 'YES' 
        WHERE parentID = :parentID");

        $bindParameters = array(
            ":parentID" => $parentID
        );

        $isMsgHidden = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isMsgHidden);
    }



    public function getAllMessages($userID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_messages WHERE (sellerID = :userID) ORDER BY messageSentOn DESC");
        $bindParameters = array(
            ":userID" => $userID,
        );
        $stmt->execute($bindParameters);
        return $stmt->fetchAll();
    }

    // Gets the previous messages tied to the conversation (parentID of a message thread)
    public function getMessageCrumbs($listID, $parentID, $messageSentOn)
    {
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



    public function getMessageDetails($messageID)
    {
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

        if (isset($listProdTitle) || isset($listDesc)) {
            if ($isFirstClause) {
                $sql .= " WHERE ";
                $isFirstClause = false;
            } else {
                $sql .= " AND ";
            }
            $sql .= " (listProdTitle LIKE :listProdTitle OR listDesc LIKE :listDesc)";
            $binds['listProdTitle'] = '%' . $listProdTitle . '%';
            $binds['listDesc'] = '%' . $listDesc . '%';
        }

        if (isset($listProdCat)) {
            if ($isFirstClause) {
                $sql .= " WHERE ";
                $isFirstClause = false;
            } else {
                $sql .= " AND ";
            }
            $sql .= "  listProdCat LIKE :listProdCat";
            $binds['listProdCat'] = $listProdCat;
        }

        if (isset($listCond)) {
            if ($isFirstClause) {
                $sql .= " WHERE ";
                $isFirstClause = false;
            } else {
                $sql .= " AND ";
            }
            $sql .= "  listCond LIKE :listCond";
            $binds['listCond'] = $listCond;
        }

        if (isset($listState)) {
            if ($isFirstClause) {
                $sql .= " WHERE ";
                $isFirstClause = false;
            } else {
                $sql .= " AND ";
            }
            $sql .= " listState LIKE :listState";
            $binds['listState'] = '%' . $listState . '%';
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

    public function confirmSale($listID, $customerID, $sellerID, $orderID, $customerInnie,$sellerInnie,)
    {
        $isListSold = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("UPDATE plugin_listings SET isListSold='YES', customerID=:customerID, sellerID=:sellerID,timeListsold=NOW(), orderID = :orderID, customerInnie=:customerInnie, sellerInnie=:sellerInnie WHERE listID =:listID");

        $bindParameters = array(
            ":listID" => $listID,
            ":customerID" => $customerID,
            ":sellerID" => $sellerID,
            ":orderID" => $orderID,
            ":customerInnie" => $customerInnie,
            ":sellerInnie"=>$sellerInnie,
        );

        $isListSold = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isListSold);
    }

    public function defaultSaleMsg(
        $parentID,
        $customerID,
        $sellerID,
        $listID,
        $messageTitle,
        $messageDesc,
        $customerInnie,
        $sellerInnie
    )
    {
        $isMsgSent = false;
        $userTable = $this->userData;

        $salt = random_bytes(32);

        $stmt = $userTable->prepare("INSERT INTO plugin_messages SET parentID=:parentID, customerID = :customerID, sellerID = :sellerID, 
        listID = :listID, messageTitle = :messageTitle, messageDesc = :messageDesc,messageSentOn = NOW(), 
        customerInnie=:customerInnie, sellerInnie=:sellerInnie");

        $bindParameters = array(
            ":parentID" => $parentID,
            ":customerID" => $customerID,
            ":sellerID" => $sellerID,
            ":listID" => $listID,
            ":messageTitle" => $messageTitle,
            ":messageDesc" => $messageDesc,
            ":customerInnie" => $customerInnie,
            ":sellerInnie" => $sellerInnie,

        );

        $isMsgSent = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);
        return ($isMsgSent);
    }

    public function getSaleHistory($userID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT * FROM plugin_listings WHERE userID = :userID AND isListSold = 'Yes' ORDER BY timeListsold DESC");
        $bindParameters = array(
            ":userID" => $userID
        );
        $stmt->execute($bindParameters);
        return $stmt->fetchAll();
    }
    public function getPurchaseHistory($userID)
    {
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

    public function giveUserRating($userID, $userRating, $orderID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("INSERT INTO plugin_user_ratings SET userID=:userID, userRating=:userRating, orderID=:orderID");
        $bindParameters = array(
            ":userID" => $userID,
            "userRating" => $userRating,
            "orderID" => $orderID
        );
        $stmt->execute($bindParameters);
        return true;
    }
    

    function isAlreadyRated($orderID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT count(*) FROM plugin_user_ratings WHERE orderID=:orderID");


        $stmt->bindParam(
            ':orderID',
            $orderID
        );

        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        if ($number_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAvgRating($userID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT AVG(userRating) AS userRating FROM plugin_user_ratings WHERE userID = :userID");
        $stmt->execute(array(':userID' => $userID));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $rating = round($result['userRating'] * 2) / 2; 
            return $rating >= 1 ? $rating : 0;
        } else {
            return 0;
        }
    }
    

    function getRatingCount($userID)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT count(userID) FROM plugin_user_ratings WHERE userID=:userID");


        $stmt->bindParam(
            ':userID',
            $userID
        );

        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        if ($number_of_rows > 0) {
            return $number_of_rows;
        }
    }

}

?>