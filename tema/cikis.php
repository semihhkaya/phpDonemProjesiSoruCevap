<?php 
    session_destroy();

    header("refresh: 2; url=index.php");

        echo '<div class= "alert alert-success">Başarıyla Çıkış Yaptınız. Yönlendiriliyorsunuz.</div>';

?>