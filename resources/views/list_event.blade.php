<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Event</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f5f7;
      color: #1a1a1a;
      min-height: 100vh;
      padding: 2rem 1rem;
    }

    .container {
      max-width: 700px;
      margin: 0 auto;
    }

    .header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 1.5rem;
    }

    .header-title p {
      font-size: 13px;
      color: #888;
      margin-bottom: 2px;
    }

    .header-title h1 {
      font-size: 22px;
      font-weight: 600;
    }

    .filter-buttons {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .filter-buttons button {
      font-size: 13px;
      padding: 6px 16px;
      border-radius: 8px;
      border: 1px solid #ddd;
      background: transparent;
      color: #666;
      cursor: pointer;
      transition: all 0.2s;
    }

    .filter-buttons button.active {
      background: #1a1a1a;
      color: #fff;
      border-color: #1a1a1a;
    }

    .filter-buttons button:hover:not(.active) {
      background: #eee;
    }

    .event-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .event-card {
      display: flex;
      align-items: center;
      gap: 16px;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 14px 16px;
      transition: box-shadow 0.2s;
    }

    .event-card:hover {
      box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    }

    .event-card.selesai {
      opacity: 0.6;
    }

    .event-date {
      min-width: 50px;
      text-align: center;
      padding-right: 16px;
      border-right: 1px solid #e5e7eb;
    }

    .event-date .month {
      font-size: 11px;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .event-date .day {
      font-size: 22px;
      font-weight: 600;
      color: #1a1a1a;
      line-height: 1.2;
    }

    .event-info {
      flex: 1;
      min-width: 0;
    }

    .event-name-row {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
      margin-bottom: 4px;
    }

    .event-name {
      font-size: 15px;
      font-weight: 600;
      color: #1a1a1a;
    }

    .badge {
      font-size: 11px;
      padding: 2px 10px;
      border-radius: 20px;
      white-space: nowrap;
    }

    .badge-workshop  { background: #EEEDFE; color: #3C3489; }
    .badge-seminar   { background: #E6F1FB; color: #0C447C; }
    .badge-kompetisi { background: #FAECE7; color: #712B13; }
    .badge-komunitas { background: #EAF3DE; color: #27500A; }
    .badge-pameran   { background: #FAEEDA; color: #633806; }

    .event-meta {
      font-size: 13px;
      color: #666;
    }

    .event-meta .dot {
      margin: 0 6px;
      color: #ccc;
    }

    .status-badge {
      font-size: 12px;
      padding: 4px 12px;
      border-radius: 8px;
      white-space: nowrap;
    }

    .status-upcoming {
      background: #E1F5EE;
      color: #0F6E56;
    }

    .status-done {
      background: #f1f1f1;
      color: #888;
      border: 1px solid #e0e0e0;
    }

    .empty {
      text-align: center;
      color: #aaa;
      font-size: 14px;
      padding: 2rem 0;
    }
  </style>
</head>
<body>
  <div class="container">

    <div class="header">
      <div class="header-title">
        <p>Maret 2026</p>
        <h1>Daftar Event</h1>
      </div>
      <div class="filter-buttons">
        <button class="active" onclick="filterEvents('semua', this)">Semua</button>
        <button onclick="filterEvents('upcoming', this)">Akan Datang</button>
        <button onclick="filterEvents('selesai', this)">Selesai</button>
      </div>
    </div>

    <div class="event-list" id="event-list"></div>

  </div>

  <script>
    const events = [
      {
        nama: "Workshop UI/UX Design",
        tanggal: "18 Mar 2026",
        waktu: "09.00 – 12.00",
        lokasi: "Gedung Kreatif, Lt. 3",
        kategori: "Workshop",
        status: "upcoming"
      },
      {
        nama: "Tech Talk: AI & Masa Depan",
        tanggal: "20 Mar 2026",
        waktu: "13.00 – 15.00",
        lokasi: "Aula Utama",
        kategori: "Seminar",
        status: "upcoming"
      },
      {
        nama: "Hackathon Palembang 2026",
        tanggal: "22 Mar 2026",
        waktu: "08.00 – 20.00",
        lokasi: "Kampus Digital Sriwijaya",
        kategori: "Kompetisi",
        status: "upcoming"
      },
      {
        nama: "Temu Komunitas Developer",
        tanggal: "10 Mar 2026",
        waktu: "16.00 – 18.00",
        lokasi: "Co-working Space Ilir",
        kategori: "Komunitas",
        status: "selesai"
      },
      {
        nama: "Pameran Startup Sumatra",
        tanggal: "05 Mar 2026",
        waktu: "10.00 – 17.00",
        lokasi: "Palembang Trade Center",
        kategori: "Pameran",
        status: "selesai"
      }
    ];

    const badgeClass = {
      "Workshop":   "badge-workshop",
      "Seminar":    "badge-seminar",
      "Kompetisi":  "badge-kompetisi",
      "Komunitas":  "badge-komunitas",
      "Pameran":    "badge-pameran"
    };

    function filterEvents(filter, btn) {
      document.querySelectorAll('.filter-buttons button').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filtered = filter === 'semua' ? events : events.filter(e => e.status === filter);
      renderEvents(filtered);
    }

    function renderEvents(list) {
      const container = document.getElementById('event-list');

      if (!list.length) {
        container.innerHTML = '<p class="empty">Tidak ada event.</p>';
        return;
      }

      container.innerHTML = list.map(e => {
        const parts = e.tanggal.split(' ');
        const day = parts[0];
        const month = parts[1];
        const isDone = e.status === 'selesai';

        return `
        <div class="event-card ${isDone ? 'selesai' : ''}">
          <div class="event-date">
            <div class="month">${month}</div>
            <div class="day">${day}</div>
          </div>
          <div class="event-info">
            <div class="event-name-row">
              <span class="event-name">${e.nama}</span>
              <span class="badge ${badgeClass[e.kategori] || ''}">${e.kategori}</span>
            </div>
            <div class="event-meta">
              <span>${e.waktu}</span>
              <span class="dot">·</span>
              <span>${e.lokasi}</span>
            </div>
          </div>
          <div>
            ${isDone
              ? `<span class="status-badge status-done">Selesai</span>`
              : `<span class="status-badge status-upcoming">Akan Datang</span>`
            }
          </div>
        </div>`;
      }).join('');
    }

    renderEvents(events);
  </script>
</body>
</html>