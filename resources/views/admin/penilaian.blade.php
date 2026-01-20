@extends('admin.layout')
@section('title','Admin - Penilai PM')

@section('content')
  <h1 class="title" style="font-size:40px;">Penilain PM</h1>

  <div class="panel mb32">
    <form method="GET" action="{{ route('admin.penilaian') }}" style="display:flex;gap:10px;flex-wrap:wrap;">
      <input class="input" name="q" value="{{ request('q') }}" placeholder="Cari nama pengantin atau tempat..."
             style="padding:12px 14px;border-radius:12px;border:1px solid #ddd;min-width:280px;">
      <button type="submit" style="padding:12px 14px;border:none;border-radius:12px;background:#1f2a2e;color:#fff;font-weight:900;cursor:pointer;">
        Cari
      </button>
    </form>
  </div>

  <div class="panel mb32">
    <a href="{{ route('admin.penilaian.export') }}"
       style="padding:12px 14px;border-radius:12px;background:#28a745;color:#fff;font-weight:900;">
      Export Word
    </a>
  </div>

  @forelse($penilaian as $p)
    <div class="panel mb32">
      <div style="display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;">
        <div><b>Pengantin:</b> {{ $p->pengantin }}</div>
        <div><b>Tanggal:</b> {{ $p->tanggal }}</div>
        <div><b>Tempat:</b> {{ $p->tempat }}</div>
        <div><b>PM:</b> {{ $p->user->name }}</div>
      </div>

      <table class="mt16">
        <thead>
          <tr>
            <th>Anggota</th>
            <th>Posisi</th>
            <th>Waktu</th>
            <th>Kerja Sama</th>
            <th>Hospitality</th>
            <th>Komunikasi</th>
            <th>Inisiatif</th>
            <th>Nilai Akhir</th>
          </tr>
        </thead>
        <tbody>
          @foreach($p->items as $it)
            <tr>
              <td>{{ $it->anggota }}</td>
              <td>{{ $it->posisi }}</td>
              <td>{{ $it->waktu }}</td>
              <td>{{ $it->kerja_sama }}</td>
              <td>{{ $it->hospitality }}</td>
              <td>{{ $it->komunikasi }}</td>
              <td>{{ $it->inisiatif }}</td>
              <td>{{ $it->nilai_akhir }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @empty
    <div class="panel">
      Belum ada data penilaian.
    </div>
  @endforelse

@endsection
