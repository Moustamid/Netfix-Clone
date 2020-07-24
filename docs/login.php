<?php
  
  require_once("includes/classes/FormSanitizer.php");
  require_once("includes/config.php");
  require_once("includes/classes/Account.php");
  require_once("includes/classes/Constants.php");
  
  $account = new Account($connect);

  if( isset($_POST['submit'] ) ){
     
     
    $userName   = FormSanitizer::sanitizeFromUsername( $_POST['userName'] ) ;
    
    $password   = FormSanitizer::sanitizeFromPassword( $_POST['password'] ) ;
    
    
    $success = $account->login($userName ,  $password );
    
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
           <h3>Sign in</h3>
           <span>to Continue to VideoTube </span>

        </div> 

        <form action="" method="POST">
            
        <?php echo $account->getError(Constants::$loginFailed); ?>  
          <input type="text"  name="userName" placeholder="User Name" value="<?php getInputValue("userName"); ?>"  require >
          
          <input type="password" name="password" placeholder="password"require >
          
          <input type="submit" name="submit" value="submit">

        </form>

        <a href="register.php" class="signInMessage">Need an account? Sign un here</a>

     </div>
  
  
  </div>

</body>
</html>