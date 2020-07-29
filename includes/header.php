<?php
   
   require_once("includes/config.php");
   require_once("includes/classes/PreviewProvider.php");
   require_once("includes/classes/Entity.php");
   require_once("includes/classes/categoryContainers.php");
   require_once("includes/classes/EntityProvider.php");
   require_once("includes/classes/ErrorMessage.php");
   require_once("includes/classes/seasonProvider.php");
   require_once("includes/classes/Video.php");
   require_once("includes/classes/Season.php");
   require_once("includes/classes/VideoProvider.php");
   
   if( !isset( $_SESSION["userLoggedIn"] ) ){
       header(" Location: register.php ");
   }
  
   $userLoggedIn = $_SESSION["userLoggedIn"] ;

   ?>


   
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="assets/js/script.js" ></script>

  <link rel="stylesheet" type="text/css" href="assets/css/style.css" >
  <title>Welcome to Netflix</title>
</head>
<body>
  
     <div class="container">
     

     <!-- Navbar -->

 <?php
    if(!isset($hideNav)){
        include_once("includes/navBar.php");
    }
 ?>  
     
     
   
   


