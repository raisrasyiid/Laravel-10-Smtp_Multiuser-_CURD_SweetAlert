<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function index()
    {
        return view('halamanAuth.login');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'password Wajib Diisi',
        ]);

        $infoLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infoLogin)) {
            return 'Login successful';
        } else {
            redirect()->route('auth')->withErrors('Email or Password incorrect');
        }
    }

    function create()
    {
        return view('halamanAuth.register');
    }

    function register(Request $request)
    {
        $str = Str::random(100);
        $request->validate([
            'fullname' => 'required|min:5',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'gambar' => 'required|file|image',
        ], [
            'fullname.required' => 'fullname wajib diisi',
            'fullname.min' => 'fullname minimal 5 karakter',
            'email.required' => 'email wajib diisi',
            'email.unique' => 'email telah terdaftar',
            'password.required' => 'password wajib diisi',
            'password.min' => 'password minimal 5 karakter',
            'gambar.required' => 'gambar wajib diisi',
            'gambar.image' => 'gambar yang diupload berupa image',
            'gambar.file' => 'gambar harus berupa file',
        ]);

        $fileGambar = $request->file('gambar');
        $ekstensiGambar = $fileGambar->extension();
        $namaGambar = date('ymdhis') . "." . $ekstensiGambar;
        $fileGambar->move(public_path('picture/accounts'), $namaGambar);

        $infoRegister = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password,
            'gambar' => $namaGambar,
            'verify_key' => $str,
        ];

        User::create($infoRegister);
        $detail = [
            'name' => $infoRegister['fullname'],
            'role' => 'user',
            'website' => 'Pendaftaran Akun Laravel Smtp + Multiuser + CURD + SweetAlert',
            'url' => 'http://' . request()->getHttpHost() . "/" . 'verify/' . $infoRegister['verify_key'],
        ];
    }
}
