@extends('admin.layout')
@section('title','Admin - Daily Report')

@section('content')
  <h1 class="title" style="font-size:40px;">Daily Report</h1>

  <div class="panel">
    
    <div style="margin-bottom: 20px; display: flex; gap: 10px;">
        
        <a href="{{ route('daily.export.word') }}" class="btn" style="background-color: #2980b9; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-size: 14px;">
            <i class="bi bi-file-earmark-word"></i> Export Word
        </a>
    </div>
    <table class="mt16">
      <thead>
        <tr>
          <th style="width: 150px;">Waktu</th>
          <th style="width: 150px;">Nama</th>
          <th style="width: 120px;">Kegiatan</th>
          <th>Deskripsi Singkat</th>
          <th style="width: 100px;">File</th>
          <th style="width: 150px;">User WA</th>
        </tr>
      </thead>
      <tbody>
        @forelse($daily as $d)
          <tr>
            <td style="white-space: nowrap;">
                <strong>{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</strong><br>
                <small class="text-muted"><i class="bi bi-clock"></i> {{ $d->waktu }}</small>
            </td>
            <td>{{ $d->nama }}</td>
            <td><span class="badge">{{ $d->kegiatan }}</span></td>
            <td>
                <div style="line-height: 1.5; font-size: 13px; color: #444;">
                    {{ $d->deskripsi ?? '-' }}
                </div>
            </td>
            <td>
              @if($d->file_path)
                <a href="{{ asset('storage/'.$d->file_path) }}" target="_blank" style="text-decoration: none;">
                    <i class="bi bi-file-earmark-text"></i> Lihat
                </a>
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
            <td>
                <i class="bi bi-person-circle"></i> {{ $d->user->name }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align: center; padding: 30px; color: #888;">
                <i class="bi bi-inbox" style="font-size: 2rem;"></i><br>
                Belum ada data daily report yang masuk.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt16">
      {{ $daily->links() }}
    </div>
  </div>
@endsection