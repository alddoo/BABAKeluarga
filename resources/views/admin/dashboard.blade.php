@extends('admin.layout')
@section('title','Admin - Beranda')

@section('content')
        <h1>
            Selamat Datang, {{ auth()->user()->name }} 👋
        </h1>

  <div class="cards">
    <div class="card">
      <div class="icon">👥</div>
      <div class="label">Total Anggota</div>
      <div class="value">{{ $totalAnggota }} Orang</div>
    </div>

    <div class="card">
      <div class="icon">✅</div>
      <div class="label">Penilaian Selesai</div>
      <div class="value">{{ $penilaianSelesai }} Penilaian</div>
    </div>

    <div class="card">
      <div class="icon">🗒️</div>
      <div class="label">Daily Report</div>
      <div class="value">{{ $dailyReportBaru }} Laporan Baru</div>
    </div>
  </div>

  <div class="panel">
    <h3>Status Program & Aktivitas</h3>
    <p class="muted">Ringkasan input terbaru dari Wedding Assistant dan Projject Manager.</p>

    <div class="links-top">
      <a class="btn-link" href="{{ route('admin.daily') }}">📒 Lihat Daily Report</a>
      <a class="btn-link" href="{{ route('admin.penilaian') }}">📝 Lihat Penilaian PM</a>
    </div>

    <div class="grid2">
      <div class="box">
        <div class="box-title">Daily Report Terbaru</div>
        <table>
          <thead>
            <tr>
              <th>Waktu</th>
              <th>Nama</th>
              <th>Kegiatan</th>
            </tr>
          </thead>
          <tbody>
            @forelse($latestDaily as $d)
              <tr>
                <td>{{ $d->tanggal }} {{ $d->waktu }}</td>
                <td>{{ $d->nama }}</td>
                <td><span class="badge">{{ $d->kegiatan }}</span></td>
              </tr>
            @empty
              <tr><td colspan="3">Belum ada data.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="box">
        <div class="box-title">Penilaian PM Terbaru</div>
        <table>
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Pengantin</th>
              <th>Tempat</th>
            </tr>
          </thead>
          <tbody>
            @forelse($latestPenilaian as $p)
              <tr>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->pengantin }}</td>
                <td>{{ $p->tempat }}</td>
              </tr>
            @empty
              <tr><td colspan="3">Belum ada data.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
