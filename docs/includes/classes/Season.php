<?php
    //  creat a season of the videos input array
class Season {

  private $seasonNumber ;
  private $videos ;

  public function __construct($seasonNumber , $videos){
      
      $this->seasonNumber = $seasonNumber ;
      $this->videos = $videos ;
 
  }

 
 public function getSeasonNumber(){

    return  $this->seasonNumber;
 }

 public function getVideos(){

    return $this->videos;
    
 }





}






?>