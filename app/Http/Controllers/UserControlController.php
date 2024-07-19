<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserControlController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('userControl.index', ['data' => $data]);
    }

    // public function tambah()
    // {
    //     return view('dataMahasiswa.tambah');
    // }

    // new
    // function create(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|min:3',
    //         'email' => 'required|email',
    //         'nim' => 'required|max:8',
    //         'angkatan' => 'required|min:2|max:2',
    //         'jurusan' => 'required',
    //     ], [
    //         'name.required' => 'Name Wajib Di isi',
    //         'name.min' => 'Bidang name minimal harus 3 karakter.',
    //         'email.required' => 'Email Wajib Di isi',
    //         'email.email' => 'Format Email Invalid',
    //         'nim.required' => 'Nim Wajib Di isi',
    //         'nim.max' => 'NIM max 8 Digit',
    //         'angkatan.required' => 'Angkatan Wajib Di isi',
    //         'angkatan.min' => 'Masukan 2 angka Akhir dari Tahun misal: 2022 (22)',
    //         'angkatan.max' => 'Masukan 2 angka Akhir dari Tahun misal: 2022 (22)',
    //         'jurusan.required' => 'Jurusan Wajib Di isi',
    //     ]);

    //     User::insert([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'nim' => $request->nim,
    //         'angkatan' => $request->angkatan,
    //         'jurusan' => $request->jurusan,
    //     ]);

    //     Session::flash('success', 'Data berhasil ditambahkan');

    //     return redirect('/datamahasiswa')->with('success', 'Berhasil Menambahkan Data');
    // }


    // public function edit($id)
    // {
    //     $data = User::find($id);
    //     return view('dataMahasiswa.edit', ['data' => $data]);
    // }

    // function change(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|min:3',
    //         'email' => 'required|email',
    //         'nim' => 'required|min:8|max:8',
    //         'angkatan' => 'required|min:2|max:2',
    //         'jurusan' => 'required',
    //     ], [
    //         'name.required' => 'Name Wajib Di isi',
    //         'name.min' => 'Bidang name minimal harus 3 karakter.',
    //         'email.required' => 'Email Wajib Di isi',
    //         'email.email' => 'Format Email Invalid',
    //         'nim.required' => 'Nim Wajib Di isi',
    //         'nim.max' => 'NIM max 8 Digit',
    //         'nim.min' => 'NIM min 8 Digit',
    //         'angkatan.required' => 'Angkatan Wajib Di isi',
    //         'angkatan.min' => 'Masukan 2 angka Akhir dari Tahun misal: 2022 (22)',
    //         'angkatan.max' => 'Masukan 2 angka Akhir dari Tahun misal: 2022 (22)',
    //         'jurusan.required' => 'Jurusan Wajib Di isi',
    //     ]);

    //     $datamahasiswa = User::find($request->id);

    //     $datamahasiswa->name = $request->name;
    //     $datamahasiswa->email = $request->email;
    //     $datamahasiswa->nim = $request->nim;
    //     $datamahasiswa->angkatan = $request->angkatan;
    //     $datamahasiswa->jurusan = $request->jurusan;
    //     $datamahasiswa->save();

    //     Session::flash('success', 'Berhasil Mengubah Data');

    //     return redirect('/datamahasiswa');
    // }

    // public function hapus(Request $request)
    // {
    //     User::where('id', $request->id)->delete();

    //     Session::flash('success', 'Berhasil hapus data');
    //     return redirect('/datamahasiswa');
    // }
}