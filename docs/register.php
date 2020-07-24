<?php
   
   require_once("includes/classes/FormSanitizer.php");
   require_once("includes/config.php");
   require_once("includes/classes/Account.php");
   require_once("includes/classes/Constants.php");
   

   $account = new Account($connect);
   
  if( isset($_POST['submit'] ) ){
     

     $firstName  = FormSanitizer::sanitizeFromString( $_POST['firstName'] ) ;
     $lastName   = FormSanitizer::sanitizeFromString( $_POST['lastName'] ) ;
     
     $userName   = FormSanitizer::sanitizeFromUsername( $_POST['userName'] ) ;
     
     $email      = FormSanitizer::sanitizeFromEmail( $_POST['email'] ) ;
     $email2     = FormSanitizer::sanitizeFromEmail( $_POST['email2'] ) ;
     
     $password   = FormSanitizer::sanitizeFromPassword( $_POST['password'] ) ;
     $password2  = FormSanitizer::sanitizeFromPassword( $_POST['password2'] ) ;
     
     $success    = $account->register($firstName , $lastName , $userName , $email , $email2 , $password , $password2 );
     
     if($success){
         
         $_SESSION["userLoggedIn"] = $userName;
         header("Location: index.php");
     }
   
   }

   function getInputValue($Name){

      if( isset( $_POST['$Name'] ) ){
         echo $_POST['$Name'];
      }
    }


 
    


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css" >
  <title>Welcome to Netflix</title>
</head>
<body>
  
  <div class="signInContainer">
    
     <div class="column">
        <div class="header">
           <img src="assets/images/logo.png" title="logo" alt="Site logo">
           <h3>Sign up</h3>
           <span>to Continue to VideoTube </span>

        </div> 

        <form action="" method="POST">

          <?php echo $account->getError(Constants::$firstNameCharacters); ?>  
          <input type="text"  name="firstName" placeholder="First Name" value="<?php getInputValue("firstName"); ?>"  require >
          
          <?php echo $account->getError(Constants::$lastNameCharacters); ?>  
          <input type="text"  name="lastName" placeholder="Last Name" value="<?php getInputValue("lastName"); ?>" require >

          <?php echo $account->getError(Constants::$userNameCharacters ); ?>  
          <?php echo $account->getError(Constants::$userNameTaken ); ?>  
          <input type="text"  name="userName" placeholder="User Name" value="<?php getInputValue("userName"); ?>" require >
          
          
          <?php echo $account->getError(Constants::$emailsDontMatch ); ?>  
          <?php echo $account->getError(Constants::$EmailTaken ); ?>  
          <input type="email" name="email" placeholder="Email"  value="<?php getInputValue("email"); ?>" require >
          <input type="email" name="email2" placeholder="Confirm email" value="<?php getInputValue("email2"); ?>" require >
          
          <?php echo $account->getError(Constants::$passwordsDontMatch ); ?>  
          <?php echo $account->getError(Constants::$passwordLength ); ?>  
          <input type="password" name="password" placeholder="password"require >
          <input type="password" name="password2" placeholder="Confirm password" require >
          
          <input type="submit" name="submit" value="SUBMIT">

        </form>

        <a href="login.php" class="signInMessage">Already have an account? Sign in here</a>

     </div>
  
  
  </div>

</body>
</html>