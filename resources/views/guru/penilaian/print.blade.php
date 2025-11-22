<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor {{ $penilaian->siswa->nama_lengkap }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
            body {
                -webkit-print-color-adjust: exact; /* Chrome, Safari */
                color-adjust: exact; /* Firefox */
            }
        }
        .rapor-table td, .rapor-table th {
            border: 1px solid #e5e7eb;
            padding: 8px;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <div class="no-print my-8 text-center">
        <button onclick="window.print()" class="bg-blue-500 text-white py-2 px-6 rounded hover:bg-blue-600 transition">Cetak Rapor</button>
        <a href="{{ url()->previous() }}" class="ml-4 text-gray-600">Kembali</a>
    </div>

    @include('guru.penilaian._rapor-content', ['penilaian' => $penilaian])

</body>
</html>