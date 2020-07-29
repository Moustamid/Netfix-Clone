<?php
  
  require_once("includes/header.php");


   $preview = new PreviewProvider($connect , $userLoggedIn  );  
   echo $preview->creatTVShowPreviewVideo(); 

   $preview = new CategoryContainers($connect , $userLoggedIn  );  
   echo $preview->showTVShowCategories(); 


?> 




