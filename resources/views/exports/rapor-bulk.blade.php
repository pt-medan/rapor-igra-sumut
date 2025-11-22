<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kumpulan Rapor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            -webkit-print-color-adjust: exact; /* Chrome, Safari */
            color-adjust: exact; /* Firefox */
        }
        .rapor-table td, .rapor-table th {
            border: 1px solid #e5e7eb;
            padding: 8px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body class="font-sans">
    @foreach ($penilaians as $penilaian)
        @include('guru.penilaian._rapor-content', ['penilaian' => $penilaian])
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
