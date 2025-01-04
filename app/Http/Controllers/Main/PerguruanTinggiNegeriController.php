<?php

namespace App\Http\Controllers\Main;

use App\Models\PerguruanTinggiNegeri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerguruanTinggiNegeriController extends Controller
{
    public function index(Request $request)
    {
        $query = PerguruanTinggiNegeri::query();
    
        if ($request->has('search')) {
            $query->where('kode_pt', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pt', 'like', '%' . $request->search . '%');
        }
    
        // Mengambil semua data tanpa pagination
        $perguruantingginegeri = $query->get();
    
        return view('ptn.index', compact('perguruantingginegeri'));
    }
    

    public function create()
    {
        return view('ptn.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pt' => 'required|unique:ptn,kode_pt',
            'nama_pt' => 'required',
        ]);
    
        PerguruanTinggiNegeri::create([
            'kode_pt' => $request->kode_pt,
            'nama_pt' => $request->nama_pt,
        ]);
    
        return redirect()->route('ptn.index')->with('success', 'Perguruan Tinggi Negeri Berhasil Ditambahkan');
    }
    

    public function edit($uuid)
    {
        $perguruantingginegeri = PerguruanTinggiNegeri::where('uuid', $uuid)->firstOrFail();
        return view('ptn.edit', compact('perguruantingginegeri'));
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'kode_pt' => 'required',
            'nama_pt' => 'required',
        ]);
    
        $perguruantingginegeri = PerguruanTinggiNegeri::where('uuid', $uuid)->firstOrFail();
        $perguruantingginegeri->update([
            'kode_pt' => $request->kode_pt,
            'nama_pt' => $request->nama_pt,
        ]);
    
        return redirect()->route('ptn.index')->with('success', 'Data berhasil diperbarui');
    }
    
    public function destroy($uuid)
    {
        $perguruantingginegeri = PerguruanTinggiNegeri::where('uuid', $uuid)->firstOrFail();
        $perguruantingginegeri->delete();

        return redirect()->route('ptn.index')->with('success', 'Data berhasil dihapus');
    }
}