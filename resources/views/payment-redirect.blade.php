<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        /* Success message */
        .payment-message {
            text-align: center;
            padding: 30px 20px;
            background-color: #f8f8f8;
        }
        
        .success-icon, .error-icon {
            width: 70px;
            height: 70px;
            background-color: #e6f7e9;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pop 0.5s ease-out;
        }

        .error-icon {
          background-color: #f7e6e6;
        }

        @keyframes pop {
            0% { transform: scale(0); }
            80% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .success-icon svg {
            width: 35px;
            height: 35px;
            fill: #4caf50;
        }

        .error-icon svg {
            width: 35px;
            height: 35px;
            fill: #af4c4c;
        }
        
        .payment-message h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #2e2e2e;
        }
        
        .payment-message p {
            color: #666;
            max-width: 500px;
            margin: 0 auto;
        }
        
        /* Order details */
        .order-details {
            padding: 30px;
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .order-number h2 {
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .order-date {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .separator {
            height: 1px;
            background-color: #eee;
            margin: 20px 0;
        }
        
        /* Order items */
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .order-items {
            margin-bottom: 30px;
        }
        
        .item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .item-image {
            width: 80px;
            height: 80px;
            background-color: #f0f0f0;
            border-radius: 4px;
            margin-right: 15px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }
        
        .item-details {
            flex-grow: 1;
        }
        
        .item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .item-session {
            color: #666;
            font-size: 14px;
        }
        
        .item-price {
            text-align: right;
            min-width: 80px;
        }
        
        .item-price .price {
            font-weight: 600;
        }
        
        .item-price .total {
            color: #666;
            font-size: 14px;
        }
        
        /* Shipping and delivery */
        .shipping-delivery {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        @media (min-width: 768px) {
            .shipping-delivery {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        .info-box {
            background-color: #f8f8f8;
            border-radius: 4px;
            padding: 15px;
        }
        
        .info-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .info-header svg {
            width: 18px;
            height: 18px;
            margin-right: 3px;
            fill: #666;
        }
        
        .info-title {
            font-weight: 600;
            font-size: 15px;
        }
        
        .info-content p {
            margin-bottom: 5px;
        }
        
        .info-content .highlight {
            font-weight: 600;
        }
        
        /* Payment summary */
        .payment-summary {
            margin-bottom: 30px;
        }
        
        .summary-box {
            background-color: #f8f8f8;
            border-radius: 4px;
            padding: 15px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .summary-label {
            color: #666;
        }
        
        .summary-total {
            font-weight: 600;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        
        /* Footer */
        .card-footer {
            background-color: #f8f8f8;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }
        
        .btn-outline {
            border: 1px solid #ddd;
            color: #333;
            background-color: transparent;
        }
        
        .btn-primary {
            background-color: #3e7cb1;
            color: white;
            border: none;
        }
        
        .btn-outline:hover {
            background-color: #f0f0f0;
        }
        
        .btn-primary:hover {
            opacity: .9;
        }
        
        /* Help section */
        .help-section {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        
        .help-section a {
            color: #4361ee;
            text-decoration: none;
            font-weight: 500;
        }
        
        .help-section a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 600px) {
            .order-header {
                flex-direction: column;
            }
            
            .card-footer {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 535px) {
          .item-image {
            display: none;
          }
          .order-details {
            padding: 15px;
          }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="payment-message">

            @if ($isSettlement)
              <div class="success-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                      <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                  </svg>
              </div>
              <h1>Pembayaran Berhasil!</h1>
              <p>Terima kasih! Pembayaran Anda telah berhasil diproses.</p>
            @else
              <div class="error-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                      <path d="M18.3 5.7a1 1 0 0 0-1.4 0L12 10.6 7.1 5.7a1 1 0 0 0-1.4 1.4L10.6 12l-4.9 4.9a1 1 0 1 0 1.4 1.4L12 13.4l4.9 4.9a1 1 0 0 0 1.4-1.4L13.4 12l4.9-4.9a1 1 0 0 0 0-1.4z"/>
                  </svg>
              </div>
              <h1>Pembayaran Gagal!</h1>
              <p>Maaf, pembayaran Anda gagal karena sesi sudah dibooking atau terjadi kesalahan.</p>
            @endif
        </div>
        
        <div class="order-details">
            <div class="order-header">
                <div class="order-number">
                    <h2>Order #{{ request()->query('order_id') }}</h2>
                    <div class="order-date">Dipesan pada {{ $booking->created_at->timezone('Asia/Jakarta'); }}</div>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 15px;">
                        <li><strong>Nama:</strong> {{ $booking->customer_name }}</li>
                        <li><strong>Email:</strong> {{ $booking->customer_email }}</li>
                        <li><strong>No. Telepon:</strong> {{ $booking->customer_phone }}</li>
                    </ul>
                </div>
            </div>
            
            <div class="separator"></div>
            
            <div class="order-items">
                <h3 class="section-title">Daftar Pesanan</h3>
                <div class="item">
                    <div class="item-image">{{ $booking->service->id == 1 ? '🕹️' : '🎮' }}</div>
                    <div class="item-details">
                        <div class="item-name">{{ $booking->service->name }}</div>
                        <div class="item-session">{{ $booking->booking_date }}</div>
                        <div class="item-session">{{ $booking->session }}</div>
                    </div>
                    <div class="item-price">
                        <div class="price rupiah">{{ $booking->service->base_price }}</div>
                    </div>
                </div>
            </div>
            
            <div class="separator"></div>

            <div class="payment-summary">
                <div class="info-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                    </svg>
                    <h3 class="info-title">Detail Pembayaran</h3>
                </div>
                <div class="summary-box">
                    <div class="summary-row">
                        <span class="summary-label">Payment Method</span>
                        <span>Midtrans</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Price</span>
                        <span class="rupiah">{{ $booking->service->base_price }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Weekend Surcharge</span>
                        <span class="rupiah">{{ $booking->weekend_surcharge }}</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span class="rupiah">{{ $payment->amount }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <a href="#"></a>
            <a href="{{ url('/') }}" class="btn btn-primary">Konfirmasi</a>
        </div>
    </div>
    
    <div class="help-section">
        <p>Butuh bantuan dengan pesanan Anda? Tim layanan pelanggan kami siap membantu.</p>
        <a href="#">Contact Support</a>
    </div>

    <script>
      document.querySelectorAll('.rupiah').forEach(el => {
        el.innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(el.innerText);
      });
    </script>
</body>
</html>