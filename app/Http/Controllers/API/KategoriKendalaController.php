<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KategoriKendala;
use Illuminate\Http\Request;

class KategoriKendalaController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => KategoriKendala::all()]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string|unique:kategori_kendalas']);
        $kategori = KategoriKendala::create($request->all());
        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil ditambahkan', 'data' => $kategori], 201);
    }

    public function destroy($id)
    {
        KategoriKendala::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil dihapus']);
    }
}