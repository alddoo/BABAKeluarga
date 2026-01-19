@extends('admin.layout')
@section('title','Admin - Anggota')

@section('content')
  <h1 class="title" style="font-size:40px;">Anggota</h1>

  @if(session('ok'))
    <div class="panel mb16">{{ session('ok') }}</div>
  @endif

  <div class="panel mb16">
    <form method="GET" action="{{ route('admin.anggota.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;">
      <input class="input" name="q" value="{{ $q }}" placeholder="Cari nama / posisi..."
             style="padding:12px 14px;border-radius:12px;border:1px solid #ddd;min-width:280px;">
      <button type="submit" style="padding:12px 14px;border:none;border-radius:12px;background:#1f2a2e;color:#fff;font-weight:900;cursor:pointer;">
        Cari
      </button>
      <a href="{{ route('admin.anggota.create') }}"
         style="margin-left:auto;padding:12px 14px;border-radius:12px;background:#f2c400;color:#2a2a2a;font-weight:900;">
        + Tambah Anggota
      </a>
    </form>
  </div>

  <div class="panel">
    <table>
      <thead>
        <tr>
          <th style="width:70px;">No</th>
          <th>Nama</th>
          <th>Posisi</th>
          <th>Total Job</th>
          <th>Nilai Akhir</th>
          <th style="width:220px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($anggotas as $i => $a)
          <tr>
            <td>{{ $anggotas->firstItem() + $i }}</td>
            <td><b>{{ $a->nama }}</b></td>
            <td>{{ $a->posisi ?? '-' }}</td>
            <td>
                <span style="background: #e3e3e3; padding: 4px 10px; border-radius: 8px; font-weight: bold;">
                    {{ $a->penilaian_count }}
                </span>
            </td>
            <td>
                <span style="background: #f2c400; padding: 4px 10px; border-radius: 8px; font-weight: bold;">
                    {{ number_format($a->nilai_akhir_avg, 2) }}
                </span>
            </td>
            <td>
              <a href="{{ route('admin.anggota.edit',$a) }}"
                 style="display:inline-block;padding:8px 12px;border-radius:10px;background:#1f2a2e;color:#fff;font-weight:900;">
                Edit
              </a>

              <form method="POST" action="{{ route('admin.anggota.destroy',$a) }}"
                    style="display:inline-block" onsubmit="return confirm('Yakin hapus anggota ini?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        style="padding:8px 12px;border:none;border-radius:10px;background:#ff4b4b;color:#fff;font-weight:900;cursor:pointer;">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6">Belum ada anggota.</td></tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt16">{{ $anggotas->links() }}</div>
  </div>
@endsection