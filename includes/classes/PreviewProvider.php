<?php

  
    

class  PreviewProvider {

  private $connect ; 
  private $username ;
    
   public function __construct($connect , $username){
       
       $this->connect = $connect  ;
       $this->username = $username  ;

   }

    //  TV Show Preview Video

   public function creatTVShowPreviewVideo(){
     
        $entitiesArray = EntityProvider::getTVShowEntities($this->connect , null, 1);
       
        if(sizeof($entitiesArray) == 0 ){
          ErrorMessage::show("No TV shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]) ;

   }

   //  Movies Preview Video

   public function creatMoviePreviewVideo(){
     
        $entitiesArray = EntityProvider::getMovieEntities($this->connect , null, 1);
       
        if(sizeof($entitiesArray) == 0 ){
          ErrorMessage::show("No Movies to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]) ;

   }

   // Category Preview Videos

   public function creatCategoryPreviewVideo($categoryId){
     
    $entitiesArray = EntityProvider::getEntities($this->connect , $categoryId  , 1);
   
    if(sizeof($entitiesArray) == 0 ){
      ErrorMessage::show("No TV shows to display");
    }

    return $this->createPreviewVideo($entitiesArray[0]) ;

}

  // ************************** createPreviewVideo **************************** //
     // if NUll creat random Preview if not creat a Preview  for the $entity

    public function createPreviewVideo($entity){
              
          if($entity == NULL){

            $entity = $this->getRandomEntity();

          }   
          
          $id = $entity->getId();
          $name = $entity->getName();
          $preview = $entity->getPreview();
          $thumbnail  = $entity->getThumbnail();
         
          

          $videoId = VideoProvider::getEntityVideoForUser($this->connect , $id , $this->username );
          $video = new Video($this->connect , $videoId );
          
          $isInProgress = $video->isInProgress($this->username);
          $plaButtonText = $isInProgress ? "Continue watching" : "play";

          $seasonEpisode = $video->getSeasonAndEpisode();
          $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";

          return    " <div class = 'previewContainer'> 
          
                        <img src='$thumbnail' class='previewImage'  hidden>  

                        <video autoplay muted class='previewVideo'  onended='previewEnded()' > 
                          <source src='$preview' type='video/mp4' >
                        </video>

                        <div class='previewOverlay'>
                            <div class='mainDetails'>
                                <h3>$name</h3>
                                  $subHeading
                                <div class='buttons' >
                                  <button  onclick='watchVideo($videoId)'><i class='fas fa-play'></i> $plaButtonText </button>
                                  <button  onclick='volumeToggle(this)' ><i class='fas fa-volume-mute'></i></button>
                                </div>
                                
                            </div>
                        </div>


                  
                      </div>";
    
                    }
    
          
        //  get a Random Entity  from the DB          

    private function getRandomEntity(){
         
        $entity =  EntityProvider::getEntities($this->connect , NULL , 1 );
        return $entity[0];
    }
    



    public function createEntityPreviewSquare($entity){

       $id= $entity->getId();  
       $thumbnail= $entity->getThumbnail();  
       $name= $entity->getName();  

       return "<a href='entity.php?id=$id'>
                  <div class ='previewContaner small'>
                     <img src='$thumbnail' title='$name' >
                  </div>
               </a>";

    }










}





?>