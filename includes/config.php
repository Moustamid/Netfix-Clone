<?php
 
 ob_start();
 session_start();

 $timezone = date_default_timezone_set("America/Mexico_City");

 try {
       
     $connect = new PDO("mysql:dbname=netflix;host=localhost" , "root" ,"");
     $connect->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_WARNING);
   
 } catch (PDOException $e) {
       
      exit("Connection failed: " . $e->getMessage());

 }



?> 