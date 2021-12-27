<?php
    require_once("../../sistem/ayar.php");

    if($_POST){

        $isim = p("isim",true);
        $sifre = md5(p("sifre",true));

        if(!$isim || !$sifre){
            $data["hata"] = '<div class="alert alert-warning">Gerekli Alanları Doldurmanız Gerekiyor.</div>';
        }else{
            $query = pre("select * from kullanicilar where kullanici_adi=? and kullanici_sifre=?");
            $query->execute(array($isim,$sifre)); //dizide kullanıcı adı ve şifreyi girilen k.a ve sifreye eşitliyoruz.
            $row= fetch($query); //sorguyu gönderiyoruz.
            $kontrol = $query->rowcount(); //Şifreyi kontrol ediyoruz.

            if($kontrol){

                $_SESSION["kullanici"] = $row["kullanici_adi"];
                $_SESSION["id"] = $row["kullanici_id"];  
                $_SESSION["eposta"] = $row["kullanici_eposta"];  
                
                $data= array("ok" => '<div class="alert alert-success">Başarıyla Giriş Yaptınız Yönlendiriliyorsunuz.</div>',
                "go" => "index.php"
            );
                
    
            }else{
                $data["hata"]='<div class="alert alert-danger">Kullanıcı Adı veya Şifre Hatalı</div>';
            }
        }

        echo json_encode($data); //Data dizilerini JSON formatına çeviriyoruz.
    }
?>