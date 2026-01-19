@extends('admin.layout')
@section('title','Admin - Edit Anggota')

@section('content')
  <h1 class="title" style="font-size:40px;">Edit Anggota</h1>

  <div class="panel">
    <form method="POST" action="{{ route('admin.anggota.update',$anggota) }}">
      @csrf
      @method('PUT')

      <div style="margin-bottom:14px;">
        <label style="font-weight:900;">Nama</label>
        <input name="nama" value="{{ old('nama',$anggota->nama) }}"
               style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid #ddd;">
        @error('nama') <div style="color:#b00020;margin-top:6px;">{{ $message }}</div> @enderror
      </div>

      <div style="margin-bottom:14px;">
        <label style="font-weight:900;">Posisi</label>
        <input name="posisi" value="{{ old('posisi',$anggota->posisi) }}"
               style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid #ddd;">
        @error('posisi') <div style="color:#b00020;margin-top:6px;">{{ $message }}</div> @enderror
      </div>

      <div style="display:flex;gap:10px;">
        <button type="submit"
                style="padding:12px 16px;border:none;border-radius:12px;background:#1f2a2e;color:#fff;font-weight:900;cursor:pointer;">
          Update
        </button>
        <a href="{{ route('admin.anggota.index') }}"
           style="padding:12px 16px;border-radius:12px;background:#f2c400;color:#2a2a2a;font-weight:900;">
          Kembali
        </a>
      </div>
    </form>
  </div>
@endsection
            