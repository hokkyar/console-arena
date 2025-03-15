<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            max-width: 400px;
        }
        .checkmark {
            font-size: 50px;
            color: #4CAF50;
            animation: pop 0.5s ease-out;
        }
        .crossmark {
            font-size: 50px;
            color: #FF0000;
            animation: pop 0.5s ease-out;
        }
        @keyframes pop {
            0% { transform: scale(0); }
            80% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
            font-size: 13px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container" id="payment-container"></div>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('transaction_status');
        const container = document.getElementById('payment-container');

        if (status === 'settlement') {
            document.title = "Pembayaran Berhasil";
            container.innerHTML = `
                <div class="checkmark">✔</div>
                <h2>Pembayaran Berhasil!</h2>
                <p>Terima kasih! Pembayaran Anda telah berhasil diproses.</p>
                <a href="/" class="button">Kembali ke Halaman Booking</a>
            `;
        } else {
            document.title = "Pembayaran Gagal";
            container.innerHTML = `
                <div class="crossmark">✖</div>
                <h2>Pembayaran Gagal!</h2>
                <p>Maaf, pembayaran Anda gagal karena sesi sudah dibooking atau terjadi kesalahan.</p>
                <a href="/" class="button">Kembali ke Halaman Booking</a>
            `;
        }
    </script>
</body>
</html>
