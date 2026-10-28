<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyekController extends Controller
{
    public function index()
    {
        $proyek = Proyek::orderByDesc('id_proyek')->get();

        return view('admin.proyek.index', compact('proyek'));
    }

    public function create()
    {
        return view('admin.proyek.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_proyek' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        Proyek::create([
            'nama_proyek' => $validated['nama_proyek'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'id_pembuat' => auth()->user()->id_pengguna,
        ]);

        return redirect()
            ->route('admin.proyek.index')
            ->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function show(Proyek $proyek)
    {
        $jumlahTim = DB::table('project_teams')
            ->where('id_proyek', $proyek->id_proyek)
            ->count();

        $jumlahAnggota = DB::table('anggota_proyek')
            ->where('id_proyek', $proyek->id_proyek)
            ->count();

        return view('admin.proyek.show', compact(
            'proyek',
            'jumlahTim',
            'jumlahAnggota'
        ));
    }
}
