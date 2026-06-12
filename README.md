# Lab7Web.

# Laporan Praktikum Pemrograman Web 2
## Praktikum 1: PHP Framework (CodeIgniter 4)

*Nama: Amelia Nurmala Dewi*

*Kelas: I241B*

*NIM: 312410199*

---

## Langkah-Langkah Praktikum

### Persiapan - Konfigurasi PHP dan Instalasi CodeIgniter 4

Sebelum memulai, dilakukan konfigurasi pada webserver XAMPP dengan mengaktifkan beberapa ekstensi PHP yang dibutuhkan oleh CodeIgniter 4, yaitu:
- **php-json** → untuk bekerja dengan JSON
- **php-mysqlnd** → native driver untuk MySQL
- **php-xml** → untuk bekerja dengan XML
- **php-intl** → untuk membuat aplikasi multibahasa
- **libcurl** → opsional, untuk penggunaan Curl

Untuk mengaktifkan ekstensi tersebut, buka **XAMPP Control Panel → Apache → Config → PHP.ini**, kemudian hilangkan tanda titik koma (`;`) di depan ekstensi yang akan diaktifkan, lalu simpan dan restart Apache.

Setelah konfigurasi selesai, CodeIgniter 4 diinstal secara manual dengan cara:
1. Unduh CodeIgniter dari https://codeigniter.com/download
2. Ekstrak file zip ke direktori `htdocs/lab11_ci`
3. Ubah nama folder hasil ekstrak menjadi `ci4`
4. Buka browser dan akses `http://localhost/lab11_ci/ci4/public/`

---

### 1. Instalasi Berhasil, Halaman Welcome CodeIgniter 4 Tampil

<img width="1366" height="768" alt="Screenshot (1751)" src="https://github.com/user-attachments/assets/7eb3a7a9-ae0e-405e-8bcf-e1dd1bf4ad0b" />

Setelah instalasi selesai dan Apache dijalankan, browser diarahkan ke `http://localhost/lab11_ci/ci4/public/`. Halaman default CodeIgniter 4 berhasil tampil dengan judul **"Welcome to CodeIgniter 4.7.0"** beserta keterangan bahwa:
- View utama berada di `app/Views/welcome_message.php`
- Controller utama berada di `app/Controllers/Home.php`

Tampilnya halaman ini membuktikan bahwa instalasi CodeIgniter 4 telah berhasil dilakukan.

---

### 2. Menjalankan CLI (Command Line Interface)

<img width="1366" height="768" alt="Screenshot (1755)" src="https://github.com/user-attachments/assets/7ce01d22-957e-4363-a654-1929981fbccf" />

CodeIgniter 4 menyediakan tools CLI bernama **Spark** untuk mempermudah proses development. Untuk mengaksesnya, buka terminal XAMPP Shell dan arahkan ke direktori project:

```bash
cd htdocs\lab11_ci\ci4
php spark
```

Output yang muncul menampilkan daftar perintah yang tersedia, dikelompokkan berdasarkan kategori seperti **Cache**, **Generators** (make:controller, make:model, dll.), **Database**, **Housekeeping**, dan lain-lain. Perintah-perintah ini sangat berguna untuk mempercepat proses pengembangan aplikasi.

---

### 3. Mengaktifkan Mode Debugging (Muncul Error Whoops!)

<img width="1365" height="714" alt="Screenshot 2026-03-01 061016" src="https://github.com/user-attachments/assets/c520912c-3501-4a16-b79e-8c7c509873c4" />

Secara default, mode debugging pada CodeIgniter 4 belum aktif. Ketika terjadi error pada aplikasi, yang tampil hanyalah halaman **"Whoops! We seem to have hit a snag. Please try again later..."** tanpa informasi detail tentang error yang terjadi.

Untuk mengaktifkan mode debugging, ubah nama file `env` menjadi `.env` di root direktori project, kemudian buka file tersebut dan ubah nilai variabel berikut:

```
CI_ENVIRONMENT = development
```

Dengan mengaktifkan mode development, detail error akan ditampilkan secara lengkap sehingga memudahkan proses debugging.

---

### 4. ParseError Terdeteksi Setelah Mode Debugging Aktif

<img width="1365" height="719" alt="Screenshot 2026-03-01 062120" src="https://github.com/user-attachments/assets/3511cf87-a4b8-4d03-aec9-265830fa67e1" />

Setelah mode development diaktifkan, detail error mulai terlihat. Error yang muncul adalah:

```
ParseError
syntax error, unexpected token "}", expecting ";"
APPPATH\Controllers\Home.php at line 10
```

Error ini terjadi karena pada baris 9 file `app/Controllers/Home.php`, statement `return view('welcome_message')` tidak diakhiri dengan tanda titik koma (`;`). Kode yang salah:

```php
public function index()
{
    return view('welcome_message')  // ← Kurang titik koma!
}
```

Perbaikan dilakukan dengan menambahkan `;` di akhir baris tersebut:

```php
public function index()
{
    return view('welcome_message');  // ← Sudah benar
}
```

---

### 5. Membuat Route Baru dan Mengecek dengan Spark Routes

<img width="1365" height="718" alt="Screenshot 2026-03-01 064700" src="https://github.com/user-attachments/assets/c33d3112-4a60-43b3-bb76-0dd46b80c99a" />

Setelah error diperbaiki, langkah selanjutnya adalah menambahkan route baru untuk setiap halaman pada file `app/Config/Routes.php`:

```php
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
```

Untuk memastikan route sudah terdaftar dengan benar, dijalankan perintah berikut di CLI:

```bash
php spark routes
```

Output menampilkan tabel daftar route yang sudah terdaftar:

| Method | Route   | Handler                          |
|--------|---------|----------------------------------|
| GET    | /       | \App\Controllers\Home::index     |
| GET    | about   | \App\Controllers\Page::about     |
| GET    | contact | \App\Controllers\Page::contact   |
| GET    | faqs    | \App\Controllers\Page::faqs      |

Semua route berhasil terdaftar dengan benar.

---

### 6. Error 404 Karena Controller Page Belum Dibuat

<img width="1365" height="718" alt="Screenshot 2026-03-01 065150" src="https://github.com/user-attachments/assets/434db20c-e863-4e42-aafd-232992e4efca" />

Ketika mencoba mengakses `http://localhost/lab11_ci/ci4/public/about`, muncul error **404 - Page Not Found** dengan pesan:

```
Controller or its method is not found: \App\Controllers\Page::about
```

Error ini terjadi karena meskipun route sudah didefinisikan, file **Controller Page** (`app/Controllers/Page.php`) belum dibuat. Route sudah mengarah ke controller yang belum ada, sehingga CodeIgniter mengembalikan error 404.

---

### 7. Membuat Controller Page

<img width="1365" height="716" alt="Screenshot 2026-03-01 065452" src="https://github.com/user-attachments/assets/b85090c9-721d-4f7d-ae9d-d40eeceb247d" />

Untuk mengatasi error 404, dibuat file baru `app/Controllers/Page.php` dengan isi sebagai berikut:

```php
<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        echo "Ini halaman About";
    }

    public function contact()
    {
        echo "Ini halaman Contact";
    }

    public function faqs()
    {
        echo "Ini halaman FAQ";
    }
}
```

Setelah controller dibuat dan browser di-refresh, halaman about berhasil diakses dan menampilkan teks **"Ini halaman About"**. Ini membuktikan bahwa routing dan controller sudah terhubung dengan benar.

---

### 8. Auto Routing (Halaman Term of Services)

<img width="1365" height="719" alt="Screenshot 2026-03-01 070504" src="https://github.com/user-attachments/assets/8a274a9c-bfff-4c7a-b3d1-4e0fbba813b8" />

CodeIgniter 4 memiliki fitur **Auto Routing** yang secara default sudah aktif. Fitur ini memungkinkan method pada controller diakses tanpa perlu mendefinisikan route secara manual di `Routes.php`.

Ditambahkan method baru pada Controller Page:

```php
public function tos()
{
    echo "ini halaman Term of Services";
}
```

Method `tos()` ini belum didaftarkan di `Routes.php`, namun tetap dapat diakses melalui URL: `http://localhost/lab11_ci/ci4/public/page/tos`

Halaman berhasil tampil dengan teks **"ini halaman Term of Services"**, membuktikan fitur auto routing berfungsi dengan baik.

---

### 9. Membuat View untuk Halaman About

<img width="1365" height="718" alt="Screenshot 2026-03-01 071152" src="https://github.com/user-attachments/assets/edb87118-112f-43ea-a603-f41968610ee0" />

Untuk membuat tampilan yang lebih baik, dibuat file view baru di `app/Views/about.php`:

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
</head>
<body>
    <h1><?= $title; ?></h1>
    <hr>
    <p><?= $content; ?></p>
