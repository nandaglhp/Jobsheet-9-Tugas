<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Mahasiswa_MataKuliah;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    $keyword = $request->get('search');
    $query = Mahasiswa::query();

    if ($keyword) {
        $query->where('Nama', 'LIKE', "%$keyword%");
    }

    $mahasiswas = $query->paginate(3);

    $mahasiswas = Mahasiswa::with('kelas')->get();
    $paginate = Mahasiswa::orderBy('Nim', 'asc')->paginate(3);
    return view('mahasiswa.index', ['mahasiswas' => $mahasiswas, 'paginate'=>$paginate]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
        ]);
            //fungsi eloquent untuk menambah data
            $mahasiswas = Mahasiswa::create($request->all());
            //jika data berhasil ditambahkan, akan kembali ke halaman utama
            return redirect()->route('mahasiswa.index')
                ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($Nim)
    {
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Nim)
    {
        // $Mahasiswa = Mahasiswa::find($Nim);
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswa.edit', compact('Mahasiswa','kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $Nim)
    {
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
        ]);
        Mahasiswa::find($Nim)->update($request->all());
        return redirect()->route('mahasiswa.index')
            ->with('succes', 'Mahasiswa Berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($Nim)
    {
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function nilai($Nim){
        $Mahasiswas = Mahasiswa::find($Nim)->first();
        $nilai = Mahasiswa_MataKuliah::where('mahasiswa_id', $Nim)->get();
        $matakuliah = MataKuliah::whereIn('id',$nilai->pluck('matakuliah_id'))->get();
        return view('mahasiswa.nilai', compact(['nilai','Mahasiswas', 'matakuliah']));
    }
}
