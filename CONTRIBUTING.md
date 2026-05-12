# Contributing to Sistem Absensi Barcode SMA

Terima kasih atas minat Anda untuk berkontribusi! 🎉

## 📋 Daftar Isi

- [Code of Conduct](#code-of-conduct)
- [Cara Berkontribusi](#cara-berkontribusi)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Pull Request Process](#pull-request-process)
- [Reporting Bugs](#reporting-bugs)
- [Suggesting Features](#suggesting-features)

---

## Code of Conduct

Proyek ini mengikuti kode etik yang ramah dan inklusif. Dengan berpartisipasi, Anda diharapkan untuk:

- Menggunakan bahasa yang ramah dan inklusif
- Menghormati sudut pandang dan pengalaman yang berbeda
- Menerima kritik konstruktif dengan baik
- Fokus pada apa yang terbaik untuk komunitas
- Menunjukkan empati terhadap anggota komunitas lainnya

---

## Cara Berkontribusi

Ada banyak cara untuk berkontribusi:

### 1. 🐛 Melaporkan Bug
- Gunakan GitHub Issues
- Jelaskan langkah-langkah untuk mereproduksi bug
- Sertakan screenshot jika memungkinkan
- Sebutkan versi PHP, Laravel, dan browser yang digunakan

### 2. 💡 Mengusulkan Fitur Baru
- Buka GitHub Issue dengan label "enhancement"
- Jelaskan fitur yang diusulkan dengan detail
- Jelaskan mengapa fitur ini berguna
- Berikan contoh use case jika memungkinkan

### 3. 📝 Memperbaiki Dokumentasi
- Perbaiki typo atau kesalahan
- Tambahkan contoh yang lebih jelas
- Terjemahkan dokumentasi ke bahasa lain
- Tambahkan tutorial atau panduan

### 4. 💻 Menulis Kode
- Perbaiki bug yang ada
- Implementasi fitur baru
- Tingkatkan performa
- Refactor kode

---

## Development Setup

### Prerequisites
```bash
- PHP >= 8.3
- Composer
- Node.js & NPM
- Git
- SQLite atau MySQL
```

### Setup Lokal

1. **Fork Repository**
```bash
# Fork di GitHub, lalu clone
git clone https://github.com/YOUR_USERNAME/sistem-absensi-barcode.git
cd sistem-absensi-barcode
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Setup**
```bash
# Edit .env untuk konfigurasi database
php artisan migrate --seed
```

5. **Build Assets**
```bash
npm run dev
```

6. **Run Server**
```bash
php artisan serve
```

---

## Coding Standards

### PHP/Laravel

#### PSR-12 Coding Standard
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index(): View
    {
        // Code here
    }
}
```

#### Naming Conventions
- **Classes**: PascalCase (`UserController`, `AbsensiModel`)
- **Methods**: camelCase (`getUserData`, `processAbsensi`)
- **Variables**: camelCase (`$userName`, `$totalAbsensi`)
- **Constants**: UPPER_SNAKE_CASE (`MAX_ATTEMPTS`, `DEFAULT_TIMEOUT`)

#### Best Practices
- Gunakan type hints untuk parameter dan return types
- Tulis docblocks untuk method yang kompleks
- Gunakan dependency injection
- Ikuti SOLID principles
- Tulis kode yang self-documenting

### Blade Templates

```blade
{{-- Good --}}
@if($user->isAdmin())
    <div class="admin-panel">
        {{ $user->name }}
    </div>
@endif

{{-- Avoid --}}
<?php if($user->isAdmin()): ?>
    <div class="admin-panel">
        <?php echo $user->name; ?>
    </div>
<?php endif; ?>
```

### JavaScript

```javascript
// Use modern ES6+ syntax
const processBarcode = async (barcode) => {
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify({ barcode })
        });
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
    }
};
```

### CSS

```css
/* Use BEM naming convention */
.card {}
.card__header {}
.card__body {}
.card--active {}

/* Avoid deep nesting */
/* Good */
.navbar { }
.navbar-menu { }
.navbar-item { }

/* Avoid */
.navbar .menu .item { }
```

---

## Pull Request Process

### 1. Create Branch
```bash
# Create feature branch
git checkout -b feature/nama-fitur

# Or bugfix branch
git checkout -b bugfix/nama-bug
```

### 2. Make Changes
- Tulis kode yang clean dan readable
- Ikuti coding standards
- Tambahkan comments jika diperlukan
- Update dokumentasi jika ada perubahan API

### 3. Test Your Changes
```bash
# Run tests
php artisan test

# Check code style
./vendor/bin/pint

# Test manually
php artisan serve
```

### 4. Commit Changes
```bash
# Use conventional commits
git commit -m "feat: add export to PDF feature"
git commit -m "fix: resolve barcode scanning issue"
git commit -m "docs: update installation guide"
```

**Commit Message Format:**
- `feat:` - Fitur baru
- `fix:` - Bug fix
- `docs:` - Perubahan dokumentasi
- `style:` - Formatting, missing semicolons, etc
- `refactor:` - Refactoring kode
- `test:` - Menambah atau memperbaiki tests
- `chore:` - Maintenance tasks

### 5. Push & Create PR
```bash
# Push to your fork
git push origin feature/nama-fitur

# Create Pull Request di GitHub
```

### 6. PR Checklist
- [ ] Kode mengikuti coding standards
- [ ] Semua tests passing
- [ ] Dokumentasi sudah diupdate
- [ ] Commit messages jelas dan deskriptif
- [ ] No merge conflicts
- [ ] PR description menjelaskan perubahan

---

## Reporting Bugs

### Bug Report Template

```markdown
**Describe the bug**
A clear and concise description of what the bug is.

**To Reproduce**
Steps to reproduce the behavior:
1. Go to '...'
2. Click on '....'
3. Scroll down to '....'
4. See error

**Expected behavior**
A clear and concise description of what you expected to happen.

**Screenshots**
If applicable, add screenshots to help explain your problem.

**Environment:**
 - OS: [e.g. Windows 11]
 - Browser: [e.g. Chrome 120]
 - PHP Version: [e.g. 8.3.0]
 - Laravel Version: [e.g. 13.0]

**Additional context**
Add any other context about the problem here.
```

---

## Suggesting Features

### Feature Request Template

```markdown
**Is your feature request related to a problem?**
A clear and concise description of what the problem is.

**Describe the solution you'd like**
A clear and concise description of what you want to happen.

**Describe alternatives you've considered**
A clear and concise description of any alternative solutions.

**Additional context**
Add any other context or screenshots about the feature request.

**Use Cases**
Describe specific scenarios where this feature would be useful.
```

---

## Testing Guidelines

### Writing Tests

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AbsensiTest extends TestCase
{
    public function test_guru_can_scan_barcode(): void
    {
        $guru = User::factory()->create(['role' => 'guru']);
        
        $response = $this->actingAs($guru)
            ->post('/guru/kelas/1/scan', [
                'barcode' => '01223'
            ]);
        
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }
}
```

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=AbsensiTest

# Run with coverage
php artisan test --coverage
```

---

## Code Review Process

### What We Look For

1. **Functionality**
   - Does it work as intended?
   - Are edge cases handled?
   - Is error handling proper?

2. **Code Quality**
   - Is the code readable?
   - Are naming conventions followed?
   - Is it well-structured?

3. **Performance**
   - Are there any performance issues?
   - Are queries optimized?
   - Is caching used appropriately?

4. **Security**
   - Are inputs validated?
   - Is authentication/authorization proper?
   - Are there any security vulnerabilities?

5. **Documentation**
   - Is the code self-documenting?
   - Are complex parts commented?
   - Is documentation updated?

---

## Getting Help

Jika Anda membutuhkan bantuan:

1. **Baca Dokumentasi**
   - [README.md](README.md)
   - [QUICK_START.md](QUICK_START.md)
   - [DOKUMENTASI_SISTEM.md](DOKUMENTASI_SISTEM.md)

2. **Search Issues**
   - Cek apakah pertanyaan sudah pernah dijawab

3. **Ask Questions**
   - Buka GitHub Discussion
   - Atau buat Issue dengan label "question"

---

## Recognition

Contributors akan diakui di:
- README.md
- CHANGELOG.md
- GitHub Contributors page

---

## License

Dengan berkontribusi, Anda setuju bahwa kontribusi Anda akan dilisensikan di bawah MIT License yang sama dengan proyek ini.

---

**Terima kasih atas kontribusi Anda! 🙏**

Setiap kontribusi, sekecil apapun, sangat berarti untuk proyek ini.
