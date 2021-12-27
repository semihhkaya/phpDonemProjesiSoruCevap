function giris(){
    var data = $("#giris").serialize(); //serialize formdaki verileri çekiyor id'si giriş olan formdaki verileri çeker
    //alert(data);
    $.ajax({
        url:"tema/ajax/giris.php",
        data: data,
        dataType: "json", //Giriş ekranında  ad ve şifre verilerini JSON formatında gönderiyoruz.
        type: "post",
        success: function(e){
            
            if(e.hata){
                alertify.alert(e.hata);
            }else{
                alertify.alert(e.ok);
                setTimeout(function(){ //Bir kere sayfayı yeniliyor.
                    location.replace(e.go); //İndex.php'ye yölendirecek //giris.php'de tanımladık.
                },1000)
            }
        }
    }); //ajax sayfa yenilenmeden işlem yapımını sağlar.
}

function cevap() {
    var data = $("#cevap").serialize(); //CEVAP FORMUNUN İÇİNDEKİ TÜM DEĞERLERİ ÇEKTİK
        $.ajax({
            url:"tema/ajax/cevap.php",
            data: data,
            type: "post",
            dataType: "json",
            
            success: function (e) {
                if(e.hata){
                    alertify.alert(e.hata);
                }else{
                    alertify.alert(e.ok);

                    $("#sonuc").prepend(e.mesaj); //Gönderilen değerleri mesaj'a yani cevap gönderildiye ekler
                    $("#gizle").hide(); //Yeni yorum eklendğinde henüz yorum yok alert'i kaldırılcak. id'si gizle olan html tagini gizliyoruz
                }
            }
        });
}

function kayit(){
    var data = $("#kayit").serialize(); //kayit formundaki tüm dataları çekiyoruz
    $.ajax({
        url:"tema/ajax/kayit.php",
        data:data,
        type:"post",
        dataType:"json",
        success:function(e){
            
            if(e.hata){
                alertify.alert(e.hata);
            }else{
                alertify.alert(e.ok);
                
                setTimeout(function(){ //eğer kayıt işleminde hata yok ise e.go çalışır ajax/kayit.php

                    location.replace(e.go);

                },1000);
            }

        }
    });
}
