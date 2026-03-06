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

### Langkah 1 - Instalasi Berhasil, Halaman Welcome CodeIgniter 4 Tampil

<img width="1366" height="768" alt="Screenshot (1751)" src="https://github.com/user-attachments/assets/7eb3a7a9-ae0e-405e-8bcf-e1dd1bf4ad0b" />

Setelah instalasi selesai dan Apache dijalankan, browser diarahkan ke `http://localhost/lab11_ci/ci4/public/`. Halaman default CodeIgniter 4 berhasil tampil dengan judul **"Welcome to CodeIgniter 4.7.0"** beserta keterangan bahwa:
- View utama berada di `app/Views/welcome_message.php`
- Controller utama berada di `app/Controllers/Home.php`

Tampilnya halaman ini membuktikan bahwa instalasi CodeIgniter 4 telah berhasil dilakukan.

---

### Langkah 2 - Menjalankan CLI (Command Line Interface)

<img width="1366" height="768" alt="Screenshot (1755)" src="https://github.com/user-attachments/assets/7ce01d22-957e-4363-a654-1929981fbccf" />

CodeIgniter 4 menyediakan tools CLI bernama **Spark** untuk mempermudah proses development. Untuk mengaksesnya, buka terminal XAMPP Shell dan arahkan ke direktori project:

```bash
cd htdocs\lab11_ci\ci4
php spark
```

Output yang muncul menampilkan daftar perintah yang tersedia, dikelompokkan berdasarkan kategori seperti **Cache**, **Generators** (make:controller, make:model, dll.), **Database**, **Housekeeping**, dan lain-lain. Perintah-perintah ini sangat berguna untuk mempercepat proses pengembangan aplikasi.

---

### Langkah 3 - Mengaktifkan Mode Debugging (Muncul Error Whoops!)

<img width="1365" height="714" alt="Screenshot 2026-03-01 061016" src="https://github.com/user-attachments/assets/c520912c-3501-4a16-b79e-8c7c509873c4" />

Secara default, mode debugging pada CodeIgniter 4 belum aktif. Ketika terjadi error pada aplikasi, yang tampil hanyalah halaman **"Whoops! We seem to have hit a snag. Please try again later..."** tanpa informasi detail tentang error yang terjadi.

Untuk mengaktifkan mode debugging, ubah nama file `env` menjadi `.env` di root direktori project, kemudian buka file tersebut dan ubah nilai variabel berikut:

```
CI_ENVIRONMENT = development
```

Dengan mengaktifkan mode development, detail error akan ditampilkan secara lengkap sehingga memudahkan proses debugging.

---

### Langkah 4 - ParseError Terdeteksi Setelah Mode Debugging Aktif

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

### Langkah 5 - Membuat Route Baru dan Mengecek dengan Spark Routes

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

### Langkah 6 - Error 404 Karena Controller Page Belum Dibuat

<img width="1365" height="718" alt="Screenshot 2026-03-01 065150" src="https://github.com/user-attachments/assets/434db20c-e863-4e42-aafd-232992e4efca" />

Ketika mencoba mengakses `http://localhost/lab11_ci/ci4/public/about`, muncul error **404 - Page Not Found** dengan pesan:

```
Controller or its method is not found: \App\Controllers\Page::about
```

Error ini terjadi karena meskipun route sudah didefinisikan, file **Controller Page** (`app/Controllers/Page.php`) belum dibuat. Route sudah mengarah ke controller yang belum ada, sehingga CodeIgniter mengembalikan error 404.

---

### Langkah 7 - Membuat Controller Page

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

### Langkah 8 - Auto Routing (Halaman Term of Services)

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

### Langkah 9 - Membuat View untuk Halaman About

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

### Langkah 10 - Membuat Layout dengan Template Header dan Footer

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

### Langkah 11 - Tampilan Final dengan CSS Styling

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