</body>
</html>
```

Kemudian method `about()` pada Controller Page diubah untuk memanggil view tersebut:

```php
public function about()
{
    return view('about', [
        'title'   => 'Halaman Abot',
        'content' => 'Ini adalah halaman abaut yang menjelaskan tentang isi halaman ini.'
    ]);
}
```

Setelah di-refresh, halaman about menampilkan judul **"Halaman Abot"** dengan garis pemisah dan paragraf deskripsi di bawahnya.

---

### 10. Membuat Layout dengan Template Header dan Footer

<img width="1365" height="714" alt="Screenshot 2026-03-01 074404" src="https://github.com/user-attachments/assets/bc8b61a1-4263-4ad7-b7d8-66d9aaef79a9" />

Untuk membuat tampilan yang konsisten di semua halaman, dibuat folder `template` di dalam `app/Views/`, kemudian dibuat dua file template:

**File `app/Views/template/header.php`:**
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Layout Sederhana</h1>
        </header>
        <nav>
            <a href="<?= base_url('/');?>" class="active">Home</a>
            <a href="<?= base_url('/artikel');?>">Artikel</a>
            <a href="<?= base_url('/about');?>">About</a>
            <a href="<?= base_url('/contact');?>">Kontak</a>
        </nav>
        <section id="wrapper">
            <section id="main">
```

**File `app/Views/template/footer.php`:**
```php
            </section>
            <aside id="sidebar">
                <div class="widget-box">
                    <h3 class="title">Widget Header</h3>
                    <ul>
                        <li><a href="#">Widget Link</a></li>
                        <li><a href="#">Widget Link</a></li>
                    </ul>
                </div>
                <div class="widget-box">
                    <h3 class="title">Widget Text</h3>
                    <p>Vestibulum lorem elit, iaculis in nisl volutpat, malesuada
                    tincidunt arcu. Proin in leo fringilla, vestibulum mi porta,
                    faucibus felis. Integer pharetra est nunc, nec pretium nunc pretium ac.</p>
                </div>
            </aside>
        </section>
        <footer>
            <p>&copy; 2021 - Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>
</html>
```

**File `app/Views/about.php` diubah menjadi:**
```php
<?= $this->include('template/header'); ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->include('template/footer'); ?>
```

Hasilnya halaman about kini memiliki struktur layout lengkap dengan header, navbar, sidebar, dan footer.

---

### 11. Tampilan Final dengan CSS Styling

<img width="1365" height="717" alt="Screenshot 2026-03-01 080932" src="https://github.com/user-attachments/assets/8e9867dc-33bb-4427-a9b9-13a6cc5ea91b" />
<img width="1365" height="719" alt="Screenshot 2026-03-01 080909" src="https://github.com/user-attachments/assets/d1dea048-1537-4c90-a33d-3bd905b618ad" />
<img width="1363" height="716" alt="Screenshot 2026-03-01 080948" src="https://github.com/user-attachments/assets/ec29d566-5d77-47a4-93f3-3d90fde05a06" />

File CSS disalin dari praktikum sebelumnya (lab4_layout) ke direktori `public/style.css`. Setelah CSS diterapkan, tampilan halaman menjadi lebih profesional dengan desain yang lengkap:

- **Header** → Judul "Layout Sederhana" dengan warna pink/magenta dan informasi nama mahasiswa
- **Navbar** → Menu navigasi horizontal dengan background hitam dan aksen magenta
- **Konten Utama** → Judul dan deskripsi halaman ditampilkan di area kiri
- **Sidebar Kanan** → Widget Header dengan Widget Link dan Widget Text berisi lorem ipsum
- **Footer** → Copyright "© 2021 - Universitas Pelita Bangsa" dengan background hitam

---

### Pertanyaan dan Tugas - Melengkapi Semua Menu Navigasi

Sebagai penyelesaian tugas dari modul, dilengkapi kode program untuk semua menu navigasi pada Controller Page agar semua halaman tampil dengan layout yang sama.

**File `app/Controllers/Page.php` (lengkap):**

```php
<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('about', [
            'title'   => 'Halaman Abot',
            'content' => 'Ini adalah halaman abaut yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title'   => 'Contact',
            'content' => 'Ini adalah halaman Contact.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title'   => 'FAQ',
            'content' => 'Ini adalah halaman FAQ.'
        ]);
    }

    public function tos()
    {
        return view('tos', [
            'title'   => 'Term of Services',
            'content' => 'Ini adalah halaman Term of Services.'
        ]);
    }
}
```

Setiap view (contact.php, faqs.php, tos.php) menggunakan template yang sama seperti about.php:

```php
<?= $this->include('template/header'); ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->include('template/footer'); ?>
```

Dengan demikian, semua halaman pada navigasi (Home, Artikel, About, Kontak) berhasil menampilkan tampilan dengan **layout yang seragam dan konsisten**.

---

# Praktikum 2 - Framework Lanjutan (CRUD)

## Langkah-Langkah Praktikum

### 12. Membuat Database

Membuat database dan tabel artikel pada MySQL.

```sql
CREATE DATABASE lab_ci4;

CREATE TABLE artikel (
    id INT(11) auto_increment,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200),
    PRIMARY KEY(id)
);
```

---

### 13. Konfigurasi Database

Konfigurasi koneksi database dilakukan pada file `.env`.

```
database.default.hostname = localhost
database.default.database = lab_ci4
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

---

### 14. Membuat Model

Buat file `ArtikelModel.php` pada direktori `app/Models`.

```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar'];
}
```

---

### 15. Membuat Controller

Buat file `Artikel.php` pada direktori `app/Controllers`.

```php
<?php
namespace App\Controllers;
use App\Models\ArtikelModel;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll();
        return view('artikel/index', compact('artikel', 'title'));
    }
}
```

---

### 16. Membuat View Daftar Artikel

Buat file `index.php` pada direktori `app/Views/artikel`.

```php
<?= $this->include('template/header'); ?>
<?php if($artikel): foreach($artikel as $row): ?>
<article class="entry">
    <h2><a href="<?= base_url('/artikel/' . $row['slug']);?>"><?= $row['judul']; ?></a></h2>
    <img src="<?= base_url('/gambar/' . $row['gambar']);?>" alt="<?= $row['judul']; ?>">
    <p><?= substr($row['isi'], 0, 200); ?></p>
</article>
<hr class="divider" />
<?php endforeach; else: ?>
<article class="entry">
    <h2>Belum ada data.</h2>
</article>
<?php endif; ?>
<?= $this->include('template/footer'); ?>
```

Tambahkan data artikel melalui query SQL:

```sql
INSERT INTO artikel (judul, isi, slug) VALUES
('Artikel pertama', 'Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan...', 'artikel-pertama'),
('Artikel kedua', 'Tidak seperti anggapan banyak orang, Lorem Ipsum bukanlah teks-teks yang diacak...', 'artikel-kedua');
```

**Tampilan Daftar Artikel:**

<img width="1365" height="719" alt="Screenshot 2026-03-06 174051" src="https://github.com/user-attachments/assets/ca9e79b0-a8df-4751-a75e-d0eb38225992" />

---

### 17. Membuat Tampilan Detail Artikel

Tambahkan method `view()` pada Controller Artikel.

```php
public function view($slug)
{
    $model = new ArtikelModel();
    $artikel = $model->where(['slug' => $slug])->first();
    if (!$artikel) {
        throw PageNotFoundException::forPageNotFound();
    }
    $title = $artikel['judul'];
    return view('artikel/detail', compact('artikel', 'title'));
}
```

Buat file `detail.php` pada direktori `app/Views/artikel` dan tambahkan routing:

```php
$routes->get('/artikel/(:any)', 'Artikel::view/$1');
```

**Tampilan Detail Artikel:**

<img width="1365" height="716" alt="Screenshot 2026-03-06 175400" src="https://github.com/user-attachments/assets/7f0ce693-f717-4469-93e9-0b3cfdbbacb0" />
<img width="1365" height="717" alt="Screenshot 2026-03-06 175438" src="https://github.com/user-attachments/assets/3d1973cc-bc97-4a23-bf3a-c7858158f131" />


---

### 18. Membuat Menu Admin

Tambahkan method `admin_index()` pada Controller Artikel.

```php
public function admin_index()
{
    $title = 'Daftar Artikel';
    $model = new ArtikelModel();
    $artikel = $model->findAll();
    return view('artikel/admin_index', compact('artikel', 'title'));
}
```

Buat file `admin_index.php` pada direktori `app/Views/artikel` menggunakan template admin:

```php
<?= $this->include('template/admin_header'); ?>
<table class="table">
    <thead>
        <tr>
            <th>ID</th><th>Judul</th><th>Status</th><th>AKsi</th>
        </tr>
    </thead>
    <tbody>
        <?php if($artikel): foreach($artikel as $row): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><b><?= $row['judul']; ?></b><p><small><?= substr($row['isi'], 0, 50); ?></small></p></td>
            <td><?= $row['status']; ?></td>
            <td>
                <a class="btn" href="<?= base_url('/admin/artikel/edit/' . $row['id']);?>">Ubah</a>
                <a class="btn btn-danger" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']);?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="4">Belum ada data.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?= $this->include('template/admin_footer'); ?>
