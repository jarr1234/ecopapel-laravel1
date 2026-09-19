<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (session('usuario')) {
            return session('rol') === 'admin'
                ? redirect()->route('admin')
                : redirect()->route('productos');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $datos = $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = DB::table('usuarios')
            ->where('usuario', $datos['usuario'])
            ->first();

        if (!$usuario) {
            return back()
                ->withInput($request->only('usuario'))
                ->with('error', 'Usuario no encontrado.');
        }

        if (isset($usuario->verificado) && !$usuario->verificado) {
            return back()
                ->withInput($request->only('usuario'))
                ->with('error', 'Debes verificar tu cuenta.');
        }

        if (!Hash::check($datos['password'], $usuario->password)) {
            return back()
                ->withInput($request->only('usuario'))
                ->with('error', 'Contraseña incorrecta.');
        }

        $request->session()->regenerate();

        $request->session()->put([
            'id' => $usuario->id,
            'usuario' => $usuario->usuario,
            'rol' => $usuario->rol,
        ]);

        if ($usuario->rol === 'admin') {
            return redirect()->route('admin');
        }

        return redirect()->route('productos');
    }

    public function registroForm()
    {
        if (session('usuario')) {
            return redirect()->route('productos');
        }

        return view('registro');
    }

    public function registro(Request $request)
    {
        $datos = $request->validate([
            'usuario' => 'required|string|max:100',
            'password' => 'required|string|min:6',
            'telefono' => 'required|string|max:20',
        ]);

        $existeUsuario = DB::table('usuarios')
            ->where('usuario', $datos['usuario'])
            ->exists();

        if ($existeUsuario) {
            return back()
                ->withInput()
                ->with('error', 'El usuario ya existe.');
        }

        $codigo = random_int(100000, 999999);

        DB::table('usuarios')->insert([
            'usuario' => $datos['usuario'],
            'password' => Hash::make($datos['password']),
            'telefono' => $datos['telefono'],
            'codigo' => $codigo,
            'verificado' => 0,
            'rol' => 'cliente',
        ]);

        return redirect()
            ->route('verificar', [
                'usuario' => $datos['usuario'],
            ])
            ->with('codigo', $codigo);
    }

    public function verificarForm(Request $request)
    {
        if (!$request->usuario) {
            return redirect()->route('registro');
        }

        $usuario = DB::table('usuarios')
            ->where('usuario', $request->usuario)
            ->first();

        if (!$usuario) {
            return redirect()
                ->route('registro')
                ->with('error', 'Usuario no encontrado.');
        }

        if ($usuario->verificado) {
            return redirect()
                ->route('login')
                ->with('ok', 'La cuenta ya está verificada.');
        }

        return view('verificar', [
            'usuario' => $usuario->usuario,
        ]);
    }

    public function verificar(Request $request)
    {
        $datos = $request->validate([
            'usuario' => 'required|string',
            'codigo' => 'required|digits:6',
        ]);

        $usuario = DB::table('usuarios')
            ->where('usuario', $datos['usuario'])
            ->first();

        if (!$usuario) {
            return redirect()
                ->route('registro')
                ->with('error', 'Usuario no encontrado.');
        }

        if ((string) $usuario->codigo !== (string) $datos['codigo']) {
            return back()
                ->withInput()
                ->with('error', 'Código incorrecto.');
        }

        DB::table('usuarios')
            ->where('id', $usuario->id)
            ->update([
                'verificado' => 1,
                'codigo' => null,
            ]);

        return redirect()
            ->route('login')
            ->with('ok', 'Cuenta verificada correctamente.');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
