<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<!-- Form Search -->
<form id="search-form" class="form-search" style="margin-bottom: 16px; display: flex; gap: 8px; align-items: center;">
    <input type="text" name="q" id="search-box" value="<?= $q; ?>" placeholder="Cari judul artikel">
    <select name="kategori_id" id="category-filter">
        <option value="">Semua Kategori</option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                <?= $k['nama_kategori']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Cari" class="btn btn-primary">
</form>

<!-- Sorting -->
<div style="margin-bottom: 16px; display: flex; gap: 8px; align-items: center;">
    <label>Urutkan:</label>
    <select id="sort-by">
        <option value="id">ID</option>
        <option value="judul">Judul</option>
        <option value="status">Status</option>
    </select>
    <select id="sort-order">
        <option value="asc">A - Z</option>
        <option value="desc">Z - A</option>
    </select>
    <button id="btnSort" class="btn">Urutkan</button>
</div>

<!-- Loading Indicator -->
<div id="loading" style="display:none; text-align:center; padding: 20px;">
    <div style="display:inline-block; width:35px; height:35px; border:4px solid #f3f3f3; border-top:4px solid #2563eb; border-radius:50%; animation:spin 0.8s linear infinite;"></div>
    <p style="margin-top: 8px; color: #64748b;">Memuat data...</p>
</div>

<!-- Container Artikel -->
<div id="article-container"></div>

<!-- Container Pagination -->
<div id="pagination-container"></div>

<style>
@keyframes spin {
    0%   { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    const articleContainer    = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const searchForm          = $('#search-form');
    const searchBox           = $('#search-box');
    const categoryFilter      = $('#category-filter');
    const loading             = $('#loading');

    // Fetch data dari server
    const fetchData = (url) => {
        loading.show();
        articleContainer.hide();
        paginationContainer.hide();

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(data) {
                loading.hide();
                articleContainer.show();
                paginationContainer.show();
                renderArticles(data.artikel);
                renderPagination(data.pager, data.q, data.kategori_id);
            },
            error: function() {
                loading.hide();
                articleContainer.html('<p style="color:red;">Gagal memuat data!</p>').show();
            }
        });
    };

    // Render tabel artikel
    const renderArticles = (articles) => {
        let html = '<table class="table">';
        html += '<thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead><tbody>';

        if (articles && articles.length > 0) {
            articles.forEach(article => {
                html += `
                <tr>
                    <td>${article.id}</td>
                    <td>
                        <b>${article.judul}</b>
                        <p><small>${article.isi.substring(0, 50)}</small></p>
                    </td>
                    <td>${article.nama_kategori}</td>
                    <td>${article.status}</td>
                    <td>
                        <a class="btn" href="/admin/artikel/edit/${article.id}">Ubah</a>
                        <a class="btn btn-danger" onclick="return confirm('Yakin menghapus data?');" href="/admin/artikel/delete/${article.id}">Hapus</a>
                    </td>
                </tr>`;
            });
        } else {
            html += '<tr><td colspan="5" style="text-align:center;">Tidak ada data.</td></tr>';
        }

        html += '</tbody></table>';
        articleContainer.html(html);
    };

    // Render pagination
    const renderPagination = (pager, q, kategori_id) => {
        if (!pager || !pager.links) return;
        let html = '<ul class="pagination">';
        pager.links.forEach(link => {
            let url = link.url ? `${link.url}&q=${q}&kategori_id=${kategori_id}` : '#';
            html += `<li class="${link.active ? 'active' : ''}"><a href="${url}">${link.title}</a></li>`;
        });
        html += '</ul>';
        paginationContainer.html(html);

        // Klik pagination pakai AJAX
        paginationContainer.find('a').on('click', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            if (href !== '#') fetchData(href);
        });
    };

    // Submit form search
    searchForm.on('submit', function(e) {
        e.preventDefault();
        const q           = searchBox.val();
        const kategori_id = categoryFilter.val();
        const sort        = $('#sort-by').val();
        const order       = $('#sort-order').val();
        fetchData(`/admin/artikel?q=${q}&kategori_id=${kategori_id}&sort=${sort}&order=${order}`);
    });

    // Filter kategori berubah
    categoryFilter.on('change', function() {
        searchForm.trigger('submit');
    });

    // Tombol sorting
    $('#btnSort').on('click', function() {
        searchForm.trigger('submit');
    });

    // Load awal
    fetchData('/admin/artikel');
});
</script>

<?= $this->include('template/admin_footer'); ?>