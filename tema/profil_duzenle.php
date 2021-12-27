<?php

    if($_POST){
        $sifre = p("sifre",true);
        $hakkinda = p("hakkinda",true);
    
        if($_FILES["resim"]["name"]){
            $boyut=1024*1024;
            $uzanti=substr($_FILES["resim"]["name"],-4,4); //
            $adi= rand(0,99999999).$uzanti;
            $yol= "tema/resim/".$adi;

            $data=[];

            if($_FILES["resim"]["size"]>$boyut){
                echo $data["hata"] = hata("Dosya boyutu 1MB'den büyük olmaz.");
            }else{
                $tip=["image/jpeg","image/png","image/jpg","image/gif"];

                if(in_array($_FILES["resim"]["type"],$tip)){ //Bu dizinin içinde geçiyor ise =in_array
                    
                    if(is_uploaded_file($_FILES["resim"]["tmp_name"])){ //is upl file=dosyanın yüklenip yüklenmediğini kontrol et.
                        
                        if(move_uploaded_file($_FILES["resim"]["tmp_name"],$yol)){

                        }else{
                            $data["hata"] = hata("Dosya Taşınamadı!");
                        }

                    }else{
                        $data["hata"]=hata("Dosya yüklenemedi!");
                    }
                
                
                }else{
                    $data["hata"] = hata("Dosya Formatı Geçersiz!");
                    
                }
            }

        }

        if($sifre){
            $sifre=md5($sifre);
        }else{
            $sifre=$row["kullanici_sifre"];
        }

        if(!@$yol){
            $yol=$row["kullanici_resim"];   
        }

        if(@$data["hata"]){ //hata dizim çalışırsa yani hata alırsam burası almazsam else çalışır.
            echo $data["hata"]; //Hataları ekrana yazdır.
        }else{
            $update = pre("update kullanicilar set

            kullanici_sifre=?,
            kullanici_hakkinda=?,
            kullanici_resim=? where kullanici_id=?
            
            ");
            $ok = $update->execute([$sifre,$hakkinda,$yol,$_SESSION["id"]]);

            if($ok){
                echo hata("Profiliniz Başarıyla Güncellendi! Yönlendiriliyorsunuz!",true);
                header("refresh: 2; url=profil_duzenle");
            }else{
                echo hata("Profil Güncellenirken Bir Hata Oluştu!");
            }
        }
    }


?>
<span class="d-block p-2 bg-primary text-white mb-3">Profili Düzenle</span>

<form action="" method="post" enctype="multipart/form-data">
    <?php 
    
        if($row["kullanici_resim"]){
            ?>
            <img src="<?php echo $row["kullanici_resim"];?>" width="70" height="50" alt="profil_duzenle" class="rounded-circle">
            <?php
        }else{
            ?>
            <img src="tema/resim/no_avatar.jpg" width="70" height="70" alt="profil_duzenle" class="rounded-circle">
            <?php
        }

    ?>
    <div class="form-group">
        <label for="exampleFormControlFile1">Resim Yükle/Düzenle:</label>
        <input type="file" class="form-control-file" name="resim" id="exampleFormControlFile1">
    </div>

    <div class="form-group">
        <label for="exampleInput1" class="form-label">Bu alanı doldurarak şifrenizi değiştirebilirsiniz:</label>
        <input type="password" name="sifre" class="form-control" id="exampleFormControlInput1" placeholder="Şifrenizi değiştirmek istemiyorsanız bu alanı boş bırakın!">
    </div>

    <div class="form-group">
        <label for="exampleFormControlTextArea1" class="form-label">Hakkımda:</label>
        <textarea name="hakkinda" class="form-control" id="exampleFormControlTextArea1" rows="3"><?php echo $row["kullanici_hakkinda"];?></textarea>
    </div>

    <button type="submit" class="btn btn-primary float-right">Düzenle</button>
</form>