<?php require_once("sistem/ayar.php");?>
<?php
    $link = g("link"); //Burdan oluşturduğumuz sef link yapısını get methodu ile çekiyoruz.
    //Tarayıcıya ilgili link geldiğinde o linke özel yani soruya özel ayrıntılı devam sayfası yüklenir.

        $query= pre("select * from sorular inner join kullanicilar on 
        kullanicilar.kullanici_id = sorular.soru_ekleyen where soru_sef=?");

        $query->execute(array($link));
        $row = fetch($query);
        $kontrol = $query->rowCount();

        if ($kontrol){
            //Okunma kontrolü srasında Eğer çerez yoksa o çerezi kaydedecek ve okunma sağlayacak. Ancak
            //aynı kişiden tekrar bir okunma sağlanınca çerez var olduğu için okunma artmayacak. 
            if(!@$_COOKIE["hit".$link]){ //Bir kullanıcının sadece bir okunma sağlaması için yazılan kod
            //Soruya tıklandığında okunmayı arttırmak için eklenen update kodu
            $update = pre("update sorular set soru_hit = soru_hit +1 where soru_sef=?");
            $update->execute(array($link));

            setcookie("hit".$link,"_",time()+60*60*24); //Bir kullanıcının sadece bir okunma sağlaması için yazılan kod
        }   

            ?>
            <div class="col-lg-11">
            <p><h3><?php echo $row["soru_baslik"];?></h3></p>
            <!-- Post Content Column -->


<hr class="style2">
<style>
hr.style2 {
	border-top: 3px double #8c8b8b;
}
</style>

<!-- Date/Time -->
<i class="fas fa-calendar-minus"></i> <!--İcon-->

<?php echo $row["soru_tarih"];?> &nbsp; &nbsp;
<i class="fas fa-user"></i>
<?php echo $row["kullanici_adi"];?> &nbsp; &nbsp;
<i class="fas fa-eye"></i>
<?php echo "Okunma Sayısı: ".$row["soru_hit"];?>

<hr>

<!-- Post Content -->
<?php echo nl2br($row["soru_aciklama"]);?>

<br>
<br>

<div class="card-footer text-muted p-2">
    <h6>Kategoriler:</h6>
    <?php

        $x = explode(",",$row["soru_etiket"]); //explode burada etiketleri parçalama işlemi yapıyor.
        $c = array();

        foreach($x as $etiket){
            $etiket= '<span class="badge badge-info">
            <a style="color:white" href="etiket/'.$etiket.'">'.$etiket.'</a></span>';

            array_push($c,$etiket);
        }
            echo implode(",",$c); //Etiketler/Kategoriler listeleniyor. Virgül ile ayrılarak yazılıyor.
            

    ?>
    </div>

    
    <?php
      if($_SESSION){
        ?>
        <!-- Cevap Formu -->
    <div class="card my-4">
        <h5 class="card-header">Cevap Yaz:</h5>
      <div class="card-body">
      <form action="" id="cevap" onsubmit="return false">
      <div class="form-group">

        <input type="hidden" name="isim" value ="<?php echo $_SESSION["id"];?>">
        <input type="hidden" name="eposta" value ="<?php echo $_SESSION["eposta"];?>">
        <input type="hidden" name="soru_id" value ="<?php echo $row["soru_id"] ;?>">

        <textarea name="mesaj" class="form-control" rows="5"></textarea>
      </div>
      <button type="submit" name="cevap_yaz" onclick="cevap();" class="btn btn-primary">Gönder</button>
      </form>
      </div>
    </div>

    <div id="sonuc"></div>
        <?php

      }else{
        echo '<div class="alert alert-info"><a href="">Giriş Yap</a> Soruyu cevaplamak için üye olmanız gerekmektedir.</div>'; 
      }

      $cevap = pre("select * from cevaplar inner join kullanicilar on
      kullanicilar.kullanici_id = cevaplar.cevap_ekleyen
      where cevap_soru_id=? order by cevap_id desc");
      $cevap->execute(array($row["soru_id"]));
      $liste = all($cevap);
      $c = $cevap->rowCount(); //Cevap var mı kontrol ediyoruz

      if($c){ //Cevap var ise burası çalışır
        
        foreach($liste as $row){
          ?>
          <!-- Cevaplar Liste -->
        <div class="media mb-4 alert alert-warning">
        <?php
        
        if($row["kullanici_resim"]){ //Üyenin resmi var ise
          ?>
          <img class= "d-flex mr-3 rounded-circle" src="<?php echo $row["kullanici_resim"];?>" width="50" height="50"  alt="">
          <?php


        }else{ //üyenin resmi yoksa bura çalışır
          ?>
          <img class= "d-flex mr-3 rounded-circle" src="tema/resim/no_avatar.jpg" width="50" height="50"  alt="">
          <?php
        }
        
        ?>
        <div class="media-body">
        <h5 class="mt-0"><?php echo $row["kullanici_adi"]; ?></h5>
        <span style="font-size:16px;" class="float-right"><?php echo $row["cevap_tarih"];?></span>
        <?php echo nl2br($row ["cevap_mesaj"]); ?>
        </div> 
        </div>
          <?php
        }

      }else{
        echo ' <span id="gizle"> <div class="alert alert-info">Henüz hiç yorum eklenmemiş..</div> </span>';
      }

    ?>


</div>

            <?php
        }else{
            echo hata("Sayfa Bulunamadı. Veriler silinmiş veya Soru yayından kaldırılmış olabilir.");
        }
        //


?>