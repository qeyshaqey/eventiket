<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Event | Eventiket</title>
  <style>
    :root {
      --navy: #192853;
      --cream: #EFF8FF;
      --yellow: #FFE14E;
      --white: #ffffff;
      --gray: #475569;
      --shadow: 0 18px 55px rgba(25, 40, 83, 0.12);
      --radius: 24px;
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Inter', system-ui, sans-serif;
      background: linear-gradient(180deg, #f8fbff 0%, #eff8ff 100%);
      color: var(--navy);
    }

    .page-hero {
      padding: 54px 24px 42px;
      text-align: center;
      background: radial-gradient(circle at top, rgba(255,225,78,0.18), transparent 40%), var(--navy);
      color: var(--white);
      position: relative;
      overflow: hidden;
    }

    .page-hero::after {
      content: '';
      position: absolute;
      inset: 0;
      opacity: 0.12;
      background: radial-gradient(circle at center, #ffe14e 0%, transparent 55%);
    }

    .page-hero .page-content {
      position: relative;
      z-index: 1;
      max-width: 900px;
      margin: 0 auto;
    }

    .page-hero .badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 10px 18px;
      border-radius: 999px;
      background: rgba(255,225,78,0.18);
      color: var(--yellow);
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .page-hero h1 {
      font-size: clamp(2.4rem, 4vw, 3.5rem);
      margin: 18px 0 12px;
      line-height: 1.04;
      letter-spacing: -0.04em;
    }

    .page-hero p {
      max-width: 760px;
      margin: 0 auto;
      color: rgba(255,255,255,0.88);
      font-size: 1rem;
      line-height: 1.8;
    }

    .content {
      padding: 40px 24px 96px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .detail-grid {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 32px;
      margin-bottom: 32px;
    }

    @media (max-width: 900px) {
      .detail-grid {
        grid-template-columns: 1fr;
      }
    }

    .detail-poster {
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: var(--shadow);
      background: var(--white);
    }

    .detail-poster img {
      width: 100%;
      display: block;
      object-fit: cover;
      min-height: 420px;
    }

    .detail-info {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .detail-info h2 {
      margin: 0;
      font-size: clamp(2rem, 3vw, 2.8rem);
      line-height: 1.1;
    }

    .detail-meta {
      display: grid;
      gap: 14px;
      background: var(--white);
      border-radius: var(--radius);
      padding: 26px;
      box-shadow: var(--shadow);
      border: 1px solid rgba(25,40,83,0.08);
    }

    .detail-meta span {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      color: var(--gray);
      font-size: 0.98rem;
    }

    .detail-meta span strong {
      color: var(--navy);
      min-width: 90px;
      display: inline-block;
    }

    .ticket-panel {
      background: var(--white);
      border-radius: var(--radius);
      padding: 28px;
      box-shadow: var(--shadow);
      border: 1px solid rgba(25,40,83,0.08);
    }

    .ticket-panel h3 {
      margin: 0 0 18px;
      font-size: 1.3rem;
      color: var(--navy);
    }

    .ticket-options {
      display: grid;
      gap: 14px;
      margin-bottom: 24px;
    }

    .ticket-type {
      display: grid;
      grid-template-columns: 1fr auto;
      align-items: center;
      padding: 16px 18px;
      border-radius: 20px;
      border: 1px solid rgba(25,40,83,0.12);
      transition: border-color 0.2s ease, background 0.2s ease;
      cursor: pointer;
      background: #f8fbff;
    }

    .ticket-type input {
      display: none;
    }

    .ticket-type.selected {
      border-color: var(--yellow);
      background: rgba(255,225,78,0.18);
    }

    .ticket-name {
      font-weight: 700;
      color: var(--navy);
      font-size: 1rem;
    }

    .ticket-price {
      color: var(--gray);
      font-size: 0.96rem;
    }

    .ticket-side {
      text-align: right;
      min-width: 120px;
    }

    .quantity {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
    }

    .quantity span {
      font-size: 0.95rem;
      color: var(--gray);
    }

    .quantity-control {
      display: flex;
      align-items: center;
      gap: 8px;
      border-radius: 999px;
      background: #eef4ff;
      padding: 8px;
      box-shadow: inset 0 1px 2px rgba(25,40,83,0.08);
    }

    .quantity-control button {
      width: 36px;
      height: 36px;
      border: none;
      border-radius: 50%;
      background: var(--navy);
      color: var(--white);
      font-size: 1.2rem;
      cursor: pointer;
    }

    .quantity-control span {
      min-width: 36px;
      text-align: center;
      font-weight: 700;
      font-size: 1rem;
      color: var(--navy);
    }

    .total-box {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 22px;
      border-radius: 20px;
      background: rgba(25,40,83,0.04);
      border: 1px solid rgba(25,40,83,0.08);
      margin-bottom: 32px;
      color: var(--navy);
      font-weight: 700;
    }

    .bottom-footer {
      background: var(--navy);
      color: var(--white);
      padding: 24px 24px 40px;
      text-align: center;
      border-top-left-radius: 32px;
      border-top-right-radius: 32px;
      box-shadow: 0 -18px 45px rgba(25,40,83,0.12);
      margin-top: 40px;
    }

    .buy-button {
      padding: 16px 32px;
      border: none;
      border-radius: 999px;
      background: var(--yellow);
      color: var(--navy);
      cursor: pointer;
      font-weight: 700;
      font-size: 1rem;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .buy-button:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 30px rgba(255,225,78,0.22);
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: var(--white);
      text-decoration: none;
      font-weight: 600;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <section class="page-hero">
    <div class="page-content">
      <a href="/dashboard_peserta" class="back-link">&larr; Kembali ke Dashboard</a>
      <span class="badge">{{ $event['category'] }}</span>
      <h1>{{ $event['title'] }}</h1>
      <p>{{ $event['status'] }} — Klik tombol tiket untuk memulai pesanan.</p>
    </div>
  </section>

  <main class="content">
    <div class="detail-grid">
      <div class="detail-poster">
        <img src="{{ asset('image/' . $event['image']) }}" alt="{{ $event['title'] }}" />
      </div>

      <div class="detail-info">
        <div class="detail-meta">
          <span><strong>Judul</strong>{{ $event['title'] }}</span>
          <span><strong>Tanggal</strong>{{ $event['date'] }}</span>
          <span><strong>Waktu</strong>{{ $event['time'] }}</span>
          <span><strong>Lokasi</strong>{{ $event['venue'] }}</span>
        </div>

        <section class="ticket-panel">
          <h3>Pilih Jenis Tiket</h3>
          <div class="ticket-options">
            @foreach ($event['tickets'] as $ticket)
              <label class="ticket-type{{ $loop->first ? ' selected' : '' }}">
                <input type="radio" name="ticket_type" value="{{ $ticket['price'] }}" {{ $loop->first ? 'checked' : '' }} />
                <div>
                  <div class="ticket-name">{{ $ticket['type'] }}</div>
                  <div class="ticket-price">Rp {{ number_format($ticket['price'], 0, ',', '.') }}</div>
                </div>
              </label>
            @endforeach
          </div>

          <div class="quantity">
            <span>Jumlah Tiket</span>
            <div class="quantity-control">
              <button type="button" id="decrement">-</button>
              <span id="ticketQuantity">1</span>
              <button type="button" id="increment">+</button>
            </div>
          </div>

          <div class="total-box">
            <span>Total Harga</span>
            <span id="totalPrice"></span>
          </div>
        </section>
      </div>
    </div>
  </main>

  <footer class="bottom-footer">
    <button class="buy-button" type="button" id="buyButton">Beli Tiket</button>
  </footer>

  <script>
    const quantityEl = document.getElementById('ticketQuantity');
    const totalPriceEl = document.getElementById('totalPrice');
    const ticketRadios = document.querySelectorAll('input[name="ticket_type"]');
    const ticketLabels = document.querySelectorAll('.ticket-type');
    let quantity = 1;

    function formatRupiah(value) {
      return new Intl.NumberFormat('id-ID').format(value);
    }

    function getSelectedPrice() {
      const checked = document.querySelector('input[name="ticket_type"]:checked');
      return checked ? Number(checked.value) : 0;
    }

    function updateTotal() {
      const price = getSelectedPrice();
      totalPriceEl.textContent = 'Rp ' + formatRupiah(price * quantity);
    }

    function resetSelectedClass() {
      ticketLabels.forEach(label => label.classList.remove('selected'));
      const checked = document.querySelector('input[name="ticket_type"]:checked');
      if (checked) {
        checked.closest('.ticket-type').classList.add('selected');
      }
    }

    ticketRadios.forEach(radio => {
      radio.addEventListener('change', () => {
        resetSelectedClass();
        updateTotal();
      });
    });

    document.getElementById('increment').addEventListener('click', () => {
      quantity += 1;
      quantityEl.textContent = quantity;
      updateTotal();
    });

    document.getElementById('decrement').addEventListener('click', () => {
      if (quantity > 1) {
        quantity -= 1;
        quantityEl.textContent = quantity;
        updateTotal();
      }
    });

    document.getElementById('buyButton').addEventListener('click', () => {
      const selectedType = document.querySelector('input[name="ticket_type"]:checked').closest('.ticket-type').querySelector('.ticket-name').textContent;
      alert(`Pesanan: ${quantity} x ${selectedType} \nTotal: ${totalPriceEl.textContent}`);
    });

    resetSelectedClass();
    updateTotal();
  </script>
</body>
</html>
