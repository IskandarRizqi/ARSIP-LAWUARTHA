<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash; // Tambahkan ini di atas

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// use App\Http\Controllers\Storage;



class UserController extends Controller
{
    public function index()
    {   
        $data['users'] = User::get();
        return view('pages.user.index',$data);
    }

    public function create()
    {
        
        return view('pages.user.tambah');
       
    }

    public function store(Request $request)
    {
        // return $request->all();
      
        $validator = validator::make($request->all(), [

                
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',
            'role' => 'required',
            

            
        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput($request->all());
        }
        //   return $request->all();
        User::create([
            'id' => $request->idusers,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
    
         
        ]);
       

        
        return redirect('/menuuser')->with('success', 'Pengguna Berhasil Di tambahkan');
    }

    public function show(string $id)
    {
        
        $data['edit'] = User::where('id', $id)->first();
        return view('pages.user.edit', $data);
    }

    public function showprofile()
    {
        $data['user'] = Auth::user(); // Ambil data user yang sedang login
        return view('pages.profile.updateprofile', $data);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // Validasi input
        $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:0,1,2',
            'password' => 'nullable|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',
        ]);
    
        // Update data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
    
        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
    
        $user->save();
    
        return redirect()->route('menuuser.index')->with('success', 'Data Berhasil diperbarui!');
    }
    
    public function updateProfile(Request $request)
    {
        // return $request->all();
        $user = Auth::user(); // Ambil user yang sedang login
    
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Update data
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
    
        // Jika ada file gambar yang diunggah
        if ($request->hasFile('gambar')) {
            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('gambar_users', 'public');
    
            // Hapus gambar lama jika ada
            if ($user->gambar) {
                Storage::disk('public')->delete($user->gambar);
            }
    
            // Simpan path gambar baru
            $user->gambar = $gambarPath;
        }
    
        $user->save();
    
        return redirect()->route('profile.showprofile')->with('success', 'Profil berhasil diperbarui!');
    }
    
    

    
    public function destroy(string $id)
        {

            User::where('id', $id)->delete();
            return redirect('/menuuser')->with('success', 'Berhasil hapus data!');
        }
    

  
       

}