```

Tambahkan routing untuk admin:

```php
$routes->group('admin', function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});
```

**Tampilan Admin Index:**

<img width="1365" height="719" alt="Screenshot 2026-03-06 185512" src="https://github.com/user-attachments/assets/d916d0cb-c56e-408e-81f2-da45e2d15ec4" />

---

### 19. Menambah Data Artikel

Tambahkan method `add()` pada Controller Artikel dan buat view `form_add.php`.

```php
public function add()
{
    $validation = \Config\Services::validation();
    $validation->setRules(['judul' => 'required']);
    $isDataValid = $validation->withRequest($this->request)->run();
    if ($isDataValid) {
        $artikel = new ArtikelModel();
        $artikel->insert([
            'judul' => $this->request->getPost('judul'),
            'isi'   => $this->request->getPost('isi'),
            'slug'  => url_title($this->request->getPost('judul')),
        ]);
        return redirect('admin/artikel');
    }
    $title = "Tambah Artikel";
    return view('artikel/form_add', compact('title'));
}
```

**Tampilan Tambah Artikel:**

<img width="1365" height="717" alt="Screenshot 2026-03-06 191558" src="https://github.com/user-attachments/assets/b9e3bb43-1f77-4cef-940c-75143c647962" />
<img width="1365" height="717" alt="Screenshot 2026-03-06 191031" src="https://github.com/user-attachments/assets/82fae563-cd55-4e49-a408-a3064811c580" />

---

### 20. Mengubah Data Artikel

Tambahkan method `edit()` pada Controller Artikel dan buat view `form_edit.php`.

```php
public function edit($id)
{
    $artikel = new ArtikelModel();
    $validation = \Config\Services::validation();
    $validation->setRules(['judul' => 'required']);
    $isDataValid = $validation->withRequest($this->request)->run();
    if ($isDataValid) {
        $artikel->update($id, [
            'judul' => $this->request->getPost('judul'),
            'isi'   => $this->request->getPost('isi'),
        ]);
        return redirect('admin/artikel');
    }
    $data = $artikel->where('id', $id)->first();
    $title = "Edit Artikel";
    return view('artikel/form_edit', compact('title', 'data'));
}
```

**Tampilan Edit Artikel:**

<img width="1365" height="716" alt="Screenshot 2026-03-06 190719" src="https://github.com/user-attachments/assets/5da63764-2ed8-409b-80ad-8de69c080c49" />

---

### 21. Menghapus Data Artikel

Tambahkan method `delete()` pada Controller Artikel.

```php
public function delete($id)
{
    $artikel = new ArtikelModel();
    $artikel->delete($id);
    return redirect('admin/artikel');
}
```

Ketika tombol Hapus diklik, akan muncul konfirmasi sebelum data dihapus.

**Tampilan Konfirmasi Hapus:**

<img width="1365" height="719" alt="Screenshot 2026-03-06 191104" src="https://github.com/user-attachments/assets/0bd09ca0-acc1-4316-946b-cb30cecbb446" />

---

**Kesimpulan:**

Pada praktikum ini telah berhasil dibuat aplikasi CRUD sederhana menggunakan Framework CodeIgniter 4 yang mencakup fitur menampilkan daftar artikel, melihat detail artikel, menambah, mengubah, dan menghapus data artikel melalui halaman admin. Dari praktikum ini dapat disimpulkan bahwa CodeIgniter 4 adalah framework PHP yang menggunakan konsep **MVC (Model-View-Controller)**, di mana **Routing** dikonfigurasi di `app/Config/Routes.php` untuk menghubungkan URL dengan Controller, **Controller** bertugas menerima request dan mengirimkan data ke View, serta **View** bertugas menampilkan data kepada pengguna dengan tampilan HTML. **Template** (header & footer) digunakan untuk membuat tampilan yang konsisten di semua halaman, fitur **Auto Routing** memungkinkan method diakses tanpa mendefinisikan route secara manual, dan mode **development** pada file `.env` wajib diaktifkan agar error dapat terdeteksi dengan detail.



# Praktikum 3 - View Layout dan View Cell

## Langkah-langkah Praktikum

### 22. Membuat Layout Utama

Buat folder `layout` di dalam `app/Views/`, kemudian buat file `main.php` di dalamnya.

File ini berfungsi sebagai **template induk** yang berisi struktur HTML dasar seperti header, navigasi, sidebar, dan footer. Bagian konten dinamis menggunakan `renderSection('content')`.
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'My Website' ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
    <div id="container">
        <header>
            <div class="header-inner">
                <h1>Layout Sederhana</h1>
                <div class="header-info">
                    <p>Modul Praktikum Pemrograman Web 2</p>
                    <p>Amelia Nurmala Dewi - Universitas Pelita Bangsa, Bekasi</p>
                </div>
            </div>
        </header>
        <nav>
            <a href="<?= base_url('/');?>" 
                <?= (current_url() == base_url('/') || uri_string() == '') ? 'class="active"' : '' ?>>
                Home
            </a>
            <a href="<?= base_url('/artikel');?>" 
                <?= (uri_string() == 'artikel') ? 'class="active"' : '' ?>>
                Artikel
            </a>
            <a href="<?= base_url('/about');?>" 
                <?= (uri_string() == 'about') ? 'class="active"' : '' ?>>
                About
            </a>
            <a href="<?= base_url('/contact');?>" 
                <?= (uri_string() == 'contact') ? 'class="active"' : '' ?>>
                Kontak
            </a>
        </nav>
        <section id="wrapper">
            <section id="main">
                <?= $this->renderSection('content') ?>
            </section>
            <aside id="sidebar">
                <?= view_cell('App\\Cells\\ArtikelTerkini::renderByKategori', ['kategori' => 'teknologi']) ?>
                <div class="widget-box">
                    <h3 class="title">Widget Header</h3>
                    <ul>
                        <li><a href="#">Widget Link</a></li>
                        <li><a href="#">Widget Link</a></li>
                    </ul>
                </div>
                <div class="widget-box">
                    <h3 class="title">Widget Text</h3>
                    <p>Vestibulum lorem elit, iaculis in nisl volutpat,
                    malesuada tincidunt arcu. Proin in leo fringilla,
                    vestibulum mi porta, faucibus felis. Integer pharetra 
                    est nunc, nec pretium nunc pretium ac.</p>
                </div>
            </aside>
        </section>
        <footer>
            <p>&copy; 2026 - Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>
</html>
```

---

### 23. Modifikasi File View

Setiap halaman diubah agar menggunakan layout utama dengan cara meng-extend `layout/main`.

**app/Views/home.php**
```php
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->endSection() ?>
```

**app/Views/about.php**
```php
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->endSection() ?>
```

**app/Views/contact.php**
```php
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->endSection() ?>
```

**app/Views/artikel.php**
```php
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->endSection() ?>
```

---

### 24. Modifikasi Controller Home

File `app/Controllers/Home.php` diubah agar memanggil view `home` dengan data yang sesuai.
```php
<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title'   => 'Halaman Home',
            'content' => 'Selamat datang di website saya'
        ];
        return view('home', $data);
    }
}
```

---

### 25. Menambahkan Kolom di Database

Agar dapat menampilkan artikel terbaru berdasarkan tanggal, ditambahkan kolom `created_at` dan `kategori` pada tabel `artikel` di phpMyAdmin.
```sql
ALTER TABLE artikel ADD COLUMN created_at DATETIME DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE artikel ADD COLUMN kategori VARCHAR(100) DEFAULT 'umum';
UPDATE artikel SET kategori = 'teknologi' WHERE id = 1;
UPDATE artikel SET kategori = 'teknologi' WHERE id = 2;
```

---

### 26. Membuat Class View Cell

Buat folder `Cells` di dalam `app/`, kemudian buat file `ArtikelTerkini.php`.

> **Catatan:** Karena menggunakan CodeIgniter 4 versi 4.7.0, class tidak menggunakan `extends Cell` karena terjadi perubahan pada constructor Cell di versi ini. Namun fungsinya tetap sama dan tetap dapat dipanggil menggunakan `view_cell()`.
```php
<?php
namespace App\Cells;
use App\Models\ArtikelModel;

class ArtikelTerkini
{
    public function render()
    {
        $model = new ArtikelModel();
        $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();
        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }

    public function renderByKategori($kategori = 'teknologi')
    {
        $model = new ArtikelModel();
        $artikel = $model->where('kategori', $kategori)
                        ->orderBy('created_at', 'DESC')
                        ->limit(5)
                        ->findAll();
        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
}
```

---

### 27. Membuat View untuk View Cell

