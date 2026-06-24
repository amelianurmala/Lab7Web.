</section>
        <!-- SIDEBAR -->
        <aside id="sidebar">
            <div class="widget-box">
                <h3 class="title">Artikel Terkini</h3>
                <ul>
                    <?php
                    $model = new \App\Models\ArtikelModel();
                    $terkini = $model->orderBy('id', 'DESC')->limit(5)->find();
                    foreach ($terkini as $t): ?>
                        <li><a href="<?= base_url('/artikel/' . $t['slug']); ?>"><?= $t['judul']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="widget-box">
                <h3 class="title">Widget Header</h3>
                <ul>
                    <li><a href="#">Widget Link</a></li>
                    <li><a href="#">Widget Link</a></li>
                </ul>
            </div>

            <div class="widget-box">
                <h3 class="title">Widget Text</h3>
                <p>Vestibulum lorem elit, iaculis in nisi volutpat, malesuada tincidunt arcu.</p>
            </div>
        </aside>
        </section>
        <footer>
            <p>&copy; 2026 - Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>
</html>