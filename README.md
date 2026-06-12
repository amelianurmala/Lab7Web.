# Praktikum 12 - VueJS Komponen dan Routing (Single Page Application)

**Nama:** Amelia Nurmala Dewi  
**NIM:** 312410199  
**Kelas:** I241B  
**Mata Kuliah:** Pemrograman Web 2  

---

## Tujuan

1. Memahami konsep komponen pada Framework VueJS
2. Memahami konsep Client-Side Routing untuk membangun Single Page Application (SPA)
3. Mengimplementasikan komponen dan routing menggunakan Vue Router berbasis CDN

---

## Struktur Direktori

```
lab8_vuejs/
│   index.html
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

### Langkah 2 - Membuat Folder Components

Buat folder baru `components` di dalam `assets/js/` untuk menyimpan file komponen.

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

### Langkah 4 - Membuat Komponen Artikel.js

File `assets/js/components/Artikel.js` berisi seluruh logika CRUD artikel yang dipindahkan dari `app.js` lama, mencakup template tabel data, form modal, dan semua method (loadData, tambah, edit, hapus, saveData).

### Langkah 5 - Mengonfigurasi Vue Router di app.js

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

### Langkah 6 - Memodifikasi index.html

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

### Langkah 7 - Menambahkan CSS Navigasi

Tambahkan style navigasi di `assets/css/style.css`:

```css
.nav-menu { padding: 10px; background: #eff1ff; border-radius: 5px; }
.router-link-exact-active { background-color: #3152d6; color: #ffffff !important; }
.home-container { padding: 20px; border: 1px solid #eff1ff; background: #fafafa; }
```

---

## Tugas Tambahan - Halaman About

Membuat komponen `About.js` dengan rute `/about` yang menampilkan profil mahasiswa:

```javascript
const About = {
    template: `
    <div class="about-container">
        <h2>Profil Mahasiswa</h2>
        <div class="about-card">
            <div class="about-avatar">
                <img src="/lab8_vuejs/assets/foto.jpg" ...>
            </div>
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

## Hasil Screenshot

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
Branch: **master**
