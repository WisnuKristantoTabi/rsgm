<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
    <script src="https://cdn.jsdelivr.net/npm/quagga/dist/quagga.min.js"></script>
</head>

<body>
    <h1>Barcode Scanner</h1>
    <div id="interactive" class="viewport"></div>
    <script>
        // Konfigurasi Quagga
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector("#interactive"),
                constraints: {
                    width: 480,
                    height: 320,
                    facingMode: "environment" // Atur mode kamera (kamera belakang)
                },
            },
            decoder: {
                readers: ["ean_reader"] // Jenis barcode yang akan dibaca
            },
        }, function(err) {
            if (err) {
                console.error("Gagal menginisialisasi Quagga: ", err);
                return;
            }
            console.log("Quagga diinisialisasi dengan sukses.");
            Quagga.start();
        });

        // Tangani hasil pemindaian
        Quagga.onDetected(function(result) {
            console.log("Hasil pemindaian: ", result);
            alert("Barcode terdeteksi: " + result.codeResult.code);
            Quagga.stop(); // Hentikan pemindaian setelah barcode terdeteksi
        });
    </script>
</body>

</html>