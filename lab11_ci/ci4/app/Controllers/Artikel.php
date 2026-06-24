<?php
namespace App\Controllers;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function index()
    {
        $title   = 'Daftar Artikel';
        $model   = new ArtikelModel();
        $artikel = $model->getArtikelDenganKategori();

        return view('artikel/index', compact('artikel', 'title'));
    }

    public function view($slug)
    {
        $model   = new ArtikelModel();
        $artikel = $model->where('slug', $slug)->first();

        if (empty($artikel)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan.');
        }

        $data['artikel'] = $artikel;
        $data['title']   = $artikel['judul'];

        return view('artikel/detail', $data);
    }

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

        // Sorting
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

        $title = "Tambah Artikel";
        $data['kategori'] = $kategoriModel->findAll();
        $data['title']    = $title;
        return view('artikel/form_add', $data);
    }
    public function edit($id)
    {
        $model         = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        if ($this->request->getMethod() == 'post' && $this->validate([
            'judul'       => 'required',
            'id_kategori' => 'required|integer'
        ])) {
            $model->update($id, [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
            ]);
            return redirect()->to('/admin/artikel');
        }

        $data['artikel']  = $model->find($id);
        $data['kategori'] = $kategoriModel->findAll();
        $data['title']    = "Edit Artikel";
        return view('artikel/form_edit', $data);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        return redirect()->to('/admin/artikel');
    }
}