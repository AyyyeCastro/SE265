<?php
$configFile = '../model/dbconfig.ini';
try {
   $userDatabase = new Users($configFile);
} catch (Exception $error) {
   echo "<h2>" . $error->getMessage() . "</h2>";
}

// set the default avie url.
$defaultAvie = "../include/default-avie/default-avie.jpg";

// declare arrays
$selected = "";
$search_option = "";
$userArray = [];
$listProdTitle = "";
$userInnie = "";
$prodTitle = "";
$listState = "";
$listProdTitle = "";
$listProdCat = "";
$listCond = "";
$listDesc = "";


// Fill the listings before criteria
$userArray = $userDatabase->findUserByInnie($userInnie);
$listArray = $userDatabase->findListAdvanced($listProdTitle, $listDesc, $listProdCat, $listCond, $listState);
// Get all of the category genres from the database. Fills dropdown list.
$catList = $userDatabase->getAllCategories();
// Get all of the condition types from the database. Fills dropdown list.
$condList = $userDatabase->getAllConditions();
// Get all of the States from the database. Fills dropdown list.
$stateList = $userDatabase->getAllStates();


// IMPORTANT
// Why Get request? 
// It stores the results of the user's search into the URL. 
{
   // if they clicked the search button ->
   if (isset($_GET["search"])) {
      $search_option = filter_input(INPUT_GET, 'search_option');
      // if the user selected to search for sellers
      if ($search_option == 'Products' || $search_option == $selected || $search_option == $selected) {
         // declare the variables to nothing first...
         $listProdTitle = "";
         $listDesc = "";
         //... have the user's input (from form below) allign with the declared variables. 
         $listProdTitle = $_GET['inputName'];
         $listDesc = $_GET['inputName'];
         $listProdCat = filter_input(INPUT_GET, 'listProdCat');
         $listCond = filter_input(INPUT_GET, 'listCond');
         $listState = filter_input(INPUT_GET, 'listState');
         // have the array (declared above) store the info, and send it to the findOneCollection function.
         $listArray = $userDatabase->findListAdvanced($listProdTitle, $listDesc, $listProdCat, $listCond, $listState);
      }
      if ($search_option == 'Sellers') {
         // declare the variables to nothing first...
         $userInnie = "";
         //... have the user's input (from form below) allign with the declared variables. 
         $userInnie = $_GET['inputName'];
         // have the array (declared above) store the info, and send it to the findOneCollection function.
         $userArray = $userDatabase->findUserByInnie($userInnie);
      }
   } else {
      //Otherwise gather all records.
      $listArray = $userDatabase->getAllListings();
   }

   $maxResults = 17; // number of results to show per page
   $totalResults = count($listArray); // total number of results
   $pageCount = ceil($totalResults / $maxResults); // calculate total pages

   if (isset($_GET['page']) && is_numeric($_GET['page'])) {
      $onPage = (int) $_GET['page'];
   } else {
      $onPage = 1; // default page number
   }
   if ($onPage > $pageCount) {
      $onPage = $pageCount;
   }
   if ($onPage < 1) {
      $onPage = 1;
   }

   $indexStart = ($onPage - 1) * $maxResults;
   $end_index = $indexStart + $maxResults;
   $listArray = array_slice($listArray, $indexStart, $maxResults);
}
?>