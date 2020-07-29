<?php
  
  require_once("includes/header.php");


   $preview = new PreviewProvider($connect , $userLoggedIn  );  
   echo $preview->createPreviewVideo(NULL); 

   $preview = new CategoryContainers($connect , $userLoggedIn  );  
   echo $preview->showAllCategories(); 


?> 








