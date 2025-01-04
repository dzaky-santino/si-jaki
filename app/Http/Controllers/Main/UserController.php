<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->has('search')) {
            $query->where('pokja', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
    
        $result = $query->get()->map(function ($user) {
            if ($user->last_login) {
                $user->last_login = $user->last_login->timezone('Asia/Jakarta');
            }
            return $user;
        });
    
        return view('user.index', compact('result'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                // 'email' => 'required|string|email|max:255|unique:users',
                'pokja' => 'required|string|max:255',
                'akses' => 'required|in:Admin,User',
                'password' => 'required|min:6|confirmed',
            ]);

            $userData = $request->except('password_confirmation');
            $userData['password'] = Hash::make($request->password);

            User::create($userData);

            return redirect()->route('user.index')
                ->with('success', 'Data user berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data user. ' . $e->getMessage());
        }
    }

    public function edit($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $uuid)
    {
        try {
            $user = User::where('uuid', $uuid)->firstOrFail();

            $request->validate([
                'name' => 'required|string|max:255',
                // 'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'pokja' => 'required|string|max:255',
                'akses' => 'required|in:Admin,User',
                'password' => 'nullable|min:6',
            ]);

            $userData = $request->except('password');
            
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            return redirect()->route('user.index')
                ->with('success', 'Data user berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data user. ' . $e->getMessage());
        }
    }

    public function destroy($uuid)
    {
        try {
            $user = User::where('uuid', $uuid)->firstOrFail();
            $user->delete();
            return redirect()->route('user.index')
                ->with('success', 'Data user berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data user. ' . $e->getMessage());
        }
    }
}