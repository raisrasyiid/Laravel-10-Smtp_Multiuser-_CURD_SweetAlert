<?php

namespace App\Http\Controllers;

use App\Mail\AuthMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
            if (Auth::user()->email_verified_at != null) {
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin')->with('success', 'Halo Admin, anda berhasil login');
                } elseif (Auth::user()->role === 'user') {
                    return redirect()->route('user')->with('success', 'Berhasil login');
                }
            } else {
                Auth::logout();
                return redirect()->route('auth')->withErrors('Akun anda belum aktif, silahkan verifikasi terlebih dahulu');
            }
        } else {
            return redirect()->route('auth')->withErrors('Email or Password incorrect');
        }
    }

    function create()
    {
        return view('halamanAuth.register');
    }

    public function register(Request $request)
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
            'password' => bcrypt($request->password),
            'gambar' => $namaGambar,
            'verify_key' => $str,
        ];

        User::create($infoRegister);
        $detail = [
            'nama' => $infoRegister['fullname'],
            'role' => 'user',
            'datetime' => date('Y-m-d H:i:s'),
            'website' => 'Pendaftaran Akun Laravel Smtp + Multiuser + CURD + SweetAlert',
            'url' => 'http://' . request()->getHttpHost() . "/" . 'verify/' . $infoRegister['verify_key'],
        ];

        Mail::to($infoRegister['email'])->send(new AuthMail($detail));

        return redirect()->route('auth')->with('success', 'Email verifikasi telah dikirim, silahkan cek email anda');
    }


    function verify($verify_key)
    {
        $key_check = User::select('verify_key')
            ->where('verify_key', $verify_key)
            ->exists();

        if ($key_check) {
            $user = User::where('verify_key', $verify_key)->update(['email_verified_at' => date('Y-m-d H:i:s')]);

            return redirect()->route('auth')->with('success', 'Verifikasi berhasil. Akun anda telah aktif.');
        } else {
            return redirect()->route('auth')->withErrors('Keys tidak valid. pastikan anda telah melakukan registrasi.')->withInput();
        }
    }
}
