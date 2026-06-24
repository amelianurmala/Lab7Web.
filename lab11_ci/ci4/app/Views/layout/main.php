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
                    <p>
                        Vestibulum lorem elit, iaculis in nisl volutpat,
                        malesuada tincidunt arcu. Proin in leo fringilla,
                        vestibulum mi porta,
                        faucibus felis. Integer pharetra est nunc, nec pretium
                        nunc pretium ac.
                    </p>
                </div>
            </aside>
        </section>

        <footer>
            <p>&copy; 2026 - Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>
</html>