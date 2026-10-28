<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::withCount('members')
            ->latest()
            ->get();

        $totalTim = $teams->count();
        $totalAnggota = $teams->sum('members_count');

        return view('teams.index', compact(
            'teams',
            'totalTim',
            'totalAnggota'
        ));
    }

    
public function create()
{
    return view('teams.create');
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama tim wajib diisi.',
            'name.max' => 'Nama tim maksimal 100 karakter.',
        ]);

        // Gunakan pengguna yang sedang login.
        // Jika belum login, gunakan pengguna pertama di tabel users.
        $ownerId = auth()->id() ?? User::query()->value('id');

        if (!$ownerId) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Tim tidak dapat dibuat karena belum ada pengguna di tabel users.',
                ]);
        }

        $validated['owner_id'] = $ownerId;

        Team::create($validated);

        return redirect()
            ->route('teams.index')
            ->with('success', 'Tim berhasil dibuat.');
    }
}
