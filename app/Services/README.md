# Services Directory

## 📁 Apa itu Services?

Services adalah layer yang berisi **business logic** aplikasi. Services memisahkan business logic dari Controllers, membuat kode lebih:
- ✅ Clean & organized
- ✅ Reusable
- ✅ Testable
- ✅ Maintainable

## 📚 Available Services

### 1. GuruService
**File:** `GuruService.php`
**Tanggung Jawab:** Manage guru dan user account

**Key Methods:**
- `getAllGurus()` - Get all teachers
- `createGuru($data)` - Create teacher with user account
- `updateGuru($guru, $data)` - Update teacher
- `deleteGuru($guru)` - Delete teacher and user
- `findGuruByNip($nip)` - Find by NIP

---

### 2. SiswaService
**File:** `SiswaService.php`
**Tanggung Jawab:** Manage siswa dan foto

**Key Methods:**
- `getAllSiswas()` - Get all students
- `createSiswa($data)` - Create student (auto handle photo)
- `updateSiswa($siswa, $data)` - Update student
- `deleteSiswa($siswa)` - Delete student
- `findSiswaByNis($nis)` - Find by NIS
- `findSiswaByBarcodeOrNis($code)` - Find by barcode or NIS
- `getSiswasByKelas($kelas)` - Get by grade level

---

### 3. MataPelajaranService
**File:** `MataPelajaranService.php`
**Tanggung Jawab:** Manage mata pelajaran

**Key Methods:**
- `getAllMataPelajarans()` - Get all subjects
- `createMataPelajaran($data)` - Create subject
- `updateMataPelajaran($mapel, $data)` - Update subject
- `deleteMataPelajaran($mapel)` - Delete subject
- `findMataPelajaranByKode($kode)` - Find by code

---

### 4. KelasService
**File:** `KelasService.php`
**Tanggung Jawab:** Manage kelas dan siswa

**Key Methods:**
- `getKelasByGuru($guru)` - Get classes by teacher
- `createKelas($data, $guru)` - Create class
- `updateKelas($kelas, $data)` - Update class
- `deleteKelas($kelas)` - Delete class
- `toggleActiveStatus($kelas)` - Toggle active/inactive
- `syncSiswas($kelas, $siswaIds)` - Sync students to class
- `isKelasOwnedByGuru($kelas, $guru)` - Check ownership
- `isKelasActive($kelas)` - Check if active

---

### 5. AbsensiService ⭐
**File:** `AbsensiService.php`
**Tanggung Jawab:** Core business logic untuk absensi

**Key Methods:**
- `processScan($kelas, $barcodeOrNis)` - ⭐ Main method - Process attendance scan
- `checkTodayAttendance($kelas, $siswa)` - Check if already attended
- `createAbsensi($kelas, $siswa)` - Create attendance record
- `getAbsensiByKelas($kelas, $perPage)` - Get attendance history
- `getAbsensiByDateRange($kelas, $start, $end)` - Get by date range
- `getStatistics($absensis)` - Calculate statistics
- `getReportPerSiswa($kelas, $absensis)` - Generate per-student report
- `getAbsensiBySiswa($siswa, $days)` - Get student attendance history

**Business Rules:**
- Scan before 07:30 → Status "hadir"
- Scan after 07:30 → Status "terlambat"
- One attendance per day per class

---

### 6. LaporanService
**File:** `LaporanService.php`
**Tanggung Jawab:** Generate laporan dan export

**Key Methods:**
- `generateReport($kelas, $start, $end)` - Generate full report
- `generateCsvData($kelas, $start, $end)` - Generate CSV data
- `streamCsv($kelas, $start, $end)` - Stream CSV for download

---

## 🎯 How to Use

### 1. Inject Service in Controller

```php
use App\Services\SiswaService;

class SiswaController extends Controller
{
    protected $siswaService;

    public function __construct(SiswaService $siswaService)
    {
        $this->siswaService = $siswaService;
    }
}
```

### 2. Call Service Methods

