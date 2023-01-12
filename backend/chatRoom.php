<?php 
   session_start();
   include_once '../include/functions.php';
   include_once '../include/header.php';
   include_once '../model/userController.php';

   if (!array_key_exists('isLoggedIn', $_SESSION) || !$_SESSION['isLoggedIn'])
   {
      header("location: ../login.php"); 
      exit;
   }
   

   $message = "";
   $configFile = '../model/dbconfig.ini';
   try 
   {
      $userDatabase = new Users($configFile);
   } 
   catch ( Exception $error ) 
   {
      echo "<h2>" . $error->getMessage() . "</h2>";
   }   

   $userID = $_SESSION['userID'];
   $userInfo = $userDatabase->getUserDetails($userID);

?>

<!-- specific CSS to this chat room -->
<link rel="stylesheet" href="chatStyle.css">


  <div id="page-wrapper">
    <h1>LIVE CHAT ROOM</h1>

    <div id="status">Plugging into room..</div>

    <ul id="messages"></ul>

    <form id="message-form" action="#" method="post">
      <textarea id="message" placeholder="Say something nice!" required></textarea>
      <button type="submit">Send</button>
      <button type="button" id="close">Unplug Chat</button>
      <a href="chatRoom.php"><button type="button" id="">Re-plug Chat</button></a>
    </form>
  </div>

   <!-- sends the PHP variable $userInfo into a JS global variable 'userInnie'
        This way when chat is sent, users will know who it's from -->
  <script>
    window.userInnie = <?php echo json_encode($userInfo['userInnie']); ?>;
  </script>

  <!-- The JS file that handles all the bts logic -->
  <script src="chatApp.js"></script>
</body>
</html>