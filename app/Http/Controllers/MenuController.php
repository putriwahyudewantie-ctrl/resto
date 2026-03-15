<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
$request->validate([
'nama_menu' => 'required',
'kategori' => 'required',
'harga' => 'required|numeric',
'jumlah' => 'required|numeric',
'deskripsi' => 'nullable'
]);

Menu::create([
'nama_menu' => $request->nama_menu,
'kategori' => $request->kategori,
'harga' => $request->harga,
'jumlah' => $request->jumlah,
'deskripsi' => $request->deskripsi
]);

return redirect('/menu')->with('success','Menu berhasil ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{

$request->validate([
'nama_menu' => 'required',
'kategori' => 'required',
'harga' => 'required|numeric',
'jumlah' => 'required|numeric',
'deskripsi' => 'nullable'
]);

$menu = Menu::findOrFail($id);

$menu->update([
'nama_menu' => $request->nama_menu,
'kategori' => $request->kategori,
'harga' => $request->harga,
'jumlah' => $request->jumlah,
'deskripsi' => $request->deskripsi
]);

return redirect('/menu')->with('success','Menu berhasil diupdate');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect('/menu')->with('success', 'Menu berhasil dihapus');
    }
}