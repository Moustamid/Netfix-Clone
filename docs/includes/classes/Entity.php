<?php
   
    //  Get an  Entity  by her id '$input' ,  if '$input' = SQL Array  use '$input' (get random entity)

class Entity {
    
    private $connect ;
    private $sqlData ;
  
    public function __construct($connect , $input){
       
      $this->connect = $connect;
      
      if( is_array($input) ){
        
        $this->sqlData = $input;

         }else {

          $query = $this->connect->prepare("SELECT * FROM entities WHERE id=:id");
          $query->bindValue(":id" , $input);
          $query->execute();

          $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);

         }        
      }


    public function getId(){
       
      return $this->sqlData["id"];

    }

    public function getName(){
       
      return $this->sqlData["name"];

    }

    public function getThumbnail(){
       
      return $this->sqlData["thumbnail"];

    }

    public function getPreview(){
       
      return $this->sqlData["preview"];

    }

    public function getCategoryId() {

      return $this->sqlData["categoryId"];
  }
    


   // get all the seasons and video of this Entity
   public function getSeasons() {
    $query = $this->connect->prepare("SELECT * FROM videos WHERE entityId=:id
                                AND isMovie=0 ORDER BY season, episode ASC");
    $query->bindValue(":id", $this->getId());
    $query->execute();

    $seasons = array();
    $videos = array();
    $currentSeason = null;
    while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        
        if($currentSeason != null && $currentSeason != $row["season"]) {
            $seasons[] = new Season($currentSeason, $videos);
            $videos = array();
        }

        $currentSeason = $row["season"];
        $videos[] = new Video($this->connect, $row);

    }

    if(sizeof($videos) != 0) {
        $seasons[] = new Season($currentSeason, $videos);
    }

    return $seasons;
}
    

 
}




?>