<?php

    require_once("../../sistem/ayar.php");

    if($_POST){

        //Php ip yakalama kodları.

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //Client ip değeri atanır.
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
            //Forwarded işlemi var ise Client Proxy ip adresini algılar.
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR']; //Bağlanan client'ın gerçek Ip adresi değerini döndürür
        }



        $isim = p("isim",true);
        $sifre = md5(p("sifre",true));
        $eposta = p("eposta",true);

        if(!$isim || !$sifre || !$eposta){

            $data = ["hata" => hata("Gerekli Alanları Doldurmanız Gerekiyor.")];

        }elseif(strlen($isim) > 15){
            
            $data = ["hata" => hata("15 Karakterden Büyük İsim Giremezsiniz!")];
        
        }elseif(!filter_var($eposta,FILTER_VALIDATE_EMAIL)){

            $data = ["hata" => hata("E-Posta Adresiniz Yanlış Gözüküyor!")];

        }else{

            $kullanici = pre("select * from kullanicilar where kullanici_adi=?");
            $kullanici->execute(array($isim));
            fetch($kullanici);
            $x = $kullanici->rowcount();

            if($x){
                
                $data = ["hata" => hata("<span style='color:red'>".$isim."</span>  Adlı Üye Sistemde Kayıtlı Gözüküyor!")];
            
            }else{
                $k = pre("select * from kullanicilar where kullanici_ip=?");
                $k->execute(array($ip));
                fetch($k);
                $xx = $k->rowcount();

                if($xx >= 10){ //Eğer hata alırsak, hesap açamazsak burdaki sayıyı arttır.!
                    
                    $data = ["hata" => hata("10'dan Fazla Üyelik Açamazsınız!")];
                
                }else{
                    $kayit = pre("insert into kullanicilar set 
                        kullanici_adi=?,
                        kullanici_sifre=?,
                        kullanici_eposta=?,
                        kullanici_ip=?
                    
                    ");
                    
                    $ok = $kayit->execute(array($isim,$sifre,$eposta,$ip));
                    if($ok){
                        $data = ["ok" => hata("Başarıyla Kayıt Oldunuz. Yönlendiriliyorsunuz...",true)];

                        $data["go"] = "index.php";

                    }else{
                        $data = $data = ["hata" => hata("Kayıt Olurken Bir Hata Oluştu.")];
                    }
                
                }
            }

        }

    }else{
        $data = ["hata" => "hacking ?"];
    }

    echo json_encode($data);

?>