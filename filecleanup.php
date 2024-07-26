<?php
// Silme işlemini gerçekleştirecek fonksiyon
function deleteFiles($directory, $lifetime) {
    // Belirtilen dizindeki tüm dosyaları listele
    $files = glob($directory . "/*");

    // Her bir dosya için kontrol et
    foreach ($files as $file) {
        // Dosyanın değiştirilme tarihini al
        $last_modified = filemtime($file);

        // Şu anki zaman ile dosyanın son değiştirilme tarihi arasındaki farkı kontrol et
        $difference = time() - $last_modified;

        // Eğer dosyanın son değiştirilme tarihi belirtilen süreden fazla ise sil
        if ($difference > $lifetime) {
            unlink($file); // Dosyayı sil
        }
    }
}

// uploads klasöründeki dosyaları 30 dakika aralıklarla kontrol edip sil
deleteFiles("uploads", 1 * 1); // 30 dakika (30 dakika x 60 saniye)
?>
