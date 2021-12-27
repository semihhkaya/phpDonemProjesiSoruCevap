<?php !defined("index") ? die("Yetkisiz işlem yapıyorsunuz!!") : null; ?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Soru-Cevap</title>
    <script src="https://kit.fontawesome.com/2d726a798d.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel=stylesheet href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="tema/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="tema/vendor/bootstrap/css/modern-business.css" rel="stylesheet">

    <script type="text/javascript" src=tema/js/ayar.js></script>
    <script type="text/javascript" src="tema/alert/alertify.js"></script>
    <link rel="stylesheet" href="tema/alert/css/alertify.css">
    <link rel="stylesheet" href="tema/alert/css/themes/default.css">

  </head>

  <body>


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Giriş Yap</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="giris" onsubmit="return false">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Kullanıcı Adınız:</label>
            <input type="text" name="isim" class="form-control" id="recipient-name"/>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Şifre:</label>
            <input type="password" name="sifre" class="form-control" id="message-text"/>
          </div>
        
      </div>
      <div class="modal-footer">
        
        <button type="button" name="giris_yap" class="btn btn-primary" onclick="giris()">Giriş Yap</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->


    <!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Soru-Cevap</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a style="color:yellow" class="nav-link" href="/soru">Soru Sor</a>
            </li>

            <?php
              if(!$_SESSION){
                ?>
                <li class="nav-item">
                <a style="color:white" class="nav-link" href="#" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Giriş Yap</a>
                </li> 
                <?php
              }

              if(!$_SESSION){
                ?>
              <li class="nav-item">
              <a style="color:white" class="nav-link" href="/kayit">Kayıt Ol</a>
              </li>
                <?php
              }

              ?>
            
            
            <?php 
              if(@$_SESSION["kullanici"]){

                ?>
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" style="color:Yellow" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION["kullanici"];?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
                <a class="dropdown-item" href="/profil_duzenle">Profili Düzenle</a>
                <a class="dropdown-item" href="/cikis">Çıkış Yap</a>
              </div>
            </li>
                <?php

              }
            ?>



          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

	
	
	</h3>

      <!-- Page Heading/Breadcrumbs -->
      <h3 class="mt-4 mb-3">Sorular ve Cevaplar
       
      </h3>

      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Ana Sayfa</a>
        </li>
        <li class="breadcrumb-item active">Soru-Cevap Sitesi</li>
      </ol>

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

          <!-- Blog Post -->
          
          <?php

            $do= @g("do"); //Do parametresini çıkış yapma işlemi için get methodu ile gönderiyor swtich case ile yakalıyoruz.
            

            switch($do){ //devama basılırsa devam, cikisa basılırsa çıkış işlemi gerçekleşcek
              
              case "soru":
              if(@$_SESSION["kullanici"]){

                require_once("soru.php");

              }else{
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Üye misiniz?</strong> Soru Sorabilmeniz İçin Üye Olmanız Gerekmektedir!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
              }

              break;

              case "profil":
              if (g("do")){
                require_once("profil.php");
              }else{
                header("location:index.php");
              }

              break;

              case "devam":
              if(g("link")){
                require_once("devam.php");
              }else{
                echo '<div class="alert alert-warning">Sayfa Bulunamadı</div>';
              }
              break;

              case "ara":
              $kelime=g("kelime");
              header("location:/arama/".$kelime."");
              
              break;

              case "arama":
              if(g("kelime")){ //arama fonk. kelime parametresi var ise burayı yoksa else'i göster.
                require_once("arama.php");
              }else{
                header("location:index.php");
              }
              break;

              case "kayit":
              if(!$_SESSION){ //üYE DEĞİL İSE KAYITI GÖSTER
                require_once("kayit.php");
              }else{
                header("location:index.php"); //Kayıtlı ise  bu url'e giderse index'i göster
              }
              break;

              case"profil_duzenle":
              if($_SESSION["kullanici"]){ //Sessionlara her yerden ulaşabiliyoruz
                $kullanici=pre("select * from kullanicilar where kullanici_id=?");
                $kullanici->execute(array($_SESSION["id"]));
                $row = fetch($kullanici);
                $x= $kullanici->rowcount();

                if($x){
                  require_once("profil_duzenle.php");
                }else{
                  echo hata("Üye bulunamadı."); 
                }

                
              }else{
                header("location:index.php");
              }
              break;

              case "etiket":
              if(g("link")){ //link parametreis varsa if yoksa else
                require_once("etiket.php");
              }else{
                header("location:index.php");
              }

              break;
              
              case "cikis":
              require_once("cikis.php");
              break;

              default:
              require_once("anasayfa.php");
              break;
            }

          ?>
        
        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

      
          <!-- Search Widget -->
          <div class="card mb-4">
            <h5 class="card-header">Arama</h5>
            <!--<div class="col-md-4">-->
        <form action="index.php" method="get">
			<div class="input-group">
      <input type="hidden" name="do" value="ara">
			<input type="text" name="kelime" class="form-control" placeholder="Kafana takılan soruları Ara!">
			<span class="input-group-btn">
			<button class="btn btn-secondary" type="submit">Ara!</button>
			</span>
			</div>
      </form>
          </div>

          <!-- Categories Widget -->
          <div class="card my-4">
            <h5 class="card-header">Kategoriler/Etiketler</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <a href="http://localhost/etiket/programlama">Programlama</a>
                    </li>
                    <li>
                      <a href="http://localhost/etiket/yazılım">Yazılım</a>
                    </li>
                    <li>
                      <a href="http://localhost/etiket/php">PHP</a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <a href="http://localhost/etiket/javascript">JavaScript</a>
                    </li>
                    <li>
                      <a href="http://localhost/etiket/css">CSS</a>
                    </li>
                    <li>
                      <a href="http://localhost/etiket/bilgisayar">Bilgisayar</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Side Widget -->
          <div class="card my-4">
            <h5 class="card-header">Hakkımızda</h5>
            <div class="card-body">
              <p>Sorular okunma sayılarına göre sıralanmıştır. Cevap vermek için üye girişi yapılması gerekir.</p>
            </div>
          </div>

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer style="background-color:gray" class="py-5">
      <div class="container">
        <p class="m-0 text-center text-white">Tüm Hakları Saklıdır &copy; Soru-Cevap</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="tema/vendor/jquery/jquery.min.js"></script>
    <script src="tema/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
