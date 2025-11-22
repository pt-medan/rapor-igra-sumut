
import openpyxl

# Create a new workbook
wb = openpyxl.Workbook()

# Select the active sheet
ws = wb.active
ws.title = "Template Siswa"

# Add headers
headers = [
    "nama_lengkap",
    "nisn",
    "tempat_lahir",
    "tanggal_lahir",
    "jenis_kelamin",
    "alamat",
    "nama_kelompok_kelas"
]
ws.append(headers)

# Save the workbook
wb.save("/Users/macbook/Desktop/rapor_igra/public/templates/template_siswa.xlsx")
