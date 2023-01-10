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
    
    public function userSignup($userName, $PW) 
    {
        $isUserAdded = false;        
        $userTable = $this->userData; 

        $salt = random_bytes(32); 

        $stmt = $userTable->prepare("INSERT INTO se265users SET userName = :uName, userPW = :uPW, userSalt = :uSalt");

        $bindParameters = array(
            ":uName" => $userName,
            ":uPW" => sha1($salt . $PW),
            ":uSalt" => $salt 
            # I found that w/o doing bin2hex, the signup will throw an error. 
            # (Inserting a binary string into a MySQL Column that doesnt support it). 
            # Because of this bin2hex, the below function, isUserTrue ,will now need to unconvert this b4 processing. 
        );       
        
        $isUserAdded = ($stmt->execute($bindParameters) && $stmt->rowCount() > 0);

        return ($isUserAdded);
    }
   

    // DELETE user record.
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
 
   // pull ONE user record.
    public function getUserRecord($id) 
    {
        $results = [];                  
        $userTable = $this->userData;
    
        return ($results);
    }


    // Ensure user entered correct login details.
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

}
?>