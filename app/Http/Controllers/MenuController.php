<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori dari klik tombol (misal: ?category=Bakso)
        $category = $request->get('category');

        // Jika ada kategori yang dipilih, saring datanya
        if ($category) {
            $menus = Menu::where('kategori', $category)->get();
        } else {
            // Jika tidak ada filter, tampilkan semua
            $menus = Menu::all();
        }

        // Ambil daftar kategori unik untuk tombol-tombol filternya
        $categories = Menu::select('kategori')->distinct()->get();

        return view('menu.index', compact('menus', 'categories'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:100',
            'kategori'  => 'required|string|max:50',
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tambahkan validasi gambar
        ]);

        // Gunakan $validated sebagai dasar data
        $data = $validated;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $nama_gambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/menu'), $nama_gambar);
            
            // Masukkan nama gambar ke dalam array $data
            $data['gambar'] = $nama_gambar;
        }

        // SIMPAN MENGGUNAKAN $data, BUKAN $validated
        Menu::create($data);

        return redirect('/menu')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'nama_menu' => 'required|string|max:100',
            'kategori'  => 'required|string|max:50',
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada agar folder tidak penuh sampah
            if ($menu->gambar) {
                $oldPath = public_path('images/menu/' . $menu->gambar);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('gambar');
            $nama_gambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/menu'), $nama_gambar);
            $data['gambar'] = $nama_gambar;
        }

        // UPDATE MENGGUNAKAN $data
        $menu->update($data);

        return redirect('/menu')->with('success', 'Menu berhasil diupdate');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

    // Cek apakah menu ini punya gambar
    if ($menu->gambar) {
        $path = public_path('images/menu/' . $menu->gambar);
        
        // Hapus file fisiknya dari folder public/images/menu
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    // Baru hapus datanya dari database
    $menu->delete();

    return redirect()->route('menu.index')->with('success', 'Menu dan fotonya berhasil dihapus!');
    }
}