<?php 
  //call other files
  include_once "../model/userController.php";
  include_once "../include/functions.php";
  include_once "../include/header.php";

   //if not logged in, kick them
   if (!isUserLoggedIn())
   {
      header("location: ../login.php"); 
   }
?>

   <div style="padding: 15px;">
      <br>
      <p>Congrats, you signed in correctly<p> 
   </div>

</body>
</html>

<!-- Why does this .php page have closing tags for body and html? 
This is because the metadata and starting divs were created in header.php ("include" folder), and referenced with PHP above. -->