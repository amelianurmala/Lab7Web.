<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $title; ?></title>
<link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body>
<div id="container">
<header>
<h1>Portal Berita</h1>
<p>Modul Praktikum Pemrograman Web 2</p>
<p>Amelia Nurmala Dewi - Universitas Pelita Bangsa</p>
</header>

<nav>
<a href="<?= base_url('/');?>">Home</a>
<a href="<?= base_url('/artikel');?>" class="active">Artikel</a>
<a href="<?= base_url('/about');?>">About</a>
<a href="<?= base_url('/contact');?>">Kontak</a>
</nav>

<section id="wrapper">
<section id="main">