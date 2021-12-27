<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ana Sayfa</title>
  <script src="https://kit.fontawesome.com/2d726a798d.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script type="text/javascript"> //Sayfa yüklendiğinde burası çalışır //jQUERY
  </script>

</head>
<body>

<?php
  //Sayfalama
  $sayfa = @g("s") ? g("s") : 1; //Sayfa get ile parametre alıyor. // sayfa/2/

  $sayi = pre("select soru_id from sorular
    inner join kullanicilar on kullanicilar.kullanici_id = sorular.soru_ekleyen order by soru_id desc
  ");
  $sayi->execute();
  fetch($sayi);
  $say = $sayi->rowcount(); //Soru sayısını buluyoruz

  $limit = 3; //Her sayfada kaç soru gösterilecek
  $sayfa_sayisi = ceil($say/$limit); //Sayfa sayısı bu parametrelere göre belirlenir.
  
  $baslangic = $sayfa*$limit - $limit;
  
  $onceki = $sayfa > 1 ? $sayfa -1 : 1; //önceki yani geri butonuna basıldığında sayfa parametresi 1 geriler.(Eğer birden büyükse sayfa)
  $sonraki = $sayfa < $sayfa_sayisi ? $sayfa +1 : $sayfa_sayisi;
  
  $query=pre("select * from sorular
    inner join kullanicilar on kullanicilar.kullanici_id = sorular.soru_ekleyen order by soru_hit desc
    limit $baslangic,$limit
  ");

  $query->execute();
  $liste=all($query);
  $kontrol= $query->rowCount(); //Konu var mı diye kontrol ediyor.

  if($kontrol){
    foreach($liste as $row){
      
      $cevap = pre("select * from cevaplar where cevap_soru_id=?");
      $cevap->execute(array($row["soru_id"]));
      fetch($cevap);
      $x= $cevap->rowcount(); //yorum sayısı $x




      ?>
      <div class="card mb-4">
            <div class="card-body p-2">
              <h3 class="card-title"><?php echo $row["soru_baslik"];?></h3>
              <a href="/<?php echo $row["soru_sef"];?>.html" class="btn btn-danger btn-sm">Devamını Oku&rarr;</a>
            </div>
            <div class="card-footer text-muted p-2">
            
            <i class="fas fa-calendar-minus"></i> <!--İcon-->
            <?php
              $zaman= explode(" ",$row["soru_tarih"]); //Zaman değişkeni ile tarihi çekiyoruz. 
              echo "Tarih: ".$zaman[0]." Saat: ".$zaman[1]; //tarihi ve saati yazdırıyoruz. !Veritabanından
            
            
            ?>
            &nbsp; &nbsp;
              <i class="fas fa-user"></i>
              <a href="profil/<?php echo $row["kullanici_adi"];?>"><?php echo " Ekleyen Kullanıcı: ".$row["kullanici_adi"] ?></a>
              
              &nbsp; &nbsp;
              <i class="fas fa-eye"></i>
              <?php echo "Okunma Sayısı: ".$row["soru_hit"];?>

              &nbsp; &nbsp; 
              <i class="fas fa-comments "></i>
              <span class=""><?php echo $x; ?></span>
              
              <?php
              ?>


            </div>
            
        </div>
      <?php
      
    }

    if($sayfa_sayisi > 1){
      ?>
      <!-- Sayfalama -->
      <ul class="pagination justify-content-center mb-4">
            <li class="page-item">
              <a class="page-link" href="sayfa/<?php echo $onceki;?>">&larr; Geri </a>
            </li>
            <li class="page-item">
              <a class="page-link" href="sayfa/<?php echo $sonraki;?>">İleri &rarr;</a>
            </li>
          </ul>
      <?php
    }


  }else{
    echo '<div class="alert alert-primary">Henüz Hiç Soru Sorulmamış...</div>';
  };

?>
</body>
</html>
