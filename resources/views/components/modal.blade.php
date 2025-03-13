<div id="timeSlotModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>

    <div id="step1">
      <h2 id="modal-title">Pilih Sesi</h2>
      <div id="modal-body"></div>
    </div>

    <div id="step2" style="display: none;">
      <h2>Konfirmasi Pemesanan</h2>
      <p id="selected-session"></p>

      <form class="form-container">
        <input type="text" placeholder="Nama" id="name" class="input-field">
        <input type="text" placeholder="Email" id="email" class="input-field">
        <input type="text" placeholder="No Telepon" id="phone" class="input-field">
      </form>

      <div class="price-container">
          <div class="price-item">Price <span id="base-price">10,000</span></div>
          <div class="price-item">Weekend Surcharge <span id="weekend-surcharge">0</span></div>
          <div class="price-item total">Total <span id="total">10,000</span></div>
      </div>

      <div style="display: flex; justify-content: space-between; gap: 5px;">
        <button type="button" class="back-btn" id="back-btn">Kembali</button>
        <button type="button" class="confirm-btn" id="confirm-btn">Lanjut Pembayaran</button>
      </div>

    </div>
  </div>
</div>
