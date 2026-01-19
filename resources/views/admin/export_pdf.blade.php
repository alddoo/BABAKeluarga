<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; word-wrap: break-word; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .img-box { text-align: center; }
        img { width: 100px; height: auto; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DAILY REPORT</h2>
        <p>Dicetak pada: {{ date('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 12%">Waktu</th>
                <th style="width: 12%">Nama</th>
                <th style="width: 12%">Kegiatan</th>
                <th style="width: 25%">Deskripsi</th>
                <th style="width: 20%">Foto Lampiran</th>
                <th style="width: 10%">User WA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daily as $d)
            <tr>
                <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}<br>{{ $d->waktu }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->kegiatan }}</td>
                <td>{{ $d->deskripsi ?? '-' }}</td>
                <td class="img-box">
                    @php $path = public_path('storage/' . $d->file_path); @endphp
                    @if($d->file_path && file_exists($path))
                        <img src="{{ $path }}">
                    @else
                        <small style="color: grey;">Tidak ada foto</small>
                    @endif
                </td>
                <td>{{ $d->user->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>