Buat folder `components` di dalam `app/Views/`, kemudian buat file `artikel_terkini.php`.
```php
<h3>Artikel Terkini</h3>
<ul>
    <?php foreach ($artikel as $row): ?>
    <li>
        <a href="<?= base_url('/artikel/' . $row['slug']) ?>">
            <?= $row['judul'] ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
```

---

### 28. Hasil Tampilan

**Halaman Home**

<img width="1365" height="678" alt="Screenshot 2026-03-26 113658" src="https://github.com/user-attachments/assets/f5b255be-6a23-4d80-85b5-577645009c0d" />

**Halaman Artikel**

<img width="1358" height="678" alt="Screenshot 2026-03-26 121122" src="https://github.com/user-attachments/assets/24cae9cb-4584-4c65-ba6c-1dc442b2ef88" />

**Halaman About**

<img width="1365" height="680" alt="Screenshot 2026-03-26 113746" src="https://github.com/user-attachments/assets/7452f6bc-5614-42cb-b1f5-feda4837f185" />

**Halaman Contact**

<img width="1363" height="677" alt="Screenshot 2026-03-26 113807" src="https://github.com/user-attachments/assets/4b7484a8-fcfb-4064-9dc5-e00576f70d22" />

---

## Pertanyaan dan Jawaban

### 1. Apa manfaat utama dari penggunaan View Layout dalam pengembangan aplikasi?

View Layout memungkinkan developer untuk membuat **template tampilan terpusat** yang dapat digunakan ulang oleh semua halaman. Manfaat utamanya adalah:
- **Menghindari pengulangan kode** — struktur HTML seperti header, navigasi, dan footer cukup ditulis sekali di file layout
- **Konsistensi tampilan** — semua halaman otomatis memiliki tampilan yang seragam
- **Kemudahan maintenance** — jika ingin mengubah tampilan, cukup edit satu file layout tanpa harus mengubah semua halaman satu per satu
- **Memisahkan struktur (statis) dari konten (dinamis)** — layout berisi kerangka tetap, sedangkan konten masing-masing halaman diisi melalui `section()`

---

### 2. Jelaskan perbedaan antara View Cell dan View biasa

| Fitur | View Cell | View Biasa |
|-------|-----------|------------|
| Bisa baca variabel dari Controller | Ya | Ya |
| Bisa menerima parameter saat dipanggil di View | Ya | Tidak |
| Bisa akses data dari Model secara mandiri | Ya (punya class sendiri) | Tidak (harus lewat Controller) |
| Cocok digunakan untuk | Widget dinamis, sidebar, komponen modular | Memecah tampilan statis yang sering digunakan |

**Kesimpulan:** View Cell adalah komponen yang lebih mandiri karena memiliki class PHP sendiri dan bisa mengambil data langsung dari Model tanpa bergantung pada Controller halaman utama. Sedangkan View biasa (View Partial) hanya berupa file tampilan statis yang di-include ke dalam halaman.

---

### 3. Ubah View Cell agar hanya menampilkan post dengan kategori tertentu

Untuk menampilkan artikel berdasarkan kategori tertentu, ditambahkan method `renderByKategori()` pada class `ArtikelTerkini`:
```php
public function renderByKategori($kategori = 'teknologi')
{
    $model = new ArtikelModel();
    $artikel = $model->where('kategori', $kategori)
                    ->orderBy('created_at', 'DESC')
                    ->limit(5)
                    ->findAll();
    return view('components/artikel_terkini', ['artikel' => $artikel]);
}
```

Kemudian di `app/Views/layout/main.php`, View Cell dipanggil dengan mengirimkan parameter kategori:
```php
<?= view_cell('App\\Cells\\ArtikelTerkini::renderByKategori', ['kategori' => 'teknologi']) ?>
```

Dengan cara ini, sidebar hanya akan menampilkan artikel yang berkategori **teknologi**. Kategori dapat diganti sesuai kebutuhan dengan mengubah nilai parameter `kategori`.


# Praktikum 4 - Framework Lanjutan (Modul Login)

## Langkah-Langkah Praktikum

### 29. Membuat Tabel User
Buat tabel user di database MySQL menggunakan query berikut:
```sql
CREATE TABLE user (
  id INT(11) auto_increment,
  username VARCHAR(200) NOT NULL,
  useremail VARCHAR(200),
  userpassword VARCHAR(200),
  PRIMARY KEY(id)
);
```

### 30. Membuat Model User
Buat file `app/Models/UserModel.php`:
```php
<?php
namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['username', 'useremail', 'userpassword'];
}
```

### 31. Membuat Controller User
Buat file `app/Controllers/User.php` dengan method `index()`, `login()`, dan `logout()`:
```php
<?php
namespace App\Controllers;
use App\Models\UserModel;
class User extends BaseController
{
    public function index() 
    {
        $title = 'Daftar User';
        $model = new UserModel();
        $users = $model->findAll();
        return view('user/index', compact('users', 'title'));
    }

    public function login()
    {
        helper(['form']);
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        if (!$email)
        {
            return view('user/login');
        }
        $session = session();
        $model = new UserModel();
        $login = $model->where('useremail', $email)->first();
        if ($login)
        {
            $pass = $login['userpassword'];
            if (password_verify($password, $pass))
            {
                $login_data = [
                    'user_id'    => $login['id'],
                    'user_name'  => $login['username'],
                    'user_email' => $login['useremail'],
                    'logged_in'  => TRUE,
                ];
                $session->set($login_data);
                return redirect('admin/artikel');
            }
            else
            {
                $session->setFlashdata("flash_msg", "Password salah.");
                return redirect()->to('/user/login');
            }
        }
        else
        {
            $session->setFlashdata("flash_msg", "email tidak terdaftar.");
            return redirect()->to('/user/login');
        }
    }

    public function logout() 
    {
        session()->destroy();
        return redirect()->to('/user/login');
    }
}
```

### 32. Membuat View Login
Buat direktori `app/Views/user/` lalu buat file `login.php` dengan tampilan yang sudah disesuaikan dengan style CSS website.

### 33. Membuat Database Seeder
Jalankan perintah berikut di CLI:
```bash
php spark make:seeder UserSeeder
```

Isi file `app/Database/Seeds/UserSeeder.php`:
```php
<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class UserSeeder extends Seeder
{
    public function run()
    {
        $model = model('UserModel');
        $model->insert([
            'username'     => 'admin',
            'useremail'    => 'admin@email.com',
            'userpassword' => password_hash('admin123', PASSWORD_DEFAULT),
        ]);
    }
}
```

Jalankan seeder:
```bash
php spark db:seed UserSeeder
```

### 34. Membuat Auth Filter
Buat file `app/Filters/Auth.php`:
```php
<?php namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if(! session()->get('logged_in')){
            return redirect()->to('/user/login');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
```

### 35. Konfigurasi Filters
Tambahkan kode berikut di file `app/Config/Filters.php`:
```php
'auth' => App\Filters\Auth::class
```

### 36. Konfigurasi Routes
Sesuaikan file `app/Config/Routes.php`:
```php
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});
```

### 37. Fungsi Logout
Tambahkan tombol Logout di navbar `admin_header.php` dengan konfirmasi sebelum logout:
```php
<a href="<?= base_url('/user/logout');?>" 
   onclick="return confirm('Yakin ingin logout?');"
   style="margin-left: auto; color: #f87171;">Logout</a>
```

---

## Hasil Screenshot

### Halaman Login
<img width="1365" height="682" alt="Screenshot 2026-04-06 124029" src="https://github.com/user-attachments/assets/a3ebcdd0-8bda-426f-8edf-50245efec04d" />

### Halaman Admin Portal Berita
<img width="1365" height="683" alt="Screenshot 2026-04-06 124122" src="https://github.com/user-attachments/assets/1b29290e-eba9-4ef5-be43-b479b0e2510c" />

### Halaman Tambah Artikel
<img width="1365" height="680" alt="Screenshot 2026-04-06 124344" src="https://github.com/user-attachments/assets/383b9779-12f1-41bc-8799-ab911d807039" />
<img width="1365" height="678" alt="Screenshot 2026-04-06 124403" src="https://github.com/user-attachments/assets/8f59d38c-e42f-4608-9699-8d5d588b2ab7" />

### Halaman Edit Artikel
<img width="1365" height="679" alt="Screenshot 2026-04-06 124450" src="https://github.com/user-attachments/assets/5dd9d3a6-15b4-4942-b9ca-f33e1281d21d" />
<img width="1365" height="681" alt="Screenshot 2026-04-06 124507" src="https://github.com/user-attachments/assets/abb4d311-f99a-417c-b84a-5266cabfae34" />

