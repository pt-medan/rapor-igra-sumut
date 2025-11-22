# Fitur Filter Kelas Tanpa Guru pada Halaman Registrasi

## Overview
Sistem registrasi guru telah diimplementasikan dengan fitur filter kelas otomatis untuk mencegah 2 guru mendaftar untuk kelas yang sama di sekolah yang sama.

## Cara Kerja

### 1. Struktur Database
- **Tabel**: `kelompok_kelas`
- **Column**: `guru_id` (nullable, unique)
- Setiap kelas dapat dimiliki oleh maksimal 1 guru (enforced by database UNIQUE constraint)

### 2. API Endpoint
**Route**: `/api/sekolah/{sekolah}/kelas`
**Controller**: `App\Http\Controllers\Api\KelompokKelasController@getBySekolah`

**Query Filter**:
```php
KelompokKelas::where('sekolah_id', $sekolah->id)
    ->whereNull('guru_id')
    ->get();
```

### 3. Halaman Registrasi (`resources/views/auth/register.blade.php`)

#### Flow:
1. Guru memilih sekolah dari dropdown (existing school)
2. JavaScript mengeksekusi `fetchKelas(sekolahId)` 
3. Frontend melakukan AJAX call ke `/api/sekolah/{id}/kelas`
4. API mengembalikan hanya kelas-kelas dengan `guru_id = NULL`
5. Dropdown kelas hanya menampilkan kelas-kelas yang belum memiliki guru
6. Guru dapat memilih kelas yang tersedia atau membuat kelas baru

#### Kode JavaScript (register.blade.php):
```javascript
async function fetchKelas(sekolahId) {
    kelasChoices.clearStore();
    
    if (!sekolahId) {
        kelasSelect.innerHTML = '<option value="">-- Pilih Sekolah Terlebih Dahulu --</option>';
        kelasChoices.init();
        return;
    }

    try {
        const response = await fetch(`/api/sekolah/${sekolahId}/kelas`);
        const data = await response.json();
        
        const choices = [];
        data.forEach(kelas => {
            choices.push({
                value: kelas.id,
                label: kelas.nama_kelompok,
            });
        });
        choices.push({
            value: 'new_class',
            label: '** Buat Kelas Baru **',
        });

        kelasChoices.setChoices(choices, 'value', 'label', false);

    } catch (error) {
        console.error('Error fetching kelas:', error);
        kelasSelect.innerHTML = '<option value="">Gagal memuat kelas</option>';
    }
}
```

## Data Contoh

### Database Status (Nov 22, 2025)
- **Total Guru**: 976
- **Total Kelas**: 936
- **Kelas dengan Guru** (guru_id filled): 911
- **Kelas Tanpa Guru** (guru_id NULL): 25

### Contoh untuk Sekolah ID 1 (RA Raudhah)
```
Kelas tanpa guru yang tersedia:
- ID 3: Kelas Test 3

Kelas yang sudah dimiliki guru (tidak ditampilkan):
- ID 1: Kelas Test (guru_id: 1123)
- ID 2: Kelas Test 2 (guru_id: 3)
```

## Validasi pada Registrasi

Saat guru mendaftar dengan sekolah existing, sistem memvalidasi:
1. Sekolah dipilih ✓
2. Kelas dipilih atau kelas baru dibuat ✓
3. Jika memilih kelas existing → kelas tidak akan memiliki guru lain ✓
4. Database UNIQUE constraint pada guru_id akan mencegah duplikat di database level ✓

## Cara Menggunakan

### Skenario 1: Guru Memilih Sekolah Existing + Kelas Existing
1. Buka halaman `/register`
2. Isi data pribadi (nama, email, password)
3. Uncheck "Daftarkan Sekolah Baru"
4. Pilih sekolah dari dropdown
5. Pilih kelas dari dropdown (hanya kelas tanpa guru yang ditampilkan)
6. Klik "Daftar"

### Skenario 2: Guru Memilih Sekolah Existing + Buat Kelas Baru
1. Buka halaman `/register`
2. Isi data pribadi (nama, email, password)
3. Uncheck "Daftarkan Sekolah Baru"
4. Pilih sekolah dari dropdown
5. Pilih "** Buat Kelas Baru **" dari dropdown kelas
6. Isi nama kelas baru
7. Klik "Daftar"

### Skenario 3: Guru Daftarkan Sekolah Baru
1. Buka halaman `/register`
2. Isi data pribadi (nama, email, password)
3. Check "Daftarkan Sekolah Baru"
4. Isi data sekolah baru
5. Dropdown kelas akan otomatis menampilkan "** Buat Kelas Baru **" saja
6. Isi nama kelas baru
7. Klik "Daftar"

## Keuntungan Sistem Ini

1. **Data Integrity**: Database UNIQUE constraint mencegah duplikat di level database
2. **User Experience**: Frontend filter menampilkan hanya opsi yang valid
3. **Real-time Data**: API selalu mengambil data terbaru dari database
4. **Scalable**: Sistem dapat menangani ribuan sekolah dan kelas
5. **Fallback**: Jika duplikat terjadi (edge case), database akan reject dengan error unique constraint

## Troubleshooting

### Dropdown kelas kosong setelah memilih sekolah
**Kemungkinan penyebab:**
1. Semua kelas di sekolah itu sudah memiliki guru
2. Sekolah tidak memiliki kelas sama sekali

**Solusi:**
- Guru dapat membuat kelas baru dengan memilih "** Buat Kelas Baru **"
- Atau memilih sekolah lain yang masih memiliki kelas tanpa guru

### Error saat fetch kelas
**Kemungkinan penyebab:**
1. Network error
2. Sekolah ID tidak valid
3. Server error

**Solusi:**
- Refresh halaman
- Check browser console untuk error details
- Hubungi administrator jika error persisten

## Testing API secara Manual

### Via curl
```bash
curl -X GET "http://localhost:8000/api/sekolah/1/kelas" \
  -H "Accept: application/json"
```

### Via PHP (Tinker)
```php
App\Models\KelompokKelas::where('sekolah_id', 1)
    ->whereNull('guru_id')
    ->get();
```

## Perubahan Sistem di Masa Depan

Jika diperlukan untuk mengubah logika filter, ubah di:
1. **Backend**: `/app/Http/Controllers/Api/KelompokKelasController.php` - method `getBySekolah()`
2. **Frontend**: `/resources/views/auth/register.blade.php` - function `fetchKelas()`

## Dokumentasi Terkait

- [Registrasi Guru](./GURU_REGISTRATION.md)
- [API Documentation](./API.md)
- [Database Schema](./DATABASE_SCHEMA.md)

---

**Last Updated**: November 22, 2025
**Status**: ✅ Production Ready
