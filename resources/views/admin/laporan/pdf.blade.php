<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Pegawai</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #2d3748;
            line-height: 1.6;
        }
        .header {
            padding: 20px;
            border-bottom: 2px solid #4299e1;
            margin-bottom: 30px;
        }
        .logo {
            width: 120px;
            float: left;
        }
        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #2b6cb0;
        }
        .info {
            margin: 20px 0;
            padding: 15px;
            background: #ebf8ff;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background: #4299e1;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        tr:nth-child(even) {
            background: #f7fafc;
        }
        .footer {
            margin-top: 30px;
            padding: 20px;
            border-top: 2px solid #4299e1;
            font-size: 12px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/logo.png') }}" class="logo">
        <div class="title">
            Laporan Data Pegawai<br>
            <span style="font-size: 16px">{{ date('d F Y') }}</span>
        </div>
    </div>

    <div class="info">
        <strong>Filter:</strong><br>
        Unit: {{ $request->unit_id ? $units->find($request->unit_id)->name : 'Semua Unit' }}<br>
        Status: {{ $request->status ?: 'Semua Status' }}<br>
        Hubungan Kerja: {{ $request->hubungan_kerja ?: 'Semua Hubungan Kerja' }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Unit</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Hubungan Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawais as $index => $pegawai)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pegawai->biodata->nip }}</td>
                <td>{{ $pegawai->biodata->nama_pegawai }}</td>
                <td>{{ $pegawai->unit->name }}</td>
                <td>{{ $pegawai->jabatan }}</td>
                <td>{{ $pegawai->status }}</td>
                <td>{{ $pegawai->hubungan_kerja }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <p>Laporan ini dibuat secara otomatis oleh sistem</p>
    </div>
</body>
</html>