### Halaman Hapus Data
<img width="1363" height="677" alt="Screenshot 2026-04-06 124526" src="https://github.com/user-attachments/assets/c5883fb9-fef9-4ecc-9ea0-a7a4960fd5a2" />
<img width="1365" height="679" alt="Screenshot 2026-04-06 124543" src="https://github.com/user-attachments/assets/a3018954-4e0d-4ec0-8df3-13a3167ec432" />

### Halaman Logout
<img width="1365" height="679" alt="Screenshot 2026-04-06 124603" src="https://github.com/user-attachments/assets/aa6a5c31-c27a-443b-bde0-1159f2c3adc9" />


---

## Kesimpulan
Pada praktikum ini telah berhasil dibuat modul login menggunakan Framework CodeIgniter 4. Sistem login menggunakan session untuk menyimpan data user yang sudah login, dan Auth Filter untuk melindungi halaman admin agar hanya bisa diakses oleh user yang sudah login. Fungsi logout menghapus session dan mengarahkan kembali ke halaman login.


# Praktikum 5 - Pagination dan Pencarian di CodeIgniter 4

---

### Langkah 38 - Membuat Pagination

Pagination digunakan untuk membatasi tampilan data yang banyak menjadi beberapa halaman.

Buka Controller Artikel di `app/Controllers/Artikel.php`, modifikasi method `admin_index`:

```php
public function admin_index() 
{
    $title = 'Daftar Artikel';
    $model = new ArtikelModel();
    $data = [
        'title'   => $title,
        'artikel' => $model->paginate(10),
        'pager'   => $model->pager,
    ];
    return view('artikel/admin_index', $data);
}
```

Kemudian buka file `app/Views/artikel/admin_index.php`, tambahkan kode berikut di bawah tag `</table>`:

```php
<?= $pager->links(); ?>
```

**Screenshot Hasil Pagination:**

<img width="1363" height="678" alt="Screenshot 2026-04-15 104120" src="https://github.com/user-attachments/assets/3af2edda-a8cd-4e28-9deb-894ff29f1a27" />

---

### Langkah 39 - Membuat Pencarian

Pencarian data digunakan untuk memfilter data berdasarkan kata kunci.

Buka kembali Controller Artikel, ubah method `admin_index` menjadi seperti berikut:

```php
public function admin_index() 
{
    $title = 'Daftar Artikel';
    $q     = $this->request->getVar('q') ?? '';
    $model = new ArtikelModel();
    $data  = [
        'title'   => $title,
        'q'       => $q,
        'artikel' => $model->like('judul', $q)->paginate(10),
        'pager'   => $model->pager,
    ];
    return view('artikel/admin_index', $data);
}
```

Kemudian buka file `app/Views/artikel/admin_index.php`, tambahkan form pencarian sebelum tag `<table>`:

```php
<form method="get" class="form-search">
    <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data">
    <input type="submit" value="Cari" class="btn btn-primary">
</form>
```

Ubah juga baris pager agar query pencarian tetap terbawa saat pindah halaman:

```php
<?= $pager->only(['q'])->links(); ?>
```

**Screenshot Hasil Pencarian:**

<img width="1362" height="683" alt="Screenshot 2026-04-15 104101" src="https://github.com/user-attachments/assets/78690ff6-c840-4dce-973c-b7b17d123913" />


## Praktikum 6 - Relasi Tabel dan Query Builder
---

### Langkah 40 - Membuat Tabel Kategori

Buat tabel kategori baru di phpMyAdmin:

```sql
CREATE TABLE kategori (
    id_kategori INT(11) AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL,
    slug_kategori VARCHAR(100),
    PRIMARY KEY (id_kategori)
);

INSERT INTO kategori (nama_kategori, slug_kategori) VALUES
('Berita Teknologi', 'berita-teknologi'),
('Artikel Kesehatan', 'artikel-kesehatan'),
('Tutorial Pemrograman', 'tutorial-pemrograman'),
('Review Gadget', 'review-gadget');
```

### Langkah 41 - Menambah Foreign Key ke Tabel Artikel

```sql
ALTER TABLE artikel
ADD COLUMN id_kategori INT(11),
ADD CONSTRAINT fk_kategori_artikel
FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori);

UPDATE artikel SET id_kategori = 1 WHERE id BETWEEN 1 AND 5;
UPDATE artikel SET id_kategori = 2 WHERE id BETWEEN 6 AND 10;
UPDATE artikel SET id_kategori = 3 WHERE id BETWEEN 11 AND 13;
UPDATE artikel SET id_kategori = 4 WHERE id BETWEEN 14 AND 15;
```

### Langkah 42 - Membuat KategoriModel

Buat file baru `app/Models/KategoriModel.php`:

```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table          = 'kategori';
    protected $primaryKey     = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $allowedFields  = ['nama_kategori', 'slug_kategori'];
}
```

### Langkah 43 - Modifikasi ArtikelModel

Tambahkan method `getArtikelDenganKategori()` di `app/Models/ArtikelModel.php`:

```php
public function getArtikelDenganKategori()
{
    return $this->db->table('artikel')
        ->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
        ->get()
        ->getResultArray();
}
```

### Langkah 44 - Modifikasi Controller admin_index

Update method `admin_index` di `app/Controllers/Artikel.php` untuk mendukung filter kategori:

```php
public function admin_index()
{
    $title       = 'Daftar Artikel (Admin)';
    $q           = $this->request->getVar('q') ?? '';
    $kategori_id = $this->request->getVar('kategori_id') ?? '';

    $db      = \Config\Database::connect();
    $builder = $db->table('artikel')
        ->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

    if ($q != '') {
        $builder->like('artikel.judul', $q);
    }

    if ($kategori_id != '') {
        $builder->where('artikel.id_kategori', (int)$kategori_id);
    }

    $kategoriModel = new KategoriModel();

    $data = [
        'title'       => $title,
        'q'           => $q,
        'kategori_id' => $kategori_id,
        'artikel'     => $builder->get()->getResultArray(),
        'pager'       => null,
        'kategori'    => $kategoriModel->findAll(),
    ];

    return view('artikel/admin_index', $data);
}
```

### Langkah 45 - Modifikasi View admin_index

Tambahkan dropdown filter kategori pada form pencarian di `app/Views/artikel/admin_index.php`:

```php
<form method="get" action="<?= base_url('/admin/artikel'); ?>" class="form-search">
    <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari judul artikel">
    <select name="kategori_id">
        <option value="">Semua Kategori</option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id_kategori']; ?>" 
                <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                <?= $k['nama_kategori']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Cari" class="btn btn-primary">
</form>
```

### Screenshot Hasil



**Daftar Artikel dengan Kolom Kategori:**

<img width="1359" height="675" alt="Screenshot 2026-04-15 113833" src="https://github.com/user-attachments/assets/5fb23fea-c35d-4513-860f-6eede85e33a8" />

**Filter berdasarkan Kategori:**

<img width="1365" height="685" alt="Screenshot 2026-04-15 113819" src="https://github.com/user-attachments/assets/8621ba72-ec89-478c-943b-901aaffb0646" />

<img width="1361" height="683" alt="Screenshot 2026-04-15 113807" src="https://github.com/user-attachments/assets/2af5633f-0307-438f-aadc-9934ea0d0f63" />

<img width="1365" height="680" alt="Screenshot 2026-04-15 113737" src="https://github.com/user-attachments/assets/785c7d20-4255-4ec4-afeb-9969096565ef" />

<img width="1365" height="685" alt="Screenshot 2026-04-15 113022" src="https://github.com/user-attachments/assets/e538bab1-8df0-4582-980c-afac3fc11ad6" />


# Praktikum 7 - Upload File Gambar

### Langkah 46 - Upload Gambar pada Artikel

Buka Controller Artikel pada `app/Controllers/Artikel.php`, sesuaikan kode pada method `add()` seperti berikut:

```php
public function add()
{
    $kategoriModel = new KategoriModel();

    $validation = \Config\Services::validation();
    $validation->setRules(['judul' => 'required']);
    $isDataValid = $validation->withRequest($this->request)->run();

    if ($isDataValid)
    {
        $file = $this->request->getFile('gambar');
        $file->move(ROOTPATH . 'public/gambar');

        $artikel = new ArtikelModel();
        $artikel->insert([
            'judul'       => $this->request->getPost('judul'),
            'isi'         => $this->request->getPost('isi'),
            'slug'        => url_title($this->request->getPost('judul')),
            'gambar'      => $file->getName(),
            'id_kategori' => $this->request->getPost('id_kategori'),
        ]);
        return redirect('admin/artikel');
    }

    $data['kategori'] = $kategoriModel->findAll();
    $data['title']    = "Tambah Artikel";
    return view('artikel/form_add', $data);
}
```

---

### Langkah 47 - Modifikasi form_add.php

Buka file `app/Views/artikel/form_add.php`, tambahkan field input file dan sesuaikan tag form dengan menambahkan enctype:

