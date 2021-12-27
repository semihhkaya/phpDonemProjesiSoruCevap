<?php

  $link = g("link");

  
  //Sayfalama
  $sayfa = @g("s") ? g("s") : 1;

  $sayi = pre("select soru_id from sorular
    inner join kullanicilar on kullanicilar.kullanici_id = sorular.soru_ekleyen 
    
    where soru_baslik like ?
    
    order by soru_id desc
  ");
  $sayi->execute(["%".$link."%"]);
  fetch($sayi);
  $say = $sayi->rowcount(); //Soru sayısını buluyoruz

  $limit = 3; //Her sayfada kaç soru gösterilecek
  $sayfa_sayisi = ceil($say/$limit); //Sayfa sayısı bu parametrelere göre belirlenir.
  
  $baslangic = $sayfa*$limit - $limit;
  
  $onceki = $sayfa > 1 ? $sayfa -1 : 1; //önceki yani geri butonuna basıldığında sayfa parametresi 1 geriler.(Eğer birden büyükse sayfa)
  $sonraki = $sayfa < $sayfa_sayisi ? $sayfa +1 : $sayfa_sayisi;
  
  $query=pre("select * from sorular
    inner join kullanicilar on kullanicilar.kullanici_id = sorular.soru_ekleyen
    where soru_baslik like ?
    order by soru_id desc
    limit $baslangic,$limit
  ");

  $query->execute(["%".$link."%"]);
  $liste=all($query);
  $kontrol= $query->rowCount(); //linkteki etikete/kategoriye ait Konu var mı diye kontrol ediyor.

  if($kontrol){
    ?>
    <span class="d-block bg-info p-2 mb-3 text-white rounded-left">
    <span style="color:yellow"><?php echo $link;?></span> Kategorisine ait (<?php echo $say;?>) sonuç bulundu.
    </span>
    <?php

    foreach($liste as $row){
      
      $cevap = pre("select * from cevaplar where cevap_soru_id=?");
      $cevap->execute(array($row["soru_id"]));
      fetch($cevap);
      $x= $cevap->rowcount();




      ?>
      <div class="card mb-4">
            <div class="card-body p-2">
              <h3 class="card-title"><?php echo $row["soru_baslik"];?></h3>
              <a href="/<?php echo $row["soru_sef"];?>.html" class="btn btn-primary btn-sm">Devamını Oku&rarr;</a>
            </div>
            <div class="card-footer text-muted p-2">
            
            <i class="fas fa-calendar-minus"></i> <!--İcon-->
            <?php
              $zaman= explode(" ",$row["soru_tarih"]); //Zaman değişkeni ile tarihi çekiyoruz. 
              echo "Tarih: ".$zaman[0]."  Saat: ".$zaman[1]; //tarihi ve saati yazdırıyoruz. !Veritabanından

            
            ?>
              <i class="fas fa-user"></i>
              <a href="?do=profil&link=<?php echo $row["kullanici_adi"];?>"><?php echo " Ekleyen Kullanıcı: ".$row["kullanici_adi"] ?></a>
              <?php echo $row["soru_hit"];?>
              <i class="fas fa-comments float-right"></i>
              <span class="float-right"><?php echo $x; ?></span>
            </div>
            
        </div>
      <?php
      
    }

    if($sayfa_sayisi > 1){  
      ?>
      <!-- Sayfalama -->
      <ul class="pagination justify-content-center mb-4">
            <li class="page-item">
              <a class="page-link" href="etiket<?php echo $link;?>/sayfa/<?php echo $onceki;?>">&larr; Geri </a>
            </li>
            <li class="page-item">
              <a class="page-link" href="etiket/<?php echo $link;?>/sayfa/<?php echo $sonraki;?>">İleri &rarr;</a>
            </li>
          </ul>
      <?php
    }


  }else{
    echo '<div class="alert alert-primary">Henüz Hiç Soru Sorulmamış...</div>';
  };

?>
