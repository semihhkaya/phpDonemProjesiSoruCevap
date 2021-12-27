<?php 
    $link = g("link");
    $query = pre("select * from kullanicilar where kullanici_adi=?");
    $query->execute([$link]);
    $row= fetch($query);
    
    $x= $query->rowCount(); //eğer üye var ise if yoksa else
    if($x){
        ?> <!--Profil sayfası -->
        <div class="card" style="width: 41rem;">
        <div class="card-header alert alert-info">
        Üye Profili
        </div>
        
        <ul class="list-group list-group-flush">
        <li class="list-group-item">
        <?php
            if($row["kullanici_resim"]){
                echo '<img src="'.$row["kullanici_resim"].'" width="70" height="70" class="rounded float-left" alt="Kullanıcı Resmi">';
            }else{
                echo '<img src="tema/resim/no_avatar.jpg" width="70" height="70" class="rounded float-left" alt="Kullanıcı Resmi">';
            }
        ?>
        </li>
            
        <li class="list-group-item"><?php echo $row["kullanici_adi"];?></li>
        <li class="list-group-item">
        <h6>Hakkında:</h6>
        <?php 
            if($row["kullanici_hakkinda"]){
                echo nl2br($row["kullanici_hakkinda"]);
            }else{
                echo "Hakkında bölümü girilmemiş.";
            }
        ?>
        </li>

        
        </ul>
        </div>
        <?php
    }else{
        echo hata("Sayfa Bulunamadı. Veriler silinmiş veya sayfa yayından kaldırılmış olabilir.");
    }
?>

