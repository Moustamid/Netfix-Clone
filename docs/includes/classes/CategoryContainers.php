<?php

  
    

class  CategoryContainers {

  private $connect ; 
  private $username ;
    
        public function __construct($connect , $username){
            
            $this->connect = $connect  ;
            $this->username = $username  ;

        }


    public function showAllCategories(){
        
        $query = $this->connect->prepare("SELECT * FROM categories") ; 
        $query->execute();

        $html = "<div class='prevewCategories'>";

          while($row = $query->fetch(PDO::FETCH_ASSOC)){
              
              $html .=$this->getCategoryHtml($row , NULL , TRUE , TRUE );

          }


        return $html . "</div>";

    }
    
    public function showTVShowCategories(){
        
        $query = $this->connect->prepare("SELECT * FROM categories") ; 
        $query->execute();

        $html = "<div class='prevewCategories'>
                     <h1>TV Shows</h1>";

          while($row = $query->fetch(PDO::FETCH_ASSOC)){
              
              $html .=$this->getCategoryHtml($row , NULL , TRUE , FALSE );

          }


        return $html . "</div>";

    }
    
    public function showMovieCategories(){
        
        $query = $this->connect->prepare("SELECT * FROM categories") ; 
        $query->execute();

        $html = "<div class='prevewCategories'>
                     <h1>Movies</h1>";

          while($row = $query->fetch(PDO::FETCH_ASSOC)){
              
              $html .=$this->getCategoryHtml($row , NULL , FALSE , TRUE );

          }


        return $html . "</div>";

    }

    
    public function showCategory($categoryId , $title = null ){

      $query = $this->connect->prepare("SELECT * FROM categories WHERE id=:id") ; 
      $query->bindValue(":id" , $categoryId );
      $query->execute();

        $html = "<div class='prevewCategories'>";

          while($row = $query->fetch(PDO::FETCH_ASSOC)){
              
              $html .=$this->getCategoryHtml($row , $title , TRUE , TRUE );

          }


        return $html . "</div>";

    }


    private function getCategoryHtml( $sqlData , $title , $tvshows , $movies ){
        
            $categoryId = $sqlData["id"]; 
            $title = $title == null ? $sqlData["name"] : $title ;
            

           if( $tvshows && $movies){

           $entities = EntityProvider::getEntities($this->connect , $categoryId , 80);
           
          } else if ($tvshows){
            
            // GET tv show entities
            $entities = EntityProvider::getTVShowEntities($this->connect , $categoryId , 80);
            
          } else {
            
            // GET movies entities
            $entities = EntityProvider::getMovieEntities($this->connect , $categoryId , 80);
               

           }

          
          if( sizeof($entities) == 0 ){
              return ;
          } 




          $entitiesHtml = "";
          
          $previewProvider = new PreviewProvider( $this->connect , $this->username ); 
          
          foreach( $entities as $entity ){
            
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);

            }
           
          
            return " <div class ='category' >
                       
                     <a href='category.php?id=$categoryId' >
                        <h3>$title<h3/> 
                     </a>

                     <div class='entities scrollbars_none'>
                          $entitiesHtml
                     </div>
            
                    </div> ";
           
 
    }

      

  }

 ?>   