```php
// Get all
$siswas = $this->siswaService->getAllSiswas();

// Create
$siswa = $this->siswaService->createSiswa($data);

// Update
$siswa = $this->siswaService->updateSiswa($siswa, $data);

// Delete
$this->siswaService->deleteSiswa($siswa);

// Find
$siswa = $this->siswaService->findSiswaByNis('01223');
```

---

## 🔗 Service Dependencies

```
GuruService          → Independent
SiswaService         → Independent
MataPelajaranService → Independent
KelasService         → Independent
AbsensiService       → Depends on: SiswaService
LaporanService       → Depends on: AbsensiService
```

---

## ✅ Best Practices

### DO ✅
- Inject services via constructor
- Return data (arrays, objects, collections)
- Use database transactions for multiple operations
- Keep services focused (single responsibility)
- Add docblocks to methods

### DON'T ❌
- Don't put validation in services (keep in controller)
- Don't return HTTP responses (redirect, json, view)
- Don't access request directly
- Don't make services too large

---

## 📖 Full Documentation

Untuk dokumentasi lengkap, lihat:
- **SERVICE_LAYER_INDEX.md** - Index & navigation
- **SERVICE_LAYER_SUMMARY.md** - Quick summary
- **SERVICE_LAYER_DOCUMENTATION.md** - Full documentation
- **SERVICE_LAYER_DIAGRAM.md** - Visual diagrams
- **SERVICE_QUICK_REFERENCE.md** - Quick reference & cheat sheet

---

## 🎓 Example: Process Scan

### Controller (Light)
```php
public function processScan(Request $request, Kelas $kela)
{
    // 1. Validate
    $validated = $request->validate([
        'barcode' => 'required|string',
    ]);

    // 2. Business logic (in service)
    $result = $this->absensiService->processScan($kela, $validated['barcode']);

    // 3. Return response
    return response()->json($result);
}
```

### Service (Business Logic)
```php
public function processScan(Kelas $kelas, string $barcodeOrNis)
{
    // 1. Find student
    $siswa = $this->siswaService->findSiswaByBarcodeOrNis($barcodeOrNis);
    if (!$siswa) {
        return ['success' => false, 'message' => 'Siswa tidak ditemukan'];
    }

    // 2. Check enrollment
    if (!$kelas->siswas->contains($siswa->id)) {
        return ['success' => false, 'message' => 'Siswa tidak terdaftar'];
    }

    // 3. Check duplicate
    if ($this->checkTodayAttendance($kelas, $siswa)) {
        return ['success' => false, 'message' => 'Sudah absen'];
    }

    // 4. Create attendance
    $absensi = $this->createAbsensi($kelas, $siswa);

    // 5. Return success
    return [
        'success' => true,
        'message' => 'Absensi berhasil',
        'data' => [...]
    ];
}
```

---

## 🚀 Benefits

**Before Service Layer:**
- ❌ Controllers 95-120 lines (heavy)
- ❌ Business logic mixed with HTTP handling
- ❌ Hard to test
- ❌ Code duplication

**After Service Layer:**
- ✅ Controllers 60-70 lines (30-45% lighter!)
- ✅ Business logic centralized
- ✅ Easy to test
- ✅ Code reusable

---

## 📊 Statistics

| Service | Lines | Methods | Dependencies |
|---------|-------|---------|--------------|
| GuruService | ~90 | 6 | None |
| SiswaService | ~110 | 8 | None |
| MataPelajaranService | ~60 | 5 | None |
| KelasService | ~90 | 8 | None |
| AbsensiService | ~180 | 8 | SiswaService |
| LaporanService | ~100 | 3 | AbsensiService |
| **TOTAL** | **~630** | **38** | - |

---

## 🎉 Summary

✅ **6 Services** with centralized business logic
✅ **38 Methods** ready to use
✅ **630 Lines** of clean, reusable code
✅ **Controllers 30-45% lighter**
✅ **Easy to test, maintain, and scale**

**Happy Coding! 🚀**
