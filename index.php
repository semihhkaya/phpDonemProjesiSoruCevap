<?php
  define("index",true);

  require_once("sistem/ayar.php");

  ?>
  <base href="<?php echo $row["site_adi"];?>">

  <?php

   if($row["site_durum"] == 1){
	   
	   require("tema/index.php");
	   
   }else {
	   
	   echo 'site kapalı';
	   
   }

?>
