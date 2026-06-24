<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table thead tr {
            background: var(--primary);
            color: var(--white);
        }

        .table tfoot tr {
            background: var(--primary);
            color: var(--white);
        }

        .table th, .table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .table tbody tr:nth-child(even) {
            background: var(--sidebar-bg);
        }

        .table tbody tr:hover {
            background: #eff6ff;
        }

        .btn {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            background: var(--primary);
            color: var(--white);
            transition: background 0.2s;
            margin-right: 4px;
        }

        .btn:hover {
            background: var(--primary-dark);
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        #wrapper {
            display: block !important;
        }

        #main {
            width: 100% !important;
            border-right: none !important;
        }

        .table {
            width: 100% !important;
        }

            nav {
        display: flex;
        align-items: center;
        }


        .pagination {
            display: flex;
            flex-direction: row;
            list-style: none;
            gap: 5px;
            margin-top: 15px;
            padding: 0;
        }

        .pagination li a, .pagination li span {
            display: inline-block;
            padding: 6px 12px;
            border: 1px solid var(--primary);
            border-radius: 6px;
            text-decoration: none;
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
        }

        .pagination li.active span {
            background: var(--primary);
            color: var(--white);
        }

        .pagination li a:hover {
            background: var(--primary);
            color: var(--white);
        }

    </style>
</head>
<body>
    <div id="container">
        <header>
            <div class="header-inner">
                <h1>Admin Portal Berita</h1>
                <div class="header-info">
                    <p>Modul Praktikum Pemrograman Web 2</p>
                    <p>Universitas Pelita Bangsa, Bekasi</p>
                </div>
            </div>
        </header>
        <nav>
            <a href="<?= base_url('/admin/artikel');?>">Dashboard</a>
            <a href="<?= base_url('/admin/artikel');?>">Artikel</a>
            <a href="<?= base_url('/admin/artikel/add');?>">Tambah Artikel</a>
            <a href="<?= base_url('/user/logout');?>" 
            onclick="return confirm('Yakin ingin logout?');"
            style="margin-left: auto; color: #f87171;">Logout</a>
        </nav>
        <section id="wrapper">
            <section id="main">