<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // Halaman "Anggota" = data akun petugas
    private function baseQuery()
    {
        return User::where('role', 'petugas');
    }

    public function index(Request $request)
    {
        $query = $this->baseQuery();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $total = $this->baseQuery()->count();

        return view('members.index', compact('users', 'total'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data['role']     = 'petugas';
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('members.index')->with('success', 'Akun petugas berhasil ditambahkan.');
    }

    public function show(User $member)
    {
        if ($member->role !== 'petugas') abort(403);
        return view('members.show', compact('member'));
    }

    public function edit(User $member)
    {
        if ($member->role !== 'petugas') abort(403);
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        if ($member->role !== 'petugas') abort(403);

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(User $member)
    {
        if ($member->role !== 'petugas') abort(403);
        if ($member->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $member->delete();
        return redirect()->route('members.index')->with('success', 'Akun petugas berhasil dihapus.');
    }
}