```php
<form action="" method="post" enctype="multipart/form-data">
    <p>
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" required>
    </p>
    <p>
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" cols="50" rows="10"></textarea>
    </p>
    <p>
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label for="gambar">Gambar</label>
        <input type="file" name="gambar">
    </p>
    <p><input type="submit" value="Kirim" class="btn btn-large"></p>
</form>
```

**Screenshot Form Tambah Artikel:**

<img width="1365" height="679" alt="Screenshot 2026-05-11 200909" src="https://github.com/user-attachments/assets/0b44a138-d11e-4492-ace7-5fbea0bf0aef" />


---

### Langkah 48 - Uji Coba Upload Gambar

Ujicoba file upload dengan mengakses menu tambah artikel di `http://localhost:8080/admin/artikel/add`, isi judul, isi artikel, pilih kategori, pilih file gambar lalu klik Kirim.

**Screenshot Gambar Tersimpan di Folder:**

<img width="302" height="277" alt="Screenshot 2026-05-11 201126" src="https://github.com/user-attachments/assets/4fed5a96-eace-4c1e-bc67-cbd58236cc1a" />

**Screenshot Hasil Artikel dengan Gambar:**

<img width="1365" height="679" alt="Screenshot 2026-05-11 200744" src="https://github.com/user-attachments/assets/00de648f-afd9-413a-ae2d-7af2b50b82ff" />

---

# Praktikum 8 - AJAX

## Langkah-langkah Praktikum

### Langkah 49 - Download dan Pasang jQuery

Download jQuery dari `https://jquery.com/download`, lalu simpan file `jquery-3.6.0.min.js` ke folder:
```
public/assets/js/jquery-3.6.0.min.js
```

---

### Langkah 50 - Membuat AjaxController

Buat file baru `app/Controllers/AjaxController.php`:

```php
<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Artikel AJAX'
        ];
        return view('ajax/index', $data);
    }

    public function getData()
    {
        $model = new ArtikelModel();
        $data  = $model->findAll();
        return $this->response->setJSON($data);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        $data = ['status' => 'OK'];
        return $this->response->setJSON($data);
    }

    public function save()
    {
        $model = new ArtikelModel();
        $data  = [
            'judul'       => $this->request->getPost('judul'),
            'isi'         => $this->request->getPost('isi'),
            'slug'        => url_title($this->request->getPost('judul')),
            'id_kategori' => $this->request->getPost('id_kategori'),
        ];
        $model->insert($data);
        return $this->response->setJSON(['status' => 'OK']);
    }

    public function update($id)
    {
        $model = new ArtikelModel();
        $data  = [
            'judul' => $this->request->getPost('judul'),
            'isi'   => $this->request->getPost('isi'),
        ];
        $model->update($id, $data);
        return $this->response->setJSON(['status' => 'OK']);
    }
}
```

---

### Langkah 51 - Menambahkan Route

Buka `app/Config/Routes.php`, tambahkan route berikut di luar group admin:

```php
$routes->get('ajax', 'AjaxController::index');
$routes->get('ajax/getData', 'AjaxController::getData');
$routes->post('ajax/save', 'AjaxController::save');
$routes->post('ajax/update/(:num)', 'AjaxController::update/$1');
$routes->post('ajax/delete/(:num)', 'AjaxController::delete/$1');
```

---

### Langkah 52 - Membuat View AJAX

Buat folder `app/Views/ajax/` lalu buat file `index.php` di dalamnya dengan isi form tambah artikel, form edit artikel, tabel data, dan script jQuery AJAX.

---

## Hasil Uji Coba

### Tampilan Halaman AJAX
Halaman AJAX menampilkan data artikel yang diambil dari database menggunakan AJAX request tanpa reload halaman.

**Screenshot:**

<img width="1362" height="677" alt="Screenshot 2026-05-15 142754" src="https://github.com/user-attachments/assets/e0b2d01d-1f2f-4db4-9169-00010a4f3119" />


---

### Fitur Tambah Artikel
Menambahkan artikel baru menggunakan AJAX. Data langsung muncul di tabel tanpa reload halaman.

**Screenshot:**

<img width="1365" height="680" alt="Screenshot 2026-05-15 143332" src="https://github.com/user-attachments/assets/9f3e7e6d-a028-45e1-acba-95f83b29f75f" />
<img width="1365" height="677" alt="Screenshot 2026-05-15 143134" src="https://github.com/user-attachments/assets/812a566f-b76c-4c86-85a2-6e964551d346" />
<img width="408" height="246" alt="Screenshot 2026-05-15 143354" src="https://github.com/user-attachments/assets/90b1d823-bb3b-4d05-84b2-70e4707ef465" />

---

### Fitur Edit Artikel
Mengubah data artikel menggunakan AJAX. Form edit muncul dan data terupdate tanpa reload halaman.

**Screenshot:**

<img width="1365" height="673" alt="Screenshot 2026-05-15 143551" src="https://github.com/user-attachments/assets/1a466792-f3fb-43e7-aa7d-4668dc36b258" />
<img width="1365" height="675" alt="Screenshot 2026-05-15 143611" src="https://github.com/user-attachments/assets/fb41277a-967f-49e6-9969-1b87385236c6" />
<img width="377" height="250" alt="Screenshot 2026-05-15 143621" src="https://github.com/user-attachments/assets/998f5703-43e5-4361-9257-132557309be1" />

---

### Fitur Delete Artikel
Menghapus artikel menggunakan AJAX. Data langsung hilang dari tabel tanpa reload halaman.

**Screenshot:**

<img width="1365" height="687" alt="Screenshot 2026-05-15 143638" src="https://github.com/user-attachments/assets/d06c8e00-cb37-44f0-9339-4d6046f53848" />
<img width="1365" height="682" alt="Screenshot 2026-05-15 143654" src="https://github.com/user-attachments/assets/04de6572-1a1a-4f8b-ae74-b1e6df7cd94e" />
<img width="375" height="228" alt="Screenshot 2026-05-15 143704" src="https://github.com/user-attachments/assets/320cac2a-c679-4337-8a1b-7e31ce4d7d60" />

---

## Kesimpulan
Dengan menggunakan AJAX, aplikasi web menjadi lebih interaktif dan responsif karena data dapat diperbarui tanpa harus melakukan reload halaman secara keseluruhan. jQuery mempermudah implementasi AJAX dengan syntax yang lebih sederhana.

---

# Praktikum 9 - Implementasi AJAX Pagination dan Search

## Langkah-langkah Praktikum

### Langkah 53 - Persiapan
Pastikan:
- MySQL Server sudah berjalan
- Database `lab_ci4` sudah ada
- Tabel `artikel` dan `kategori` sudah terisi data
- Library jQuery sudah terpasang di `public/assets/js/jquery-3.6.0.min.js`

---

### Langkah 54 - Modifikasi Controller Artikel

Buka `app/Controllers/Artikel.php`, modifikasi method `admin_index()` untuk mengembalikan data dalam format JSON jika request adalah AJAX:

```php
public function admin_index()
{
    $title       = 'Daftar Artikel (Admin)';
    $model       = new ArtikelModel();
    $q           = $this->request->getVar('q') ?? '';
    $kategori_id = $this->request->getVar('kategori_id') ?? '';
    $page        = $this->request->getVar('page') ?? 1;
    $sort        = $this->request->getVar('sort') ?? 'id';
    $order       = $this->request->getVar('order') ?? 'asc';

    $builder = $model->table('artikel')
        ->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

    if ($q != '') {
        $builder->like('artikel.judul', $q);
    }

    if ($kategori_id != '') {
        $builder->where('artikel.id_kategori', $kategori_id);
    }

    $builder->orderBy($sort, $order);

    $artikel = $builder->paginate(10, 'default', $page);
    $pager   = $model->pager;

    $data = [
        'title'       => $title,
        'q'           => $q,
        'kategori_id' => $kategori_id,
        'artikel'     => $artikel,
        'pager'       => $pager,
        'sort'        => $sort,
        'order'       => $order,
    ];

    if ($this->request->isAJAX()) {
        return $this->response->setJSON($data);
    } else {
        $kategoriModel    = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        return view('artikel/admin_index', $data);
    }
}
```

**Penjelasan:**
- `$page` — mendapatkan nomor halaman dari request, default halaman 1
- `$sort` dan `$order` — untuk fitur sorting data
- `$builder->paginate(10, 'default', $page)` — menerapkan pagination dengan nomor halaman yang diberikan
- `$this->request->isAJAX()` — memeriksa apakah request yang datang adalah AJAX
- Jika AJAX → kembalikan data dalam format JSON
- Jika bukan AJAX → tampilkan view seperti biasa

---

### Langkah 55 - Modifikasi View admin_index.php

Buka `app/Views/artikel/admin_index.php`, modifikasi untuk menggunakan jQuery AJAX dengan fitur:
- Form pencarian
- Filter kategori
- Sorting data
- Loading indicator
- Tabel data dari AJAX
- Pagination dari AJAX

