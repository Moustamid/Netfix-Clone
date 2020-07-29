<?php
  
  require_once("includes/header.php");

  if(!isset($_GET["id"])){

     ErrorMessage::show("No id passed to page");
  }


   $preview = new PreviewProvider($connect , $userLoggedIn  );  
   echo $preview->creatCategoryPreviewVideo($_GET["id"]); 

   $preview = new CategoryContainers($connect , $userLoggedIn  );  
   echo $preview->showCategory($_GET["id"]); 


?> 




 