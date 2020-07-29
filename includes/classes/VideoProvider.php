<?php

class VideoProvider {
  
   public static  function getUpNext($connect , $currentVideo){

         $query = $connect->prepare(" SELECT * FROM videos 
                    WHERE entityId=:entityId AND id !=:videoId 
                    AND (   ( season = :season AND episode > :episode ) 
                                                   OR season > :season )
                    ORDER BY season , episode ASC LIMIT 1  ")  ;

         $query->bindValue(":entityId" ,  $currentVideo->getEntityId() );
         $query->bindValue(":season"   ,  $currentVideo->getSeasonNumber() );
         $query->bindValue(":episode"  ,  $currentVideo->getEpisodeNumber() );
         $query->bindValue(":videoId"  ,  $currentVideo->getId() );
         
         $query->execute();
         
         if( $query->rowCount() == 0 ){
           
           $query = $connect->prepare("SELECT * FROM videos 
                                            WHERE season <=1 AND episode <=1 
                                            AND  id != :videoId
                                            ORDER BY views DESC LIMIT 1 ");
           $query->bindValue(":videoId"  ,  $currentVideo->getId() );
           $query->execute();
         }
       
         $row = $query->fetch(PDO::FETCH_ASSOC);
         return new Video($connect , $row);
   }
   
    public static function getEntityVideoForUser($connect , $entityId , $username){
      
       $query = $connect->prepare("SELECT videoId FROM videoprogress
                                    INNER JOIN videos 
                                    ON videoprogress.videoId = videos.id 
                                    WHERE videos.entityId =:entityId
                            AND videoprogress.username =:username
                            ORDER BY videoprogress.dateModified DESC
                            LIMIT 1 ");

      $query->bindValue(":entityId" , $entityId);
      $query->bindValue(":username" , $username);
      
      $query->execute();
      
      if($query->rowCount() == 0){
        $query = $connect->prepare("SELECT * FROM videos WHERE entityId=:entityId
                                      ORDER BY season , episode ASC LIMIT 1");
        $query->bindValue(":entityId" , $entityId);
        $query->execute();
      }

      return  $query->fetchColumn();
   
    }



}






?>