---

## Hasil Uji Coba

### 1. Tampilan Awal Halaman Admin
Data artikel ditampilkan menggunakan AJAX tanpa reload halaman. Terdapat form pencarian, dropdown kategori, dan fitur sorting.

**Screenshot:**

<img width="1365" height="679" alt="Screenshot 2026-05-15 150937" src="https://github.com/user-attachments/assets/7ee0efe0-e1e6-4594-9bce-75d6f57a715d" />

---

### 2. Fitur Pencarian
Ketik kata kunci di kolom pencarian lalu klik **Cari**. Data akan difilter tanpa reload halaman.

**Screenshot:**

<img width="1365" height="680" alt="Screenshot 2026-05-15 151037" src="https://github.com/user-attachments/assets/ec7a9c47-a1b0-4858-8796-e00aabc5301b" />

---

### 3. Filter Kategori
Pilih kategori dari dropdown, data akan langsung terfilter berdasarkan kategori yang dipilih tanpa reload halaman.

**Screenshot:**

<img width="1365" height="680" alt="Screenshot 2026-05-15 151114" src="https://github.com/user-attachments/assets/169a422c-910e-42c9-bce6-180e8da518cb" />

---

### 4. Sorting  Z-A
Pilih **Judul** dan **A-Z** lalu klik **Urutkan**. Data akan diurutkan dari A ke Z tanpa reload halaman.

**Screenshot:**

<img width="1363" height="678" alt="Screenshot 2026-05-15 151159" src="https://github.com/user-attachments/assets/1b49eb9b-ce9b-42c3-b2f0-9f7732217fdb" />

---

## Kesimpulan
Dengan mengimplementasikan AJAX pada pagination dan search, halaman admin artikel menjadi lebih responsif dan interaktif. Pengguna tidak perlu menunggu halaman reload setiap kali melakukan pencarian, filter kategori, sorting, maupun pindah halaman. Hal ini meningkatkan performa dan User Experience (UX) aplikasi web secara signifikan.

---

# Praktikum 10 - Membangun REST API dengan CodeIgniter 4

---

## Apa itu REST API?

REST API (Representational State Transfer) adalah salah satu desain arsitektur API yang berisi aturan untuk membuat web service dengan membatasi hak akses client. 

Cara kerja REST API menggunakan prinsip:
- **REST Server** → Bertindak sebagai penyedia data/resource
- **REST Client** → Membuat HTTP request pada server menggunakan URI
- Data yang dikirim maupun diterima berformat **JSON**

Analoginya seperti restoran: pelanggan hanya bisa memesan sesuai daftar menu (endpoint yang tersedia), meskipun si koki (server) bisa melakukan lebih banyak hal.

---

## Langkah-langkah Praktikum

### 1. Persiapan

- Pastikan project `lab7_php_ci` sudah berjalan di `htdocs`
- Install aplikasi **Postman** sebagai REST Client untuk pengujian
  - Download: https://www.postman.com/downloads/

---

### 2. Membuat REST Controller

Buat file baru: `app/Controllers/Post.php`

Controller ini extends `ResourceController` dari CodeIgniter 4 dan menggunakan `ResponseTrait` untuk memudahkan pengiriman response JSON.

```php
<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    // Menampilkan semua data
    public function index()
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    // Menambah data baru
    public function create()
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
        ];
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data artikel berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
    }

    // Menampilkan data spesifik
    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    // Mengubah data
    public function update($id = null)
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
        ];
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data artikel berhasil diubah.'
            ]
        ];
        return $this->respond($response);
    }

    // Menghapus data
    public function delete($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->delete($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data artikel berhasil dihapus.'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
}
```

Controller ini berisi 5 method:

| Method | Fungsi |
|--------|--------|
| `index()` | Menampilkan seluruh data artikel |
| `create()` | Menambahkan data baru ke database |
| `show($id)` | Menampilkan data artikel spesifik berdasarkan ID |
| `update($id)` | Mengubah data artikel berdasarkan ID |
| `delete($id)` | Menghapus data artikel berdasarkan ID |

---

### 3. Membuat Routing REST API

Buka file `app/Config/Routes.php`, tambahkan baris berikut:

```php
$routes->resource('post');
```

Untuk memverifikasi route yang sudah dibuat, jalankan perintah:

```bash
php spark routes
```

Satu baris kode tersebut secara otomatis menghasilkan semua endpoint berikut:

| Method | Route | Handler |
|--------|-------|---------|
| GET | post | App\Controllers\Post::index |
| GET | post/new | App\Controllers\Post::new |
| GET | post/(.*)/edit | App\Controllers\Post::edit/$1 |
| GET | post/(.*) | App\Controllers\Post::show/$1 |
| POST | post | App\Controllers\Post::create |
| PATCH | post/(.*) | App\Controllers\Post::update/$1 |
| PUT | post/(.*) | App\Controllers\Post::update/$1 |
| DELETE | post/(.*) | App\Controllers\Post::delete/$1 |

**Screenshot hasil php spark routes:**

<img width="909" height="686" alt="Screenshot 2026-05-30 125532" src="https://github.com/user-attachments/assets/beecec36-0904-4438-b4f9-130cbb00d019" />

<img width="911" height="679" alt="Screenshot 2026-05-30 125554" src="https://github.com/user-attachments/assets/ac24b4a5-2017-4a12-b20d-c1282040b95c" />


---

### 4. Matriks CRUD & REST

| Operasi Database | Metode HTTP | Endpoint | Fungsi Controller |
|-----------------|-------------|----------|-------------------|
| Read (semua) | GET | /post | index() |
| Read (spesifik) | GET | /post/{id} | show($id) |
| Create | POST | /post | create() |
| Update | PUT | /post/{id} | update($id) |
| Delete | DELETE | /post/{id} | delete($id) |

---

### 5. Testing REST API dengan Postman

Buka Postman → klik tanda **+** untuk membuat HTTP Request baru.

---

#### a. GET - Menampilkan Semua Data

- **Method**: GET  
- **URL**: `http://localhost:8080/post`  
- Klik **Send**
- Response: JSON array semua data artikel dengan status **200 OK**

**Screenshot:**

<img width="1365" height="724" alt="Screenshot 2026-05-30 125831" src="https://github.com/user-attachments/assets/7f1ce931-cada-4975-82b1-865e062c92a7" />

---

#### b. GET - Menampilkan Data Spesifik

- **Method**: GET  
- **URL**: `http://localhost:8080/post/27`  
- Klik **Send**
- Response: JSON data artikel dengan ID 27, status **200 OK**

**Screenshot:**

<img width="1365" height="719" alt="Screenshot 2026-05-30 130102" src="https://github.com/user-attachments/assets/83453eaa-a2e4-445d-b84d-0b7c9ae88f30" />

<img width="1365" height="721" alt="Screenshot 2026-05-30 132808" src="https://github.com/user-attachments/assets/54c4b4a3-3965-41b0-9158-d4575737aa20" />

---

#### c. POST - Menambahkan Data Baru

- **Method**: POST  
- **URL**: `http://localhost:8080/post`  
- Tab **Body** → pilih **x-www-form-urlencoded**
- Isi KEY dan VALUE:
  - `judul` → `judul artikel baru`
  - `isi` → `isi artikel baru ditambahkan melalui api`
- Klik **Send**
- Response: JSON sukses dengan status **201 Created**

**Screenshot:**

<img width="1365" height="724" alt="Screenshot 2026-05-30 130719" src="https://github.com/user-attachments/assets/7424ab33-1008-48d8-a4c5-74aab86622c2" />

---

#### d. PUT - Mengubah Data

- **Method**: PUT  
- **URL**: `http://localhost:8080/post/27`  
- Tab **Body** → pilih **x-www-form-urlencoded**
- Isi KEY dan VALUE:
  - `judul` → `Judul Artikel Diubah`
  - `isi` → `Isi artikel telah diubah melalui API`
- Klik **Send**
- Response: JSON sukses dengan status **200 OK**

**Screenshot:**

<img width="1365" height="719" alt="Screenshot 2026-05-30 131305" src="https://github.com/user-attachments/assets/10599f06-5afc-4016-a17c-235b80980b01" />

---

#### e. DELETE - Menghapus Data

- **Method**: DELETE  
- **URL**: `http://localhost:8080/post/29`  
- Klik **Send** (tidak perlu mengisi Body)
- Response: JSON konfirmasi penghapusan dengan status **200 OK**

**Screenshot:**

<img width="1365" height="720" alt="Screenshot 2026-05-30 131426" src="https://github.com/user-attachments/assets/7438f1d9-3303-42d5-aca8-773881eaa086" />


---

## Kesimpulan

REST API dengan CodeIgniter 4 memungkinkan kita membangun backend yang dapat diakses oleh berbagai platform (mobile, web frontend seperti Vue.js, dll) menggunakan format JSON sebagai bahasa universal. Dengan `ResourceController` dan satu baris routing `$routes->resource('post')`, CI4 secara otomatis menyediakan semua endpoint CRUD yang diperlukan.


