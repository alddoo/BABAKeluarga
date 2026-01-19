<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Data WA</title>
</head>
<body>
    <h1>History Data WA</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->nama }}</td>
                    <td>{{ $report->created_at }}</td>
                    <td>{{ $report->kegiatan }}</td>
                    <td>
                        @if($report->file_path)
                            <img src="{{ asset('storage/' . $report->file_path) }}" alt="Foto" width="100">
                        @else
                            Tidak ada foto
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>