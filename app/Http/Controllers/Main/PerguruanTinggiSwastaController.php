<?php

namespace App\Http\Controllers\Main;

use App\Models\PerguruanTinggiSwasta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerguruanTinggiSwastaController extends Controller
{
    public function index(Request $request)
    {
        $query = PerguruanTinggiSwasta::query();
    
        if ($request->has('search')) {
            $query->where('kode_pt', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pt', 'like', '%' . $request->search . '%');
        }
    
        // Mengambil semua data tanpa pagination
        $perguruantinggiswasta = $query->get();
    
        return view('pts.index', compact('perguruantinggiswasta'));
    }

    public function create()
    {
        return view('pts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pt' => 'required|unique:pts,kode_pt',
            'nama_pt' => 'required',
        ]);
    
        PerguruanTinggiSwasta::create([
            'kode_pt' => $request->kode_pt,
            'nama_pt' => $request->nama_pt,
        ]);
    
        return redirect()->route('pts.index')->with('success', 'Perguruan Tinggi Swasta Berhasil Ditambahkan');
    }
    
    public function edit($uuid)
    {
        $perguruantinggiswasta = PerguruanTinggiSwasta::where('uuid', $uuid)->firstOrFail();
        return view('pts.edit', compact('perguruantinggiswasta'));
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'kode_pt' => 'required',
            'nama_pt' => 'required',
        ]);
    
        $perguruantinggiswasta = PerguruanTinggiSwasta::where('uuid', $uuid)->firstOrFail();
        $perguruantinggiswasta->update([
            'kode_pt' => $request->kode_pt,
            'nama_pt' => $request->nama_pt,
        ]);
    
        return redirect()->route('pts.index')->with('success', 'Data berhasil diperbarui');
    }
    
    public function destroy($uuid)
    {
        $perguruantinggiswasta = PerguruanTinggiSwasta::where('uuid', $uuid)->firstOrFail();
        $perguruantinggiswasta->delete();

        return redirect()->route('pts.index')->with('success', 'Data berhasil dihapus');
    }
}