---

# Praktikum 11 - Frontend VueJS 3
---

## Langkah-Langkah Pengerjaan

### Langkah 1 - Konfigurasi CORS di CI4

Buka file `app/Config/Filters.php`, aktifkan filter CORS:

```php
public array $globals = [
    'before' => ['cors'],
    'after'  => ['cors'],
];

public array $methods = [
    'OPTIONS' => ['cors'],
];
```

Buka file `app/Config/Cors.php`, konfigurasi CORS:

```php
public array $default = [
    'allowedOrigins'  => ['*'],
    'allowedHeaders'  => ['Content-Type', 'Authorization', 'X-Requested-With'],
    'allowedMethods'  => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    'maxAge'          => 7200,
];
```

---

### Langkah 2 - Buat Struktur Folder

Buat folder `lab8_vuejs` di dalam `htdocs` dengan struktur:

```
lab8_vuejs/
│   index.html
│   README.md
└── assets/
    ├── css/
    │   └── style.css
    └── js/
        └── app.js
```

---

### Langkah 3 - Buat File index.html

Buat file `index.html` berisi struktur halaman VueJS dengan tabel artikel dan form modal untuk Tambah/Edit data.

---

### Langkah 4 - Buat File app.js

Buat file `assets/js/app.js` berisi logika VueJS 3 dengan method:
- `loadData()` — mengambil data dari API
- `tambah()` — membuka form tambah
- `edit(data)` — membuka form edit dengan data yang dipilih
- `hapus(index, id)` — menghapus data dengan konfirmasi
- `saveData()` — menyimpan data baru atau perubahan ke API

---

### Langkah 5 - Buat File style.css

Buat file `assets/css/style.css` berisi styling untuk tampilan tabel, tombol, dan modal form.

---

### Langkah 6 - Jalankan Aplikasi

1. Pastikan XAMPP Apache sudah berjalan
2. Jalankan server CI4 di terminal:
```
"C:\TUGAS AMEL\PHP MY ADMIN\php\php.exe" spark serve
```
3. Buka browser: `http://localhost/lab8_vuejs`

---

## Screenshot

### 1. Halaman Utama - Daftar Artikel
<img width="1364" height="677" alt="Screenshot 2026-05-30 163011" src="https://github.com/user-attachments/assets/c2019931-ccf4-496c-a5f8-770d9b19cbea" />

### 2. Form Tambah Data
<img width="1362" height="677" alt="Screenshot 2026-05-30 163513" src="https://github.com/user-attachments/assets/5ab8cdd9-76a9-4045-bf10-e486a4396dfa" />
<img width="1365" height="673" alt="Screenshot 2026-05-30 163530" src="https://github.com/user-attachments/assets/6be45380-47c9-4131-ac9d-522b1b84e114" />

### 3. Form Edit Data
<img width="1365" height="684" alt="Screenshot 2026-05-30 163026" src="https://github.com/user-attachments/assets/e4cd5ace-d0ed-4adc-a5a1-9488182f5aa8" />

### 4. Konfirmasi Hapus Data
<img width="1363" height="679" alt="Screenshot 2026-05-30 163621" src="https://github.com/user-attachments/assets/ee7af2b6-2668-46cb-9907-ea3359586d21" />

---

## Teknologi yang Digunakan

- **VueJS 3** (via CDN unpkg)
- **Axios** (HTTP Client via CDN)
- **CodeIgniter 4** (REST API Backend)
- **XAMPP** (Web Server)
- **HTML & CSS**

---

## Cara Menjalankan

1. Clone repository ini
2. Taruh folder `lab8_vuejs` di dalam `htdocs` XAMPP
3. Jalankan Apache di XAMPP
4. Jalankan server CI4: `php spark serve`
5. Buka browser: `http://localhost/lab8_vuejs`
```

---

# Praktikum 12 - VueJS Komponen dan Routing (Single Page Application)

## Tujuan
1. Memahami konsep komponen pada Framework VueJS
2. Memahami konsep Client-Side Routing untuk membangun Single Page Application (SPA)
3. Mengimplementasikan komponen dan routing menggunakan Vue Router berbasis CDN

---

## Struktur Direktori

```
lab8_vuejs/
│   index.html
│   README.md
└───assets/
    ├───css/
    │       style.css
    ├───foto.jpg
    └───js/
        │   app.js
        └───components/
                Home.js
                Artikel.js
                About.js
```

---

## Langkah-Langkah Praktikum

### Langkah 1 - Menambahkan Library Vue Router

Tambahkan library Vue Router di dalam tag `<head>` pada file `index.html`:

```html
<script src="https://unpkg.com/vue-router@4/dist/vue-router.global.js"></script>
```

---

### Langkah 2 - Membuat Folder Components

Buat folder baru `components` di dalam `assets/js/` untuk menyimpan file komponen terpisah.

---

### Langkah 3 - Membuat Komponen Home.js

File `assets/js/components/Home.js` berisi halaman beranda:

```javascript
const Home = {
    template: `
    <div class="home-container">
        <h2>Selamat Datang di Portal Admin Artikel</h2>
        <p>Gunakan menu navigasi di atas untuk mengelola data artikel secara real-time 
        memanfaatkan RESTful API CodeIgniter 4 dan VueJS.</p>
    </div>
    `
};
```

---

### Langkah 4 - Membuat Komponen Artikel.js

File `assets/js/components/Artikel.js` berisi seluruh logika CRUD artikel yang dipindahkan dari `app.js` lama, mencakup template tabel data, form modal, dan semua method (loadData, tambah, edit, hapus, saveData).

---

### Langkah 5 - Membuat Komponen About.js

File `assets/js/components/About.js` berisi halaman profil mahasiswa:

```javascript
const About = {
    template: `
    <div class="about-container">
        <h2>Profil Mahasiswa</h2>
        <div class="about-card">
            <img src="/lab8_vuejs/assets/foto.jpg" style="width:150px; height:150px; border-radius:50%;">
            <table>
                <tr><td>Nama</td><td>: Amelia Nurmala Dewi</td></tr>
                <tr><td>NIM</td><td>: 312410199</td></tr>
                <tr><td>Kelas</td><td>: I241B</td></tr>
            </table>
        </div>
    </div>
    `
};
```

---

### Langkah 6 - Mengonfigurasi Vue Router di app.js

File `assets/js/app.js` diubah menjadi konfigurasi router:

```javascript
const { createApp } = Vue;
const { createRouter, createWebHashHistory } = VueRouter;

const apiUrl = 'http://localhost:8080';

const routes = [
    { path: '/', component: Home },
    { path: '/artikel', component: Artikel },
    { path: '/about', component: About }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

const app = createApp({});
app.use(router);
app.mount('#app');
```

---

### Langkah 7 - Memodifikasi index.html

File `index.html` diubah menggunakan `<router-link>` untuk navigasi dan `<router-view>` sebagai area konten dinamis:

```html
<div id="app">
    <header>
        <h1>Aplikasi Panel Single Page (SPA)</h1>
        <nav class="nav-menu">
            <router-link to="/">Beranda</router-link> | 
            <router-link to="/artikel">Kelola Artikel</router-link> |
            <router-link to="/about">About</router-link>
        </nav>
    </header>
    <main style="margin-top: 20px;">
        <router-view></router-view>
    </main>
</div>
```

---

### Langkah 8 - Menambahkan CSS Navigasi

Tambahkan style navigasi di `assets/css/style.css`:

```css
.nav-menu {
    padding: 10px;
    background: #eff1ff;
    border-radius: 5px;
    margin-bottom: 15px;
}
.nav-menu a {
    text-decoration: none;
    color: #3152d6;
    font-weight: bold;
    padding: 5px 10px;
}
.router-link-exact-active {
    background-color: #3152d6;
    color: #ffffff !important;
    border-radius: 3px;
}
.home-container {
    padding: 20px;
    border: 1px solid #eff1ff;
    background: #fafafa;
}
```

---

## Screenshot

### Halaman Beranda
> Screenshot halaman Beranda (localhost/lab8_vuejs/#/)

### Halaman Kelola Artikel
> Screenshot halaman Kelola Artikel dengan data artikel dari API

### Halaman About
> Screenshot halaman About dengan foto dan profil mahasiswa

---

## Pengujian SPA

Pengujian dilakukan dengan berpindah antar halaman (Beranda → Kelola Artikel → About) dan memastikan browser **tidak melakukan hard-reload** saat navigasi. Terbukti URL berubah dari `/#/` ke `/#/artikel` ke `/#/about` tanpa refresh halaman.

---

## Link Repository

[https://github.com/amelianurmala/Lab7Web.](https://github.com/amelianurmala/Lab7Web.)  
Branch: **master / main**
