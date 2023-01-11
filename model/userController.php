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

    public function getUsers() 
    {
        $userTable = $this->userData;
        $results = [];                 
       return ($results);
    }
    
    public function userSignup($userName, $PW, $userInnie, $userBio, $fileDestination)
    {
        $isUserAdded = false;        
        $userTable = $this->userData; 

        $salt = random_bytes(32); 

        $stmt = $userTable->prepare("INSERT INTO se265users SET userName = :uName, userPW = :uPW, userSalt = :uSalt, userInnie = :uInnie, userBio = :uBio, userPic = :fileDestination");

        $bindParameters = array(
            ":uName" => $userName,
            ":uPW" => sha1($salt . $PW),
            ":uSalt" => $salt,
            ":uInnie" => $userInnie,
            ":uBio" => $userBio,
            ":fileDestination" => $fileDestination
        );       

        #---- Important to notes ----#
            # userBio will not be filled by the user during this sign up. It will be a hidden form in signUp.php with a default value of "Say something about your self".
            # This is just to have the MySQL column (userBio) injected upon signup, and automatically relate the bio with the userID upon signing up. 
            # This will allow for an easy update script in a future function.
        
        $isUserAdded = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);

        return ($isUserAdded);
    }


    // ------ This may have been one way to insert a userBio. But, instead I went with the method in the userSignup function. ------- ///
    // public function userBioInsert($userBio, $userInnie)
    // {
    //     $isBioAdded = false;        
    //     $userTable = $this->userData; 


    //     $stmt = $userTable->prepare("INSERT INTO se265users SET userBio = :uBio WHERE userInnie =:uInnie");
    //     # it's important to note that userInnie's will HAVE to be a unique, one user handle. If two user's share the same innie, then the program will update BOTH user's bios. 
    //     # This requirement of unique handles is handled in ...  NEEDS TO BE DONE

    //     $bindParameters = array(
    //         ":uBio" => $userBio,
    //         ":uInnie" => $userInnie 
    //     );       
        
    //     $isBioAdded = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);

    //     return ($isBioAdded);
    // }

    public function userDelete ($id) 
    {
        $isUserDeleted = false;     
        $userTable = $this->userData; 

        return ($isUserDeleted);
    }
    public function getDatabaseRef()
    {
        return $this->userData;
    }
 
    public function getUserRecord($id) 
    {
        $results = [];                  
        $userTable = $this->userData;
    
        return ($results);
    }

    public function isUserTrue($userName, $PW)
    {
        $isUserTrue = false;
        $userTable = $this->userData;

        $stmt = $userTable->prepare("SELECT userPW, userSalt FROM se265users WHERE userName =:userName");
 
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
        $stmt = $userTable->prepare("SELECT * FROM se265users WHERE userID = :userID");
        $bindParameters = array(":userID" => $userID);
        
        if($stmt->execute($bindParameters) && $stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getUserId($username)
    {
        $userTable = $this->userData;
        $stmt = $userTable->prepare("SELECT userID FROM se265users WHERE userName = :username");
        $bindParameters = array(":username" => $username);
        $stmt->execute($bindParameters);
        $user = $stmt->fetch();
        return $user['userID'];
    }

    public function updateProfile($userName, $PW, $userInnie, $userBio, $userID)
    {
        $userTable = $this->userData; 
        
        if($PW)
        {
            $salt = random_bytes(32);
            $hashedPW = sha1($salt . $PW);
            $stmt = $userTable->prepare("UPDATE se265users SET userName = :uName, userPW = :uPW, userSalt = :uSalt, userInnie = :uInnie, userBio = :uBio WHERE userID = :userID ");
            $bindParameters = array(
                ":uName" => $userName,
                ":uPW" => $hashedPW,
                ":uSalt" => $salt,
                ":uInnie" => $userInnie,
                ":uBio" => $userBio ,
                ":userID" => $userID
            );
        }else{
            $stmt = $userTable->prepare("UPDATE se265users SET userName = :uName, userInnie = :uInnie, userBio = :uBio WHERE userID = :userID");
            $bindParameters = array(
                ":uName" => $userName,
                ":uInnie" => $userInnie,
                ":uBio" => $userBio ,
                ":userID" => $userID
            );
        }    
        return $stmt->execute($bindParameters);
    }

}
?>