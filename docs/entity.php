<?php
  
  require_once("includes/header.php");

  if(!isset($_GET["id"])){

      ErrorMessage::show("No ID passed into page");

  }

  $entityId = $_GET["id"];
  $entity = new Entity( $connect , $entityId );
   

  $preview = new PreviewProvider($connect , $userLoggedIn  );  
   echo $preview->createPreviewVideo($entity);
  
   
  $seasonProvider = new SeasonProvider( $connect , $userLoggedIn );
   echo $seasonProvider->create($entity);

  $seasonProvider = new CategoryContainers( $connect , $userLoggedIn );
   echo $seasonProvider->showCategory($entity->getCategoryId() , "You might also like" );
   
        


?>  