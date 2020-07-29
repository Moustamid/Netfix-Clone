<?php
  
  require_once("includes/header.php");


   $preview = new PreviewProvider($connect , $userLoggedIn  );  
   echo $preview->creatMoviePreviewVideo(); 

   $preview = new CategoryContainers($connect , $userLoggedIn  );  
   echo $preview->showMovieCategories(); 


?> 




 