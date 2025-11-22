
<style>
    body {
        font-family: 'Arial', sans-serif;
        font-size: 12px;
        line-height: 1.4;
        color: #333;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 100%;
        margin: 0 auto;
        border: 1px solid #ccc;
        padding: 25px;
        box-sizing: border-box;
    }
    .header {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
    }
    .header h1 {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
        text-transform: uppercase;
    }
    .header h2 {
        font-size: 16px;
        font-weight: normal;
        margin: 5px 0;
        text-transform: uppercase;
    }
    .student-info {
        margin-bottom: 20px;
        width: 100%;
    }
    .student-info table {
        width: 100%;
        border-collapse: collapse;
    }
    .student-info td {
        padding: 4px 0;
        vertical-align: top;
    }
    .student-info .label {
        width: 120px;
    }
    .student-info .separator {
        width: 15px;
        text-align: center;
    }
    .section-title {
        font-size: 14px;
        font-weight: bold;
        background-color: #f2f2f2;
        padding: 8px;
        margin-top: 20px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
    }
    .rapor-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .rapor-table th, .rapor-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
        vertical-align: top;
    }
    .rapor-table th {
        background-color: #e9e9e9;
        font-weight: bold;
        text-align: center;
    }
    .rapor-table .aspect-col {
        width: 30%;
        font-weight: bold;
    }
    .signature-section {
        margin-top: 40px;
        width: 100%;
    }
    .signature-section table {
        width: 100%;
        text-align: center;
    }
    .signature-section .signature-box {
        width: 50%;
    }
    .signature-section .placeholder {
        height: 70px;
    }
    .signature-section .name {
        font-weight: bold;
        text-decoration: underline;
    }
</style>

<div class="container">

    <div class="header">
        <h1>LAPORAN PERKEMBANGAN ANAK</h1>
        <h2>{{ $penilaian->siswa->sekolah->nama_sekolah }}</h2>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td class="label">Nama Siswa</td>
                <td class="separator">:</td>
                <td>{{ $penilaian->siswa->nama_lengkap }}</td>
                <td class="label" style="padding-left: 30px;">Tahun Ajaran</td>
                <td class="separator">:</td>
                <td>{{ $penilaian->tahun_ajaran }}</td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td class="separator">:</td>
                <td>{{ $penilaian->siswa->nisn ?? '-' }}</td>
                <td class="label" style="padding-left: 30px;">Semester</td>
                <td class="separator">:</td>
                <td>{{ $penilaian->semester }}</td>
            </tr>
             <tr>
                <td class="label">Kelas</td>
                <td class="separator">:</td>
                <td>{{ $penilaian->siswa->kelompokKelas->nama_kelompok }}</td>
                <td class="label" style="padding-left: 30px;"></td>
                <td class="separator"></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="section-title">A. PERKEMBANGAN NILAI AGAMA DAN BUDI PEKERTI</div>
    <table class="rapor-table">
        <thead>
            <tr>
                <th>Aspek Perkembangan</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="aspect-col">1. Agama dan Budi Pekerti</td>
                <td>{{ $penilaian->agama_budi_pekerti }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">B. PERKEMBANGAN JATI DIRI</div>
     <table class="rapor-table">
        <thead>
            <tr>
                <th>Aspek Perkembangan</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="aspect-col">2. Jati Diri</td>
                <td>{{ $penilaian->jati_diri }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">C. PERKEMBANGAN DASAR-DASAR LITERASI, MATEMATIKA, SAINS, TEKNOLOGI, REKAYASA, DAN SENI</div>
     <table class="rapor-table">
         <thead>
            <tr>
                <th>Aspek Perkembangan</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="aspect-col">3. Literasi dan STEAM</td>
                <td>{{ $penilaian->literasi_sains }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">D. KEHADIRAN</div>
    <table class="rapor-table">
        <tbody>
            <tr>
                <td style="width: 30%; font-weight: bold;">Sakit</td>
                <td style="width: 70%;">{{ $penilaian->sakit ?? 0 }} hari</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Izin</td>
                <td>{{ $penilaian->izin ?? 0 }} hari</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tanpa Keterangan</td>
                <td>{{ $penilaian->alpha ?? 0 }} hari</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">E. CATATAN GURU</div>
    <table class="rapor-table">
        <tbody>
            <tr>
                <td style="width: 30%; font-weight: bold;">Catatan Kesehatan</td>
                <td style="width: 70%;">{{ $penilaian->catatan_kesehatan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Catatan Guru</td>
                <td>{{ $penilaian->catatan_guru ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    @if($penilaian->ekstrakurikuler && count($penilaian->ekstrakurikuler) > 0)
        <div class="section-title">F. EKSTRAKURIKULER</div>
        <table class="rapor-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Nama Kegiatan</th>
                    <th style="width: 50%;">Predikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penilaian->ekstrakurikuler as $ekstra)
                    <tr>
                        <td>{{ $ekstra['nama'] ?? '-' }}</td>
                        <td>{{ $ekstra['predikat'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="signature-section">
        <table>
            <tr>
                <td class="signature-box">
                    <p>Mengetahui,</p>
                    <p>Kepala Sekolah</p>
                    <div class="placeholder"></div>
                    <p class="name">{{ $penilaian->siswa->sekolah->kepala_sekolah }}</p>
                </td>
                <td class="signature-box">
                    <p>Wali Kelas,</p>
                    <br>
                    <div class="placeholder"></div>
                    <p class="name">{{ $penilaian->siswa->kelompokKelas->waliKelas->user->name ?? '' }}</p>
                </td>
            </tr>
        </table>
    </div>

</div>
