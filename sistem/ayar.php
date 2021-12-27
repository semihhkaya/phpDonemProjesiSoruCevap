<?php 
	session_start(); //Oturumunuzu başlatır.
	ob_start(); //Yeniden yönlendirme hatalarını önler

   require_once("fonksiyon.php");


   try {
	   
	$db =  new PDO("mysql:host=localhost;dbname=soru_cevap;charset=utf8","root","");  
	   
   }catch(PDOException $mesaj) {
	   
	   echo $mesaj->getmessage();
	   
   }
      
	   $query = pre("select * from ayarlar");
	   $query->execute();
	   $row = fetch($query);

	  


?>