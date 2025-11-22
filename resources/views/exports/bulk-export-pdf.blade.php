<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Export Data Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 20px;
            font-size: 11px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        
        .header p {
            margin: 3px 0;
            font-size: 10px;
        }
        
        .export-info {
            margin-bottom: 15px;
            font-size: 9px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead {
            background-color: #f0f0f0;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
        }
        
        th {
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            border-right: 1px solid #ddd;
        }
        
        th:last-child {
            border-right: none;
        }
        
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        
        tbody tr:hover {
            background-color: #f0f0f0;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 9px;
            color: #666;
            text-align: right;
        }
        
        .summary {
            margin-top: 10px;
            font-weight: bold;
            font-size: 10px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN DATA SISWA</h1>
        @if($sekolah)
            <p><strong>{{ $sekolah->nama_sekolah }}</strong></p>
            <p>{{ $sekolah->alamat ?? '' }}</p>
        @endif
        <p>Tahun Akademik {{ now()->year }}/{{ now()->year + 1 }}</p>
    </div>

    <!-- Export Info -->
    <div class="export-info">
        <p><strong>Tanggal Export:</strong> {{ $exportDate }}</p>
        <p><strong>Total Data:</strong> {{ $penilaians->count() }} siswa</p>
    </div>

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 15%;">NISN</th>
                <th style="width: 30%;">Nama Siswa</th>
                <th style="width: 15%;">Kelas</th>
                <th style="width: 15%;">Tahun Ajaran</th>
                <th style="width: 10%;">Semester</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penilaians as $index => $penilaian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penilaian->siswa->nisn ?? '-' }}</td>
                    <td>{{ $penilaian->siswa->nama_lengkap }}</td>
                    <td>{{ $penilaian->siswa->kelompokKelas?->nama_kelas ?? '-' }}</td>
                    <td>{{ $penilaian->tahun_ajaran }}</td>
                    <td>{{ $penilaian->semester === '1' ? 'Ganjil' : 'Genap' }}</td>
                    <td>
                        <span class="status-completed">Dinilai</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <p>Total Siswa Dinilai: {{ $penilaians->count() }}</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem rapor digital</p>
        <p>© {{ now()->year }} - All Rights Reserved</p>
    </div>
</body>
</html>
