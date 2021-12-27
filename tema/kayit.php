<div class="alert alert-info">Kayıt Formu</div>
<form action="" id="kayit" onsubmit="return false">
<div class="form-group row">
    <label for="example-text-input" class="col-2 col-form-label">İsim:</label>
    <div class="col-10">
        <input class="form-control" name="isim" type="text" id="example-text-input">
    </div>
</div>
<div class="form-group row">
    <label for="example-text-input" class="col-2 col-form-label">Şifre</label>
    <div class="col-10">
        <input class="form-control" name="sifre" type="password" id="example-text-input">
    </div>
</div>
<div class="form-group row">
    <label for="example-text-input" class="col-2 col-form-label">Eposta:</label>
    <div class="col-10">
        <input class="form-control" name="eposta" type="text" id="example-text-input">
    </div>
</div>
<button type="submit" class="btn btn-dark float-right" onclick=kayit();>Kayıt Ol</button>
</form>
<!--Tıklandığında kayıt fonksiyonu çalışacak-->