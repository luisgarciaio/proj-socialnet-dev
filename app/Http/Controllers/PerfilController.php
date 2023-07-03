<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index()
    {
        return view('perfil.index');
    }
    public function store(Request $request)
    {
        $user = auth()->user(); // Obtén el usuario autenticado
    
        $request->validate([
            'username' => [
                'required', 'unique:users,username,' . $user->id, 'min:3', 'max:20',
                'not_in:twitter,editar-perfil'
            ],
            'email' => [
                'required', 'unique:users,email,' . $user->id, 'email', 'max:60',
            ],
            'oldPassword' => ['required', 'min:6'],
            'password' => ['nullable', 'confirmed', 'min:6'],
            'imagen' => ['nullable', 'image', 'max:5000'],
        ]);
    
        if (Hash::check($request->oldPassword, $user->password)) {
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = Str::uuid() . "." . $imagen->extension();
                $imagenServidor = Image::make($imagen);
                $imagenServidor->fit(1000, 1000);
                $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
                $imagenServidor->save($imagenPath);
    

            }

            $usuario = User::find(auth()->user()->id);
            if ($request->filled('password')) {
                $usuario->password = Hash::make($request->password);
            }
            $usuario->username = $request->username;
            $usuario->email = $request->email;
            $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? '';
            $usuario->save();
    
            return redirect()->route('posts.index', $usuario->username);
        } else {
            // La contraseña ingresada no coincide con la contraseña almacenada en la base de datos
            return back()->withErrors(['oldPassword' => 'La contraseña actual es incorrecta.']);
        }
    }
    
}
