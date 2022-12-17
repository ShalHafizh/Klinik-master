<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\Obat;
use App\Loket;
use App\Pembayaran;
use App\Dokter;
use App\TransaksiPasien;
use App\KategoriObat;
use Session;
use Excel;

class LoketController extends Controller
{
    public function __construct() {
    	 $this->middleware('loket');
    }

    public function index(Pasien $pasien) {   
        $antri = $pasien->with('no_antrian')->whereDate('created_at', date('Y-m-d'))->where(['status' => 'antri', 'layanan_dokter' => Session::get('id')])->get();
        $obat = Obat::with('kategori')->get()->toArray();
        $pasien = $pasien->where('layanan_dokter', Session::get('id'))->whereDate('created_at', date('Y-m-d'))->get();
        $kategori = KategoriObat::get()->toArray();
    	return view('loket.index', ['antri'=> $antri, 'obat' => $obat, 'pasien' => $pasien, 'kategori' => $kategori]);
    }

    public function getPembayaran() {
            $pembayaran = Pembayaran::with(['dokter','pasien', 'obat'])->get()->toArray();
            $dokter = Dokter::get()->toArray();
            $pasien = Pasien::get()->toArray();
            $obat = Obat::get()->toArray();
    	return view('loket.pembayaran', ['pembayaran' => $pembayaran, 'dokter' => $dokter, 'pasien' => $pasien, 'obat' => $obat]);
    }

    public function postPembayaran(Request $request) {
        if ($request->ajax()) {
            $data = Pembayaran::create($request->all());
            return response()->json($data);
        }
    }

    public function excelPembayaran(Request $request, $type) {
            Excel::create('Data Pembayaran ' .  $request->bulan .'-' .$request->tahun, function ($excel) use ($request){
                $excel->sheet('Data Pembayaran ' .  $request->bulan .'-' .$request->tahun, function ($sheet) use ($request){
                    $bulan = $request->bulan;
                    $tahun = $request->tahun;
                    $arr = array();
                    $barang = Pembayaran::with(['dokter', 'pasien', 'obat'])->where('dokter_id', Session::get('id'))->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->get()->toArray();
                    foreach ($barang as $data) {
                        $data_arr = array(
                            $data['id'],
                            $data['dokter']['nama'],
                            $data['pasien']['nama'],
                            $data['obat']['nama'],
                            $data['jumlah'],
                            $data['keterangan'],
                        );
                        array_push($arr, $data_arr);
                    }
                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(array(
                        'ID',
                        'Nama Dokter',
                        'Nama Pasien',
                        'Nama Obat',
                        'Jumlah',
                        'Keterangan',
                    ));
                });
            })->download($type);
    }

    public function PDFPembayaran(Request $request) {
        $bulan = $request['bulan'];
        $tahun = $request['tahun'];
        $pembayaran = Pembayaran::with(['pasien', 'dokter', 'obat'])->where('dokter_id', Session::get('id'))->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->get()->toArray();
        return view('loket.pdf-pembayaran', ['bulan' => $bulan, 'tahun' => $tahun, 'pembayaran' => $pembayaran]);
    }

    public function printDetailPembayaran($id) {
        $pembayaran = Pembayaran::with(['dokter', 'pasien', 'obat'])->where(['dokter_id' => Session::get('id'), 'pasien_id' => $id])->get()->toArray();
        return view('loket.print-pembayaran', ['pembayaran' => $pembayaran]);
    }

    public function getIsiPembayaran(Request $request) {
        if ($request->ajax()) {
            $data = Pembayaran::with('obat')->where(['dokter_id' => Session::get('id'), 'pasien_id' => $request->pasien_id])->get();
            return response()->json($data);
        }
    }

    public function getObat() {
        $obat = Obat::with('kategori')->get()->toArray();
        $kategori = KategoriObat::get()->toArray();
    return view('loket.obat', ['obat' => $obat, 'kategori' => $kategori]);
}

public function postObat(Request $request) {
    if ($request->ajax()) {
        $data = Obat::create($request->all());
        return response()->json($data);
    }
}

public function postUpdateObat(Request $request) {
    if ($request->ajax()) {
        $data = Obat::find($request->id)->update($request->all());
        // $data = $request->id;
        return response()->json($data);
    }
}

public function getHapusObat(Request $request) {
    if ($request->ajax()) {
        $data = Obat::find($request->id)->delete();
        return response()->json($data);
    }
}

public function getKategori() {
    $kategori = KategoriObat::get()->toArray();
    return view('loket.kategori', ['kategori' => $kategori]);
}

public function postKategori(Request $request) {
    if($request->ajax()) {
        $data = KategoriObat::create($request->all());
        return response()->json($data);
    }
}

public function postUpdateKategoriObat(Request $request) {
    if ($request->ajax()) {
        $data = KategoriObat::find($request->id)->update($request->all());
        return response()->json($data);
    }
}

public function getHapusKategori(Request $request) {
    if ($request->ajax()) {
        $data = KategoriObat::find($request->id)->delete();
        return response()->json($data);
    }
}

    public function getDokterId() {
        $dokter_id = Session::get('id');
        return $dokter_id;
    }


}
