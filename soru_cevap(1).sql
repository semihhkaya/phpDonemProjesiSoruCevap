-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 Ara 2021, 09:04:24
-- Sunucu sürümü: 10.4.19-MariaDB
-- PHP Sürümü: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `soru_cevap`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `ayar_id` int(11) NOT NULL,
  `site_adi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `site_baslik` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `site_aciklama` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `site_anahtar` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `site_durum` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`ayar_id`, `site_adi`, `site_baslik`, `site_aciklama`, `site_anahtar`, `site_durum`) VALUES
(1, 'http://localhost', 'Soru Cevap Sitesi', 'Soru Cevap', 'soru, cevap, forum, yardım', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cevaplar`
--

CREATE TABLE `cevaplar` (
  `cevap_id` int(11) NOT NULL,
  `cevap_mesaj` text COLLATE utf8_turkish_ci NOT NULL,
  `cevap_eposta` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `cevap_ekleyen` int(11) DEFAULT NULL,
  `cevap_soru_id` int(11) DEFAULT NULL,
  `cevap_tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `cevaplar`
--

INSERT INTO `cevaplar` (`cevap_id`, `cevap_mesaj`, `cevap_eposta`, `cevap_ekleyen`, `cevap_soru_id`, `cevap_tarih`) VALUES
(25, 'batu yorum deneme', 'batuhan@gmail.com', 2, 2, '2021-12-10 09:21:30'),
(26, 'deneme mesajı semihkaya', 'semih@outlook.com', 1, 2, '2021-12-12 07:21:13'),
(29, 'selam beyler', 'omer@gmail.com', 4, 2, '2021-12-12 08:25:05'),
(30, 'ssssss', 'semih@outlook.com', 1, 2, '2021-12-12 11:24:34'),
(31, 'Fontavesome linklerini eklemeyi dene İconlar gözükecektir.', 'semih@outlook.com', 1, 17, '2021-12-18 07:24:12'),
(32, 'böyle yaparsan çözülür', 'omer@gmail.com', 4, 3, '2021-12-18 14:28:33'),
(33, 'deneme cevabımdır', 'semih@outlook.com', 1, 2, '2021-12-21 14:11:42'),
(34, 'Ayarlardan console\'u açarsan düzelebilir', 'semih@outlook.com', 1, 1, '2021-12-25 15:43:14');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_adi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_sifre` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_eposta` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_resim` varchar(300) COLLATE utf8_turkish_ci DEFAULT NULL,
  `kullanici_ip` varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  `kullanici_hakkinda` varchar(500) COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_id`, `kullanici_adi`, `kullanici_sifre`, `kullanici_eposta`, `kullanici_resim`, `kullanici_ip`, `kullanici_hakkinda`) VALUES
(1, 'semih', 'e10adc3949ba59abbe56e057f20f883e', 'semih@outlook.com', 'tema/resim/87739217.jpg', NULL, 'Ben semih kaya'),
(2, 'batuhan', 'e10adc3949ba59abbe56e057f20f883e', 'batuhan@gmail.com', 'tema/resim/avatar.jpg', NULL, NULL),
(4, 'omer', 'e10adc3949ba59abbe56e057f20f883e', 'omer@gmail.com', NULL, '127.0.0.1', NULL),
(5, 'busra', 'e10adc3949ba59abbe56e057f20f883e', 'busra@gmail.com', NULL, '127.0.0.1', NULL),
(6, 'seyda', 'e10adc3949ba59abbe56e057f20f883e', 'seyda@gmail.com', NULL, '127.0.0.1', NULL),
(7, 'onur', 'e10adc3949ba59abbe56e057f20f883e', 'onur@gmail.com', NULL, '127.0.0.1', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sorular`
--

CREATE TABLE `sorular` (
  `soru_id` int(11) NOT NULL,
  `soru_baslik` varchar(200) COLLATE utf8mb4_turkish_ci NOT NULL,
  `soru_aciklama` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `soru_ekleyen` int(11) DEFAULT NULL,
  `soru_sef` varchar(200) COLLATE utf8mb4_turkish_ci NOT NULL,
  `soru_etiket` varchar(200) COLLATE utf8mb4_turkish_ci NOT NULL,
  `soru_hit` int(11) NOT NULL DEFAULT 0 COMMENT 'Sorunun okunma sayısı',
  `soru_tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `sorular`
--

INSERT INTO `sorular` (`soru_id`, `soru_baslik`, `soru_aciklama`, `soru_ekleyen`, `soru_sef`, `soru_etiket`, `soru_hit`, `soru_tarih`) VALUES
(1, 'Visual Studio 2019 kurulumunda config.exe hatası alıyorum. Çözüm önerisi olan var mı?', 'C# Soru Açıklama', 1, 'csharp-sorusu', 'csharp,c#,soru,yazilim,programlama', 9, '2021-12-06 06:13:10'),
(2, 'Yazılıma nerden başlamalıyım? Önerilerinizi bekliyorum.', 'Yazılıma nerden başlamalıyım', 1, 'yazilima-nerden-baslamaliyim', 'yazilim,programlama,soru', 14, '2021-12-06 06:14:28'),
(3, 'Xampp directory hatası! Önemli Durum!', 'Xampp\'de mysql directory hatası alıyorum. Port numaralarını değiştirdim ama çözüm olmadı önerisi olan var mı?', 4, 'xampp-directory-hatasi-onemli-durum', 'xampp,mysql,php,yazilim', 4, '2021-12-13 06:16:53'),
(6, '5000 TL bütçe ile hangi laptopu önerirsiniz?', '5000 TL bütçe ile hangi laptopu önerirsiniz? 5000 TL bütçe ile hangi laptopu önerirsiniz? 5000 TL bütçe ile hangi laptopu önerirsiniz? 5000 TL bütçe ile hangi laptopu önerirsiniz?', 2, '5000-tl-butce-ile-hangi-laptopu-onerirsiniz', 'laptop,teknoloji,inovasyon,yenilik', 1, '2021-12-14 06:12:45'),
(8, 'PHP\'de ajax ile login panel yaparken hata alıyorum yardımcı olabilir misiniz?', 'PHP\'de ajax ile login panel yaparken hata alıyorum yardımcı olabilir misiniz? PHP\'de ajax ile login panel yaparken hata alıyorum yardımcı olabilir misiniz? PHP\'de ajax ile login panel yaparken hata alıyorum yardımcı olabilir misiniz? PHP\'de ajax ile login panel yaparken hata alıyorum yardımcı olabilir misiniz?', 1, 'php-de-ajax-ile-login-panel-yaparken-hata-aliyorum-yardimci-olabilir-misiniz', 'php,ajax,yazilim,programlama', 4, '2021-12-14 06:14:34'),
(16, 'Javascript error occured in the main process hatası', 'Bilgisayarı açtığımda JavaScript error occured in the main process hatası alıyorum. Çözümünü bilen, önerisi olan var mı?', 1, 'javascript-error-occured-in-the-main-process-hatasi', 'javascript,yazilim,programlama,teknoloji,bilgisayar', 1, '2021-12-18 07:19:31'),
(17, 'Css kodlarım localhostta çalışmıyor!', 'CSS kodlarım, fontlarım ve iconlar Localhostta çalışmıyor. Link ve scriptleri ekledim ancak yine de hata alıyorum. Yardımlarınızı bekliyorum', 6, 'css-kodlarim-localhostta-calismiyor', 'css,programlama,bilgisayar,yazilim', 1, '2021-12-18 07:21:45'),
(18, 'Programlamayı hangi dille öğrenebilirim', 'Programlamayı hangi dille öğrenebilirim önerisi olan?', 5, 'programlamayi-hangi-dille-ogrenebilirim', 'programlama,yazılım,yazilim,bilgisayar', 2, '2021-12-20 09:30:35');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`ayar_id`);

--
-- Tablo için indeksler `cevaplar`
--
ALTER TABLE `cevaplar`
  ADD PRIMARY KEY (`cevap_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Tablo için indeksler `sorular`
--
ALTER TABLE `sorular`
  ADD PRIMARY KEY (`soru_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `ayar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `cevaplar`
--
ALTER TABLE `cevaplar`
  MODIFY `cevap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `sorular`
--
ALTER TABLE `sorular`
  MODIFY `soru_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
