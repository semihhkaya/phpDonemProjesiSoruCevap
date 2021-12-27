<?php
    require_once("../../sistem/ayar.php");

    if($_POST){
        
        $isim = p("isim",true);
        $eposta = p("eposta",true);
        $mesaj = p("mesaj",true);
        $soru_id = p("soru_id",true);

        if(!$mesaj){
            $data = array("hata" => "Cevap Boş Bırakılamaz!");
            

        }elseif(strlen($mesaj)<5) {
            $data = array("hata" => "Cevabınız Çok Kısa!");
        }
        else{ 
            $saat = pre("select * from cevaplar where cevap_tarih>now() - interval 5 minute
            and cevap_ekleyen=?
            ");

            $saat->execute(array($isim));
            fetch($saat);

            $x = $saat->rowCount();

            if($x){
                $data = array("hata" => hata("5 Dakika İçinde Yeni Bir Yorum Gönderemezsiniz!"));
            }else{
                $kayit = pre("insert into cevaplar set 
                        cevap_mesaj=?,
                        cevap_ekleyen=?,
                        cevap_soru_id=?,
                        cevap_eposta=?
                ");

                $ok = $kayit->execute(array($mesaj,$isim,$soru_id,$eposta));

                if($ok){
                    $cevap = pre("select * from cevaplar inner join kullanicilar on
                    kullanicilar.kullanici_id = cevaplar.cevap_ekleyen
                    where cevap_soru_id=? order by cevap_id desc");
                    $cevap->execute(array($soru_id));
                    $liste = fetch($cevap);

                    if($liste["kullanici_resim"]){
                        $resim = $liste["kullanici_resim"];
                    }else{
                        $resim = "tema/resim/no_avatar.jpg";
                    }

                    $data = array("ok" => hata("Cevabınız Başarıyla Eklendi",true));
                    $data["mesaj"]=

                    '<!-- Cevaplar Liste -->
                    <div class="media mb-4 alert alert-info">
                    <img class="d-flex mr-3 rounded-circle" src="'.$resim.'" width="50" height="50" alt="">
                    <div class="media-body">
                    <h5 class="mt-0">'.$liste["kullanici_adi"].'
                    <span style="font-size:16px;" class="float-right">'.$liste["cevap_tarih"].'</span>
                    
                    </h5>
                    '.$mesaj.'
                    </div>
                    </div>';

                }
                else{
                    $data = array("hata" => hata("Cevap gönderilirken bir hata oluştu"));
                }
            }
        }

    }else{
        echo 'Başarısız...';
    }
    echo json_encode($data);
?>