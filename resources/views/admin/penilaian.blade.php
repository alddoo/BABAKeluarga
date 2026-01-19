@extends('admin.layout')
@section('title','Admin - Penilai PM')

@section('content')
  <h1 class="title" style="font-size:40px;">Penilai PM</h1>

  @forelse($penilaian as $p)
    <div class="panel mb16">
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
              <td><b style="color:#d20000;">{{ $it->nilai_akhir }}</b></td>
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

  <div class="mt16">
    {{ $penilaian->links() }}
  </div>
@endsection
