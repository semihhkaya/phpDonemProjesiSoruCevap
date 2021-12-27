<?php

    if($_POST){
        $baslik=p("baslik",true);
        $baslik_sef=seflink(p("baslik",true));
        $aciklama= strip_tags(p("aciklama"),"<img><iframe><code>");
        $etiket= p("etiket",true);

        if(!$baslik || !$aciklama || !$etiket){
            echo hata("Gerekli Alanları Doldurmanız Gerekiyor..");
        }elseif(!preg_match("/^[A-Z-a-z,ıİüÜçÇöÖşŞ]+$/",$etiket)) { //preg_match = bu karakterler değilse anlamına gelir. (parantez içi parametre)
            echo hata("Lütfen Kategorileri Virgül ile Ayırınız. Kelimeler Arası Boşluk Bırakmayın!");
        }else{
            $saat= pre("select * from sorular where soru_tarih >now() -interval 10 second 
            and soru_ekleyen=?"
            );
            $saat->execute(array($_SESSION["id"]));
            fetch($saat);
            $x = $saat->rowcount();

            if($x){
                echo hata("10 Saniye İçinde Yeni Soru Ekleyemezsiniz"); //Bunu arttırıp azaltabiliriz
            }else{
                $ekle = pre("insert into sorular set

                    soru_baslik=?,
                    soru_sef=?,
                    soru_aciklama=?,
                    soru_ekleyen=?,
                    soru_etiket=?
                
                ");
                $ok= $ekle->execute(array($baslik,$baslik_sef,$aciklama,$_SESSION["id"],$etiket));
                if($ok){
                    echo hata("Sorunuz Başarıyla Eklendi. Yönlendiriliyorsunuz.",true);
                }else{{
                    echo hata("Soru eklenirken bir hata oluştu.");
                }}
            }
        }

    }else{
        ?>
        <form action="" method="post">
    
        <div class="form-group">
            <label for="formGroupExampleInput"> Soru Başlık:</label>
            <input type="text" name="baslik" class="form-control" id="formGroupExampleInput" placeholder="Başlık Ekleyin.">
        </div>

        <div class="form-group">
            <label for="formGroupExampleInput2">Soru Açıklama:</label>
            <textarea name="aciklama" class="form-control" id="formGroupExampleInput2" rows="6"></textarea>
        </div>

        <div class="form-group">
            <label for="formGroupExampleInput"> Etiketler/Kategoriler: *Virgül ile Ayırınız* Örnek:yazilim,programlama</label>
            <input type="text" name="etiket" class="form-control" id="formGroupExampleInput" placeholder="Virgül ile Ayırınız.">
        </div>

        <button type="submit" class= "btn btn-primary float-right">Gönder</button>

        </form>
        <?php
    }

?>