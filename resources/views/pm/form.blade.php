<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keluarga BaBa - Penilaian PM</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* RESET & DASAR */
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background: #fff9e9;
      color: #3A1309;
    }

    .wrap {
      max-width: 1000px;
      margin: 0 auto;
      padding: 40px 15px;
    }

    h1 { font-weight: 900; font-size: 24px; margin-bottom: 20px; text-align: center; }
    label { font-weight: 700; display: block; margin: 15px 0 5px; color: #4b2c1a; }

    .input {
      width: 100%;
      padding: 12px 14px;
      border-radius: 10px;
      border: 1px solid #ddd;
      background: #fff;
      outline: none;
      font-family: inherit;
      transition: border-color 0.3s;
    }

    /* Custom Tom Select Styling agar serasi dengan desain */
    .ts-control {
        border-radius: 10px !important;
        padding: 10px 14px !important;
        border: 1px solid #ddd !important;
    }
    .ts-wrapper.error .ts-control { border: 2px solid #ff4d4d !important; }

    .input:focus { border-color: #f2c400; }
    .input.error { border: 2px solid #ff4d4d !important; }

    .card {
      background: #fff;
      border-radius: 15px;
      padding: 20px;
      margin-top: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    td { border: 1px solid #eee; padding: 12px; vertical-align: top; }

    .row-penilaian { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .score-box { text-align: center; }
    .score-box span { display: block; font-size: 11px; margin-bottom: 4px; font-weight: 700; color: #666; }
    .input.small { text-align: center; font-weight: 700; }

    @media (max-width: 768px) {
      thead { display: none; }
      tr {
        display: block;
        background: #fafafa;
        border: 2px solid #eee;
        border-radius: 12px;
        margin-bottom: 20px;
        padding: 15px;
        position: relative;
      }
      td { display: block; border: none; padding: 5px 0; }
      .row-penilaian { grid-template-columns: 1fr 1fr; }
      .akhir-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        padding: 10px;
        border-radius: 8px;
        margin-top: 10px;
        border: 1px solid #ddd;
      }
      .del-btn-container { position: absolute; top: 10px; right: 10px; }
    }

    .footer { display: flex; flex-direction: column; gap: 12px; margin-top: 20px; }
    .add { background: #fff; border: 2px solid #3A1309; border-radius: 10px; padding: 14px; font-weight: 900; cursor: pointer; color:#3A1309; }
    .save { background: #3A1309; color: #f7cc1d; border: none; border-radius: 10px; padding: 16px; font-weight: 900; cursor: pointer; font-size: 16px; }
    .del { background: #ff4d4d; color: #fff; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; font-weight: 900; }
    .btn-logout { background: #ff0202; color: #fff; border: none; border-radius: 10px; padding: 10px 20px; font-weight: 900; cursor: pointer; }
    .logout-box { text-align: center; margin-top: 30px; }
  </style>
</head>
<body>

  <div class="wrap">
    <h1>Selamat Datang,<br>{{ auth()->user()->name }} 👋</h1>

    @if(session('ok')) <div class="card" style="background:#d4edda; color:#155724; border:none;">{{ session('ok') }}</div> @endif
    
    <form method="POST" action="{{ route('pm.store') }}" id="mainForm">
      @csrf

      <label>Nama Pengantin</label>
      <input class="input" name="pengantin" placeholder="masukan nama pengantin" value="{{ old('pengantin') }}" required>

      <div style="display: flex; gap: 10px;">
        <div style="flex:1">
            <label>Tanggal</label>
            <input class="input" type="date" name="tanggal" value="{{ old('tanggal') }}" required>
        </div>
        <div style="flex:1">
            <label>Tempat</label>
            <input class="input" name="tempat" placeholder="Nama Gedung/Rumah" value="{{ old('tempat') }}" required>
        </div>
      </div>

      <div class="card">
        <div style="font-weight:900; margin-bottom:15px; border-bottom: 2px solid #f2c400; padding-bottom: 5px;">
            <i class="bi bi-people-fill"></i> PENILAIAN ANGGOTA
        </div>

        <table>
          <tbody id="tbody"></tbody>
        </table>

        <div class="footer">
          <button type="button" class="add" onclick="addRow()"><i class="bi bi-plus-lg"></i> Tambah Anggota</button>
          <button type="submit" class="save">💾 Simpan Semua Data</button>
        </div>
      </div>
    </form>

    <div class="logout-box">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn-logout" type="submit"><i class="bi bi-box-arrow-right"></i> LOGOUT</button>
        </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
  let idx = {{ old('items') ? count(old('items')) : 0 }};

  function calcRow(tr) {
    const scores = tr.querySelectorAll('.score');
    let sum = 0;
    scores.forEach(inp => { 
        sum += parseInt(inp.value || 0, 10); 
    });
    tr.querySelector('.akhir').value = sum;
  }

  function addRow(data = null) {
    const tbody = document.getElementById('tbody');
    const tr = document.createElement('tr');
    const cIdx = data ? data.realIdx : idx;

    const v = data || {
      anggota: '', posisi: '', waktu: 1, kerja_sama: 1, hospitality: 1, komunikasi: 1, inisiatif: 1
    };

    tr.innerHTML = `
      <td>
        <div class="select-box-container">
            <select class="anggota-select" name="items[${cIdx}][anggota]" placeholder="Ketik nama anggota..." required>
              <option value="">Ketik nama anggota...</option>
              @foreach($anggotaList as $a)
                <option value="{{ $a->nama }}" data-posisi="{{ $a->posisi ?? '' }}" ${v.anggota == '{{ $a->nama }}' ? 'selected' : ''}>{{ $a->nama }}</option>
              @endforeach
            </select>
        </div>

        <select class="input" name="items[${cIdx}][posisi]" style="margin-top:10px;" required>
          <option value="">Pilih Posisi</option>
          @foreach($posisiList as $p)
            <option value="{{ $p }}" ${v.posisi == '{{ $p }}' ? 'selected' : ''}>{{ $p }}</option>
          @endforeach
        </select>
      </td>

      <td>
        <div class="row-penilaian">
          <div class="score-box"><span>WAKTU</span><input class="input small score" type="number" name="items[${cIdx}][waktu]" value="${v.waktu}" min="1" max="20" required></div>
          <div class="score-box"><span>KERJASAMA</span><input class="input small score" type="number" name="items[${cIdx}][kerja_sama]" value="${v.kerja_sama}" min="1" max="20" required></div>
          <div class="score-box"><span>HOSPITALITY</span><input class="input small score" type="number" name="items[${cIdx}][hospitality]" value="${v.hospitality}" min="1" max="20" required></div>
          <div class="score-box"><span>KOMUNIKASI</span><input class="input small score" type="number" name="items[${cIdx}][komunikasi]" value="${v.komunikasi}" min="1" max="20" required></div>
          <div class="score-box"><span>INISIATIF</span><input class="input small score" type="number" name="items[${cIdx}][inisiatif]" value="${v.inisiatif}" min="1" max="20" required></div>
        </div>

        <div class="akhir-container">
            <span style="font-weight:900; font-size:13px;">NILAI AKHIR:</span>
            <input class="input small akhir" type="number" value="0" readonly style="width:60px; color:red; border:none; background:transparent; font-size:18px;">
        </div>
      </td>

      <td class="del-btn-container">
        <button type="button" class="del" onclick="removeRow(this)">×</button>
      </td>
    `;

    tbody.appendChild(tr);

    // Inisialisasi Tom Select untuk pencarian nama
    const selectElement = tr.querySelector('.anggota-select');
    const ts = new TomSelect(selectElement, {
        create: false,
        sortField: { field: "text", direction: "asc" },
        onChange: function(value) {
            // Logika Autofill Posisi
            const option = selectElement.options[selectElement.selectedIndex];
            const posisi = option ? option.getAttribute('data-posisi') : '';
            const posisiSelect = tr.querySelector('select[name*="[posisi]"]');
            if(posisi && posisiSelect) {
                posisiSelect.value = posisi;
                posisiSelect.classList.remove('error');
            }
            selectElement.parentElement.querySelector('.ts-control').classList.remove('error');
        }
    });

    calcRow(tr);
    if(!data) idx++;
  }

  window.onload = () => {
    @if(old('items'))
      @foreach(old('items') as $i => $item)
        addRow({
          realIdx: {{ $i }},
          anggota: '{{ $item["anggota"] }}',
          posisi: '{{ $item["posisi"] }}',
          waktu: {{ $item["waktu"] }},
          kerja_sama: {{ $item["kerja_sama"] }},
          hospitality: {{ $item["hospitality"] }},
          komunikasi: {{ $item["komunikasi"] }},
          inisiatif: {{ $item["inisiatif"] }}
        });
      @endforeach
    @else
      addRow();
    @endif
  };

  document.getElementById('mainForm').addEventListener('submit', function(e) {
    const requiredInputs = this.querySelectorAll('[required]');
    let isComplete = true;

    requiredInputs.forEach(input => {
      if (!input.value || input.value === "") {
        isComplete = false;
        // Penanganan khusus error visual untuk Tom Select
        if(input.classList.contains('anggota-select')){
            input.parentElement.querySelector('.ts-control').classList.add('error');
        } else {
            input.classList.add('error');
        }
      }
    });

    if (!isComplete) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Belum Lengkap',
        text: 'Tolong lengkapi nama anggota dan semua penilaian ya!',
        confirmButtonColor: '#3A1309'
      });
    }
  });

  document.addEventListener('input', function(e) {
    if(e.target.classList.contains('score')) {
      if(parseInt(e.target.value) > 20) e.target.value = 20;
      calcRow(e.target.closest('tr'));
    }
  });

  function removeRow(btn) {
    const tbody = document.getElementById('tbody');
    if (tbody.querySelectorAll('tr').length === 1) return;
    btn.closest('tr').remove();
  }
</script>
</body>
</html>