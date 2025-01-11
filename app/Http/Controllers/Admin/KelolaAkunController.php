<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class KelolaAkunController extends Controller
{
    public function index()
    {
        $akun = User::latest()->get();

        return view('admin.akun.index', compact('akun'));
    }

    public function create()
    {
        return view('admin.akun.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
            'role' => 'required|in:admin,customer'
        ]);

        $validateData['password'] = Hash::make($validateData['password']);

        User::create($validateData);

        toast()->success('Berhasil', 'Akun Berhasil di Daftarkan');
        return redirect('/kelola-akun')->withInput();
    }

    public function edit(User $akun)
    {
        return view('admin.akun.edit', compact('akun'));
    }

    public function update(Request $request, User $akun)
    {
        try {
            $rules = [
                'username' => 'required|max:255',
                'email' => 'required|email|unique:users,email,' . $akun->id,
                'role' => 'required',
                'password' => 'nullable|min:5',
            ];

             // Validate request data
            $validateData = $request->validate($rules);

            if ($request->filled('password')) {
                $validateData['password'] = bcrypt($request->password);
            } else {
                // Remove password from validated data if it wasn't provided
                unset($validateData['password']);
            }

            // Update the rest of the data
            $akun->update($validateData);

            alert()->success('Berhasil', 'Akun berhasil diubah');
            return redirect('/kelola-akun')->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());

        }
    }

    public function destroy(User $akun)
    {
        User::destroy($akun->id);

        // Menampilkan notifikasi sukses dan redirect
        alert()->success('Success', 'Akun berhasil dihapus');
        return redirect('/kelola-akun')->withInput();
    }

}   
