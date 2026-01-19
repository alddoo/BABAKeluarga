<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keluarga BaBa - Input</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <style>
    /* RESET & BASE */
    * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background: #fff9e9; /* Warna krem khas BaBa */
      color: #3A1309;
    }

    .wrap {
      max-width: 500px; /* Ukuran ideal HP */
      margin: 0 auto;
      padding: 40px 20px;
    }

    /* HEADER */
    h1 {
      font-size: 24px;
      font-weight: 900;
      text-align: center;
      margin-bottom: 30px;
      line-height: 1.3;
    }

    /* CARD FORM */
    .form-card {
      background: #fff;
      padding: 25px;
      border-radius: 24px;
      box-shadow: 0 10px 25px rgba(58, 19, 9, 0.08);
    }

    /* INPUT STYLE */
    label {
      font-weight: 700;
      font-size: 14px;
      margin-bottom: 8px;
      display: block;
      color: #4b2c1a;
      margin-top: 15px;
    }

    .input, select, textarea {
      width: 100%;
      padding: 14px 16px;
      border-radius: 12px;
      border: 2px solid #eee;
      outline: none;
      background: #fafafa;
      font-family: inherit;
      font-size: 15px;
      transition: all 0.3s ease;
      margin-bottom: 5px;
    }

    textarea {
      resize: none;
      min-height: 80px;
    }

    .input:focus, textarea:focus {
      border-color: #f7cc1d;
      background: #fff;
    }

    /* CUSTOM FILE INPUT */
    input[type="file"] {
      padding: 10px;
      font-size: 13px;
      border: 2px dashed #ccc;
      background: #fff;
    }

    /* BUTTONS */
    .btn-save {
      width: 100%;
      background: #3A1309;
      color: #f7cc1d;
      border: none;
      border-radius: 14px;
      padding: 16px;
      font-weight: 700;
      font-size: 16px;
      cursor: pointer;
      margin-top: 25px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      transition: transform 0.2s;
    }

    .btn-save:active {
      transform: scale(0.97);
    }

    .logout-container {
      text-align: center;
      margin-top: 30px;
    }

    .btn-logout {
      background: transparent;
      color: #ff4d4d;
      border: none;
      font-weight: 700;
      font-size: 15px;
      cursor: pointer;
      text-decoration: underline;
    }

    /* ALERTS */
    .msg {
      background: #d4edda;
      color: #155724;
      border-radius: 12px;
      padding: 14px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 600;
      text-align: center;
      border-left: 5px solid #28a745;
    }

    /* ICON */
    .bi { font-size: 1.2rem; }
  </style>
</head>
<body>

  <div class="wrap">
    <h1>Selamat Datang,<br>{{ auth()->user()->name }} 👋</h1>

    <a href="{{ route('wa.history') }}">Lihat History Data</a>

    @if(session('ok')) 
      <div class="msg">
        <i class="bi bi-check-circle-fill"></i> {{ session('ok') }}
      </div> 
    @endif

    <div class="form-card">
      <form method="POST" action="{{ route('wa.store') }}" enctype="multipart/form-data">
        @csrf
        
        <label>Nama Lengkap</label>
        <input class="input" name="nama" placeholder="masukan nama" value="{{ old('nama') }}">

        <div style="display: flex; gap: 15px;">
          <div style="flex: 1;">
            <label>Tanggal</label>
            <input class="input" type="date" name="tanggal" value="{{ old('tanggal') }}">
          </div>
          <div style="flex: 1;">
            <label>Waktu</label>
            <input class="input" type="time" name="waktu" value="{{ old('waktu') }}">
          </div>
        </div>

        <label>Pilih Kegiatan</label>
        <select class="input" name="kegiatan">
          <option value="">-- Pilih Kegiatan --</option>
          @foreach($kegiatanList as $k)
            <option value="{{ $k }}" @selected(old('kegiatan')==$k)>{{ $k }}</option>
          @endforeach
        </select>

        <label>Deskripsi Singkat</label>
        <textarea name="deskripsi" placeholder="jelaskan detail kegiatan di sini..." class="input">{{ old('deskripsi') }}</textarea>

        <label>Lampiran File (Foto/Dokumen)</label>
        <input class="input" type="file" name="file">

        <button class="btn-save" type="submit">
          <i class="bi bi-cloud-arrow-up-fill"></i> Simpan Data
        </button>
      </form>
    </div>

    <div class="logout-container">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn-logout" type="submit">
          <i class="bi bi-box-arrow-right"></i> Keluar dari Akun
        </button>
      </form>
    </div>
  </div>

</body>
</html>