<?php

namespace App\Http\Controllers\Main;

use App\Notifications\LaporanNotification;
use App\Http\Controllers\Controller;
use App\Models\PerguruanTinggiSwasta;
use App\Models\LaporanPTS;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanSwastaController extends Controller
{
    public function index()
    {
        $laporan_list = PerguruanTinggiSwasta::all();
        return view('laporan-pts.index', compact('laporan_list'));
    }

    public function create($uuid)
    {
        try {
            $pts = PerguruanTinggiSwasta::where('uuid', $uuid)->firstOrFail();
    
            // Mengambil nilai pokja yang unik dari tabel users, 
            // kecuali "Admin SI-JAKI"
            $pokjaList = User::pluck('pokja')->unique()->reject(function ($pokja) {
                return $pokja == 'Admin SI-JAKI';  // Filter pokja yang tidak ingin ditampilkan
            })->toArray();
    
            return view('laporan-pts.create', compact('pts', 'pokjaList'));
        } catch (\Exception $e) {
            return redirect()->route('laporan-pts.index')
                ->with('error', 'Perguruan Tinggi Swasta Tidak Ditemukan.');
        }
    }    

    public function store(Request $request)
    {
        // Memeriksa apakah user yang login adalah ADIA
        $isAdia = Auth::user()->name === 'ADIA';

        $request->validate([
            'pts_id' => 'required|exists:pts,id',
            'tanggal_kegiatan' => 'required|date',
            'tempat_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|in:Rapat/Audiensi,Visitasi,Monitoring & Evaluasi,Aduan/Laporan,Teguran/Sanksi',
            // Validasi dokumen notula untuk user selain ADIA
            'dokumen_notula' => $isAdia ? 'nullable|file|mimes:pdf|max:2048' : 'required|file|mimes:pdf|max:2048',
            'dokumen_undangan' => 'required|file|mimes:pdf|max:2048',
            'resume' => 'required|string|max:500',
            'createdbyuser' => 'required|string|max:255',
            // Validasi checkbox pokja jika ada
            'pokja' => 'required|array|min:1',
            'pokja.*' => 'exists:users,pokja',
        ], [
            'pts_id.required' => 'ID Perguruan Tinggi diperlukan.',
            'pts_id.exists' => 'Perguruan Tinggi tidak valid.',
            'tanggal_kegiatan.required' => 'Tanggal kegiatan harus diisi.',
            'tanggal_kegiatan.date' => 'Format tanggal tidak valid.',
            'tempat_kegiatan.required' => 'Tempat kegiatan harus diisi.',
            'tempat_kegiatan.max' => 'Tempat kegiatan maksimal 255 karakter.',
            'jenis_kegiatan.required' => 'Jenis kegiatan harus dipilih.',
            'jenis_kegiatan.in' => 'Jenis kegiatan tidak valid.',
            'dokumen_notula.required' => 'Dokumen notula harus diunggah.',
            'dokumen_notula.mimes' => 'Dokumen notula harus berformat PDF.',
            'dokumen_notula.max' => 'Ukuran dokumen notula maksimal 2MB.',
            'dokumen_undangan.required' => 'Dokumen undangan harus diunggah.',
            'dokumen_undangan.mimes' => 'Dokumen undangan harus berformat PDF.',
            'dokumen_undangan.max' => 'Ukuran dokumen undangan maksimal 2MB.',
            'resume.required' => 'Ringkasan harus diisi.',
            'resume.max' => 'Ringkasan maksimal 500 karakter.',
            'createdbyuser.required' => 'Nama pembuat harus diisi.',
            'createdbyuser.max' => 'Nama pembuat maksimal 255 karakter.',
        ]);
    
        // Pengecekan file dokumen_notula ada atau tidak
        if ($request->hasFile('dokumen_notula')) {
            try {
                // Jika ada file, simpan ke storage
                $notula_path = $request->file('dokumen_notula')->store('notula', 'public');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah dokumen notula: ' . $e->getMessage());
            }
        } else {
            // Jika ADIA tidak meng-upload, biarkan null
            $notula_path = $isAdia ? null : null; // Tetap pastikan ini tidak null jika perlu
        }

        // Pengecekan file dokumen_undangan
        if ($request->hasFile('dokumen_undangan')) {
            try {
                $undangan_path = $request->file('dokumen_undangan')->store('undangan', 'public');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah dokumen undangan: ' . $e->getMessage());
            }
        }

        try {
            $laporan = new LaporanPTS();
            $laporan->pts_id = $request->pts_id;
            $laporan->user_id = Auth::id();
            $laporan->tanggal_kegiatan = $request->tanggal_kegiatan;
            $laporan->tempat_kegiatan = $request->tempat_kegiatan;
            $laporan->jenis_kegiatan = $request->jenis_kegiatan;
            $laporan->dokumen_notula = $notula_path;
            $laporan->dokumen_undangan = $undangan_path;
            $laporan->resume = $request->resume;
            $laporan->status = 'final';
            $laporan->createdbyuser = $request->createdbyuser;

            // Menyimpan data pokja yang dipilih, menggunakan titik koma sebagai pemisah
            if ($request->has('pokja')) {
                $laporan->pokja = implode(';', $request->pokja); // Menggunakan titik koma sebagai pemisah
            }

            $laporan->save();

            $data = [
                'title' => 'Laporan Baru Dibuat',
                'message' => 'Laporan baru telah ditambahkan oleh ' . Auth::user()->name,
                'url' => route('laporan-pts.show', $laporan->pts->uuid), // Pastikan ini menggunakan UUID
            ];
            Auth::user()->notify(new LaporanNotification($data));            

            return redirect()->route('laporan-pts.index')
                ->with('success', 'Kegiatan berhasil ditambahkan!');
        } catch (\Exception $e) {
            if (isset($notula_path)) Storage::disk('public')->delete($notula_path);
            if (isset($undangan_path)) Storage::disk('public')->delete($undangan_path);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    public function show(Request $request, $uuid)
    {
        $pts = PerguruanTinggiSwasta::where('uuid', $uuid)->firstOrFail();

        $laporan = LaporanPTS::where('pts_id', $pts->id);

        if ($request->filled('jenis_kegiatan')) {
            $laporan->where('jenis_kegiatan', $request->jenis_kegiatan);
        }

        if ($request->filled('filter_year')) {
            $laporan->whereYear('tanggal_kegiatan', $request->filter_year);
        }

        if ($request->filled('filter_month')) {
            $laporan->whereMonth('tanggal_kegiatan', $request->filter_month);
        }

        if ($request->filled('filter_pokja')) {
            $laporan->where('pokja', 'LIKE', '%' . $request->filter_pokja . '%');
        }

        // Ambil daftar pokja yang unik
        $pokjaList = User::distinct('pokja')->pluck('pokja')->reject(function ($pokja) {
            return $pokja == 'Admin SI-JAKI';  // Filter pokja yang tidak ingin ditampilkan
        })->values()->toArray();      

        $laporan = $laporan->get()->map(function ($item) {
            $item->canEdit = Auth::user()->akses === 'Admin' ||
                (Auth::id() === $item->user_id &&
                    $item->created_at->greaterThanOrEqualTo(Carbon::now()->subDays(3)));
            return $item;
        });

        return view('laporan-pts.show', compact('pts', 'laporan', 'pokjaList'));
    }

    public function edit($uuid)
    {
        $laporan = LaporanPTS::where('uuid', $uuid)->firstOrFail();
    
        $pts = PerguruanTinggiSwasta::findOrFail($laporan->pts_id);
    
        $pokjaList = User::pluck('pokja')->unique()->reject(function ($pokja) {
            return $pokja == 'Admin SI-JAKI';  // Filter pokja yang tidak ingin ditampilkan
        })->toArray();
    
        // Memecah string pokja menjadi array
        $selectedPokja = explode(';', $laporan->pokja);
    
        return view('laporan-pts.edit', compact('laporan', 'pts', 'pokjaList', 'selectedPokja'));
    }    

    public function update(Request $request, $uuid)
    {
        // Validasi data
        $request->validate([
            'tanggal_kegiatan' => 'required|date',
            'tempat_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|in:Rapat/Audiensi,Visitasi,Monitoring & Evaluasi,Aduan/Laporan,Teguran/Sanksi',
            'dokumen_notula' => 'nullable|file|mimes:pdf|max:2048',
            'dokumen_undangan' => 'nullable|file|mimes:pdf|max:2048',
            'resume' => 'required|string|max:500',
            'pokja' => 'required|array|min:1',  // Pastikan array pokja diisi
            'pokja.*' => 'exists:users,pokja',
        ]);
    
        // Cari laporan berdasarkan UUID
        $laporan = LaporanPTS::where('uuid', $uuid)->firstOrFail();
    
        // Update kolom lainnya
        $laporan->tanggal_kegiatan = $request->tanggal_kegiatan;
        $laporan->tempat_kegiatan = $request->tempat_kegiatan;
        $laporan->jenis_kegiatan = $request->jenis_kegiatan;
        $laporan->resume = $request->resume;
    
        // Jika ada dokumen yang diupload, update file dokumen
        if ($request->hasFile('dokumen_notula')) {
            if (!empty($laporan->dokumen_notula) && Storage::disk('public')->exists($laporan->dokumen_notula)) {
                Storage::disk('public')->delete($laporan->dokumen_notula);
            }
            $laporan->dokumen_notula = $request->file('dokumen_notula')->store('notula', 'public');
        }
    
        if ($request->hasFile('dokumen_undangan')) {
            if (!empty($laporan->dokumen_undangan) && Storage::disk('public')->exists($laporan->dokumen_undangan)) {
                Storage::disk('public')->delete($laporan->dokumen_undangan);
            }
            $laporan->dokumen_undangan = $request->file('dokumen_undangan')->store('undangan', 'public');
        }
    
        // Simpan data pokja yang dipilih
        $laporan->pokja = implode(';', $request->pokja);  // Menyimpan pokja sebagai string yang dipisahkan dengan titik koma
    
        // Simpan laporan
        if ($laporan->save()) {
            // Kirim notifikasi setelah update
            $data = [
                'title' => 'Laporan Diperbarui',
                'message' => 'Laporan telah diperbarui oleh ' . Auth::user()->name,
                'url' => route('laporan-pts.show', $laporan->pts->uuid),
            ];
            Auth::user()->notify(new LaporanNotification($data));
    
            return redirect()->route('laporan-pts.show', $laporan->pts->uuid)
                ->with('success', 'Kegiatan berhasil diperbarui!');
        }
    
        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan perubahan. Silakan coba lagi.');
    }       

    public function destroy($uuid)
    {
        try {
            $laporan = LaporanPTS::where('uuid', $uuid)->firstOrFail();
    
            // Hapus dokumen_notula jika ada
            if ($laporan->dokumen_notula && Storage::disk('public')->exists($laporan->dokumen_notula)) {
                Storage::disk('public')->delete($laporan->dokumen_notula);
            }
    
            // Hapus dokumen_undangan jika ada
            if ($laporan->dokumen_undangan && Storage::disk('public')->exists($laporan->dokumen_undangan)) {
                Storage::disk('public')->delete($laporan->dokumen_undangan);
            }
    
            $laporan->delete();
    
            return redirect()->route('laporan-pts.index')
                ->with('success', 'Kegiatan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus kegiatan. Silakan coba lagi.');
        }
    }    

    public function printToPdf(Request $request, $uuid)
    {
        $pts = PerguruanTinggiSwasta::where('uuid', $uuid)->firstOrFail();
        $laporan = LaporanPTS::where('pts_id', $pts->id);
    
        // Terapkan filter berdasarkan permintaan (jika ada)
        if ($request->filled('jenis_kegiatan')) {
            $laporan->where('jenis_kegiatan', $request->jenis_kegiatan);
        }
        if ($request->filled('filter_year')) {
            $laporan->whereYear('tanggal_kegiatan', $request->filter_year);
        }
        if ($request->filled('filter_month')) {
            $laporan->whereMonth('tanggal_kegiatan', $request->filter_month);
        }

        if ($request->filled('filter_pokja')) {
            $laporan->where('pokja', 'LIKE', '%' . $request->filter_pokja . '%');
        }
        
        $laporan = $laporan->get();
    
        // Muat tampilan PDF dengan data yang sesuai
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan-pts.pdf', compact('pts', 'laporan'))
            ->setPaper('a4', 'portrait');
    
        return $pdf->download('Timeline_Kegiatan_' . $pts->nama_pt . '.pdf');
    }    
}
