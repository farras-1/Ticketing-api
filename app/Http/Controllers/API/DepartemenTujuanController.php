<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DepartemenTujuan;
use Illuminate\Http\Request;

class DepartemenTujuanController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => DepartemenTujuan::all()]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama_departemen' => 'required|string|unique:departemen_tujuans']);
        $departemen = DepartemenTujuan::create($request->all());
        return response()->json(['status' => 'success', 'message' => 'Departemen berhasil ditambahkan', 'data' => $departemen], 201);
    }

    public function destroy($id)
    {
        DepartemenTujuan::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Departemen berhasil dihapus']);
    }
}