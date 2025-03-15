<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
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
    <div class="container">
        <div class="checkmark">✔</div>
        <h2>Pembayaran Berhasil!</h2>
        <p>Terima kasih! Pembayaran Anda telah berhasil diproses.</p>
        <a href="/" class="button">Kembali ke Beranda</a>
    </div>
</body>
</html>