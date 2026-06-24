<?= $this->include('template/header'); ?>

<h1>Daftar Artikel</h1>
<hr>

<?php if ($artikel): foreach ($artikel as $row): ?>
<article class="entry" style="display: flex; gap: 20px; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid var(--border); align-items: flex-start;">
    
    <!-- Gambar -->
    <div style="flex-shrink: 0;">
        <?php if (!empty($row['gambar'])): ?>
            <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" 
                 alt="<?= $row['judul']; ?>" 
                 style="width: 150px; height: 110px; object-fit: cover; border-radius: 8px;">
        <?php else: ?>
            <div style="width: 150px; height: 110px; background: var(--border); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <span style="color: var(--text-light); font-size: 12px;">No Image</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Konten -->
    <div style="flex: 1;">
        <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
        <p style="font-size: 13px; color: var(--text-light); margin-bottom: 8px;">
            Kategori: <b style="color: var(--primary);"><?= $row['nama_kategori']; ?></b>
        </p>
        <p><?= substr($row['isi'], 0, 150); ?>...</p>
    </div>

</article>
<?php endforeach; else: ?>
<article class="entry">
    <h2>Belum ada data.</h2>
</article>
<?php endif; ?>

<?= $this->include('template/footer'); ?>