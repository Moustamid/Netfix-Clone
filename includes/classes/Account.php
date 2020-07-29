<?php

  class Account {
   

    private $connect ; 
    private $errorArray = array();


    public function __construct($connect){

       $this->connect = $connect ;

    }
    
      // register  (pour les nouveaux utiliateurs : (1) validation // (2) errorArray = empty // 
                                                // (3) inserer des donne sur la BD (creation de compte)  )

    public function register($fn , $ln , $un , $em , $em2 , $pw , $pw2 ){

       $this->validateFirstName($fn);
       $this->validateLastName($ln);
       $this->validateUserName($un);
       $this->validateEmails($em , $em2);
       $this->validatePasswords($pw , $pw2);

       if( empty($this->errorArray) ){
         return  $this->insertUserDetails($fn , $ln , $un , $em  , $pw );
        }
        
        return false ;
        
      }
       
      // login  (pour les uriliateur existant : donne deja sur la base )
      
    public function login( $un , $pw ){
        
        $pw = hash("sha512" , $pw);
        
        $query = $this->connect->prepare("SELECT * FROM users WHERE username=:un AND password=:pw ");
        
        $query->bindValue(":un",$un );
        $query->bindValue(":pw",$pw );
        
        $query->execute() ;

        if($query->rowCount() == 1){
            return true ; 
        }
        
        array_push($this->errorArray ,  Constants::$loginFailed ) ;
        return false ; 

    }
    
       // inserer les donne de utilisateur ( pas error detecte , array : vide )  

    private function insertUserDetails($fn , $ln , $un , $em  , $pw ){
       
        $pw = hash("sha512" , $pw);

        $query = $this->connect->prepare("INSERT INTO users  (firstName , lastName , username , email , password ) 
                                          VALUES ( :fn , :ln , :un , :em  , :pw) ");
        $query->bindValue(":fn",$fn );
        $query->bindValue(":ln",$ln );
        $query->bindValue(":un",$un );
        $query->bindValue(":em",$em );
        $query->bindValue(":pw",$pw );
        
        return $query->execute() ;


    }
      
      //  les fonction de validation  :


      private function validateFirstName($fn){
                
            if( strlen($fn) < 2 || strlen($fn) >25 ){
          array_push($this->errorArray , Constants::$firstNameCharacters) ;   
        }
      }
 
      private function validateLastName($ln){
        
            if( strlen($ln) < 2 || strlen($ln) >25 ){
              array_push($this->errorArray , Constants::$lastNameCharacters) ;   
              }
            }
        
      private function validateUserName($un){
          
          if( strlen($un) < 2 || strlen($un) >25 ){
            array_push($this->errorArray , Constants::$userNameCharacters) ;
            return;   
          }
          
          
          $query = $this->connect->prepare("SELECT * FROM users WHERE username=:un");
          $query->bindValue(":un",$un);
          
          $query->execute();
          
          if($query->rowCount() != 0){
            array_push($this->errorArray , Constants::$userNameTaken) ;   
            
          }
          
          
        }


        private function validateEmails($em , $em2){
        
          if( $em != $em2 ){
          array_push($this->errorArray , Constants::$emailsDontMatch) ; 
          return;  
        }
        
        if(!filter_var($em , FILTER_VALIDATE_EMAIL)){
          array_push($this->errorArray , Constants::$emailInvalid) ; 
          return;  
        }
        
        $query = $this->connect->prepare("SELECT * FROM users WHERE email=:em");
        $query->bindValue(":em",$em);
        
        $query->execute();
        
        if($query->rowCount() != 0){
          array_push($this->errorArray , Constants::$EmailTaken) ;   
          
        }
        
      }
      
      
      private function validatePasswords($pw , $pw2){
        
        if( $pw != $pw2 ){
        array_push($this->errorArray , Constants::$passwordsDontMatch) ; 
        return;  
      }

      if( strlen($pw) < 2 || strlen($pw) >25 ){
        array_push($this->errorArray , Constants::$passwordLength) ;
        return;   
      }


      }
      
     // afficher les errur dynamiquement : constants.php

      public function getError($error){
        
     if(in_array($error , $this->errorArray )){
       
       return  "<span class='errorMessage'>$error</span>" ;

      }
      
    }

    
  }
 


?>