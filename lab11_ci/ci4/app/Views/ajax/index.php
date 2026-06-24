<?= $this->include('template/admin_header'); ?>

<h2>Data Artikel (AJAX)</h2>

<!-- Notifikasi -->
<div id="notifikasi" style="display:none; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-weight: 600;"></div>

<!-- Form Tambah Artikel -->
<div style="margin-bottom: 20px; padding: 16px; background: #f1f5f9; border-radius: 8px;">
    <h3 style="margin-bottom: 12px;">Tambah Artikel</h3>
    <p>
        <input type="text" id="judulBaru" placeholder="Judul Artikel" style="width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
    </p>
    <p>
        <textarea id="isiBaru" placeholder="Isi Artikel" rows="3" style="width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 6px;"></textarea>
    </p>
    <button id="btnTambah" class="btn">Tambah</button>
</div>

<!-- Form Edit -->
<div id="modalEdit" style="display:none; margin-bottom: 20px; padding: 16px; background: #fff3cd; border-radius: 8px;">
    <h3 style="margin-bottom: 12px;">Edit Artikel</h3>
    <input type="hidden" id="editId">
    <p>
        <input type="text" id="editJudul" placeholder="Judul Artikel" style="width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
    </p>
    <p>
        <textarea id="editIsi" placeholder="Isi Artikel" rows="3" style="width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 6px;"></textarea>
    </p>
    <button id="btnSimpanEdit" class="btn">Simpan</button>
    <button id="btnBatalEdit" class="btn btn-danger">Batal</button>
</div>

<!-- Search -->
<div style="margin-bottom: 16px;">
    <input type="text" id="searchInput" placeholder="Cari artikel..." style="width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
    <button id="btnCari" class="btn">Cari</button>
    <button id="btnReset" class="btn" style="background: #64748b;">Reset</button>
</div>

<!-- Tabel Data -->
<table class="table" id="artikelTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="4" style="text-align:center;">
                <!-- Loading Spinner -->
                <div id="loadingSpinner" style="display:inline-block; width:30px; height:30px; border:4px solid #f3f3f3; border-top:4px solid #2563eb; border-radius:50%; animation:spin 0.8s linear infinite;"></div>
                <p>Memuat data...</p>
            </td>
        </tr>
    </tbody>
</table>

<!-- CSS Spinner -->
<style>
@keyframes spin {
    0%   { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
#notifikasi.sukses {
    background: #dcfce7;
    color: #16a34a;
    border: 1px solid #16a34a;
}
#notifikasi.gagal {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #dc2626;
}
</style>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script>
$(document).ready(function() {

    var allData = []; // Simpan semua data untuk filter

    // Fungsi tampil notifikasi
    function showNotif(pesan, tipe) {
        $('#notifikasi').removeClass('sukses gagal').addClass(tipe).html(pesan).show();
        setTimeout(function() {
            $('#notifikasi').fadeOut();
        }, 3000);
    }

    // Fungsi tampil loading spinner
    function showLoading() {
        $('#artikelTable tbody').html(
            '<tr><td colspan="4" style="text-align:center;">' +
            '<div style="display:inline-block; width:30px; height:30px; border:4px solid #f3f3f3; border-top:4px solid #2563eb; border-radius:50%; animation:spin 0.8s linear infinite;"></div>' +
            '<p>Memuat data...</p></td></tr>'
        );
    }

    // Fungsi render tabel
    function renderTable(data) {
        if (data.length == 0) {
            $('#artikelTable tbody').html('<tr><td colspan="4" style="text-align:center;">Tidak ada data ditemukan.</td></tr>');
            return;
        }
        var tableBody = "";
        for (var i = 0; i < data.length; i++) {
            var row = data[i];
            tableBody += '<tr>';
            tableBody += '<td>' + row.id + '</td>';
            tableBody += '<td>' + row.judul + '</td>';
            tableBody += '<td>' + row.status + '</td>';
            tableBody += '<td>';
            tableBody += '<a href="#" class="btn btn-edit" data-id="' + row.id + '" data-judul="' + row.judul + '" data-isi="' + row.isi + '">Edit</a> ';
            tableBody += '<a href="#" class="btn btn-danger btn-delete" data-id="' + row.id + '">Delete</a>';
            tableBody += '</td>';
            tableBody += '</tr>';
        }
        $('#artikelTable tbody').html(tableBody);
    }

    // Fungsi load data
    function loadData() {
        showLoading();
        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                allData = data;
                renderTable(data);
            },
            error: function() {
                showNotif('Gagal memuat data!', 'gagal');
            }
        });
    }

    loadData();

    // Search/Filter
    $('#btnCari').click(function() {
        var keyword = $('#searchInput').val().toLowerCase();
        var filtered = allData.filter(function(row) {
            return row.judul.toLowerCase().indexOf(keyword) !== -1;
        });
        renderTable(filtered);
    });

    // Reset search
    $('#btnReset').click(function() {
        $('#searchInput').val('');
        renderTable(allData);
    });

    // Search realtime saat mengetik
    $('#searchInput').on('keyup', function() {
        var keyword = $(this).val().toLowerCase();
        var filtered = allData.filter(function(row) {
            return row.judul.toLowerCase().indexOf(keyword) !== -1;
        });
        renderTable(filtered);
    });

    // Tambah artikel
    $('#btnTambah').click(function() {
        var judul = $('#judulBaru').val();
        var isi   = $('#isiBaru').val();
        if (judul == '') {
            showNotif('Judul tidak boleh kosong!', 'gagal');
            return;
        }
        $.ajax({
            url: "<?= base_url('ajax/save') ?>",
            method: "POST",
            data: { judul: judul, isi: isi },
            success: function(data) {
                if (data.status == 'OK') {
                    $('#judulBaru').val('');
                    $('#isiBaru').val('');
                    loadData();
                    showNotif('Artikel berhasil ditambahkan!', 'sukses');
                }
            },
            error: function() {
                showNotif('Gagal menambahkan artikel!', 'gagal');
            }
        });
    });

    // Tombol Edit
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var id    = $(this).data('id');
        var judul = $(this).data('judul');
        var isi   = $(this).data('isi');
        $('#editId').val(id);
        $('#editJudul').val(judul);
        $('#editIsi').val(isi);
        $('#modalEdit').show();
        $('html, body').animate({ scrollTop: $('#modalEdit').offset().top - 20 }, 300);
    });

    // Simpan Edit
    $('#btnSimpanEdit').click(function() {
        var id    = $('#editId').val();
        var judul = $('#editJudul').val();
        var isi   = $('#editIsi').val();
        $.ajax({
            url: "<?= base_url('ajax/update/') ?>" + id,
            method: "POST",
            data: { judul: judul, isi: isi },
            success: function(data) {
                if (data.status == 'OK') {
                    $('#modalEdit').hide();
                    loadData();
                    showNotif('Artikel berhasil diubah!', 'sukses');
                }
            },
            error: function() {
                showNotif('Gagal mengubah artikel!', 'gagal');
            }
        });
    });

    // Batal Edit
    $('#btnBatalEdit').click(function() {
        $('#modalEdit').hide();
    });

    // Delete
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Yakin ingin menghapus artikel ini?')) {
            $.ajax({
                url: "<?= base_url('ajax/delete/') ?>" + id,
                method: "POST",
                success: function(data) {
                    loadData();
                    showNotif('Artikel berhasil dihapus!', 'sukses');
                },
                error: function() {
                    showNotif('Gagal menghapus artikel!', 'gagal');
                }
            });
        }
    });

});
</script>

<?= $this->include('template/admin_footer'); ?>