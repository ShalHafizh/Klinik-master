<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\RK_Medis;
use App\Obat;
use App\Dokter;
use App\Pembayaran;
use App\TransaksiPasien;
use App\KategoriObat;
use Session;
use Excel;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;
class DokterController extends Controller
{
    public function __construct() {
    	 $this->middleware('dokter');
    }

    public function index() {   
        $obat = Obat::with('kategori')->get()->toArray();
        $kategori = KategoriObat::get()->toArray();
        $dokter = Dokter::get()->toArray();
    	return view('dokter.index', ['obat' => $obat, 'kategori' => $kategori, 'dokter' => $dokter]);
    }


    public function getRekamMedis() {
            $rekamMedis = RK_Medis::with('pasien', 'dokter')->get()->toArray();
            $rekamMedis = RK_Medis::join('dokters', 'dokters.id', '=', 'rk_medis.dokter_id')->select('rk_medis.*', 'dokters.nama as nama_dokter')->get()->toArray();
            $pasien = Pasien::get()->toArray();
            $dokter = Dokter::get()->toArray();
            // return $rekamMedis;
    	return view('dokter.rekam-medis', ['rekamMedis' => $rekamMedis, 'pasien' => $pasien, 'dokter' => $dokter]);
    }

    public function getDetailPasien(Request $request) {
        $pasien = Pasien::find($request->id);
        if ($pasien) {
            return response()->json($pasien);
        } else {
            $return   = response()->json([
                'code' => '400',
                'status' => 'Failed',
                'messages' => 'Data tidak ditemukan'
            ]);
            $return->throwResponse();
        }
    }

    public function postTambahRekamMedis(Request $request) {
        $validate = Validator::make($request->all(), [
            'pasien_id' => 'required | exists:pasiens,id',
            'nama' => 'required | exists:pasiens,nama',
            'tgl_lahir' => 'required',
            'dokter_id' => 'required',
            'diagnosa' => 'required',
            'keluhan' => 'required',
            'anamnesis' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'required',
            'alergi_obat' => 'required',
            'bb' => 'required',
            'tb' => 'required',
            'tensi' => 'required',
            'bw' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'code' => '400',
                'status' => 'Failed',
                'messages' => $validate->errors()
            ]);
        } else {
            $id = IdGenerator::generate(['table' => 'rk_medis', 'length' => 10, 'prefix' =>'RM']);
            $data = new RK_Medis();
            $data->id = $id;
            $data->pasien_id = $request->pasien_id;
            $data->nama = $request->nama;
            $data->tgl_lahir = $request->tgl_lahir;
            $data->dokter_id = $request->dokter_id;
            $data->diagnosa = $request->diagnosa;
            $data->keluhan = $request->keluhan;
            $data->anamnesis = $request->anamnesis;
            $data->tindakan = $request->tindakan;
            $data->keterangan = $request->keterangan;
            $data->alergi_obat = $request->alergi_obat;
            $data->bb = $request->bb;
            $data->tb = $request->tb;
            $data->tensi = $request->tensi;
            $data->bw = $request->bw;
            $data->save();
            return response()->json([
                'code' => '200',
                'status' => 'Success',
                'messages' => 'Data berhasil ditambahkan'
            ]);
        }
    }

    public function postUpdateRekamMedis(Request $request){
        $validate = Validator::make($request->all(), [
            'pasien_id' => 'required | exists:pasiens,id',
            'nama' => 'required | exists:pasiens,nama',
            'tgl_lahir' => 'required',
            'dokter_id' => 'required',
            'diagnosa' => 'required',
            'keluhan' => 'required',
            'anamnesis' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'required',
            'alergi_obat' => 'required',
            'bb' => 'required',
            'tb' => 'required',
            'tensi' => 'required',
            'bw' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'code' => '400',
                'status' => 'Failed',
                'messages' => $validate->errors()
            ]);
        } else {
            $data = RK_Medis::find($request->id);
            $data->pasien_id = $request->pasien_id;
            $data->nama = $request->nama;
            $data->tgl_lahir = $request->tgl_lahir;
            $data->dokter_id = $request->dokter_id;
            $data->diagnosa = $request->diagnosa;
            $data->keluhan = $request->keluhan;
            $data->anamnesis = $request->anamnesis;
            $data->tindakan = $request->tindakan;
            $data->keterangan = $request->keterangan;
            $data->alergi_obat = $request->alergi_obat;
            $data->bb = $request->bb;
            $data->tb = $request->tb;
            $data->tensi = $request->tensi;
            $data->bw = $request->bw;
            $data->save();
            return response()->json([
                'code' => '200',
                'status' => 'Success',
                'messages' => 'Data berhasil diubah'
            ]);
        }
    }

    public function getDeleteRekamMedis(Request $request) {
        if ($request->ajax()) {
            $data = RK_Medis::find($request->id)->delete();
            return response()->json([
                'code' => '200',
                'status' => 'Success',
                'messages' => 'Data berhasil dihapus'
            ]);
        }
    }

    public function exportExcelRekamMedis(Request $request, $type) {
         Excel::create('Data Rekam Medis ' .  $request->bulan .'-' .$request->tahun, function ($excel) use ($request){
                $excel->sheet('Data Rekam Medis ' .  $request->bulan .'-' .$request->tahun, function ($sheet) use ($request){
                    $bulan = $request->bulan;
                    $tahun = $request->tahun;
                    $arr = array();
                    $barang = RK_Medis::with('pasien')->where('dokter_id', Session::get('id'))->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->get()->toArray();
                    foreach ($barang as $data) {
                        $data_arr = array(
                            $data['id'],
                            $data['pasien']['nama'],
                            $data['pasien']['jenis_kelamin'],
                            $data['diagnosa'],
                            $data['keluhan'],
                            $data['anamnesis'],
                            $data['tindakan'],
                            $data['keterangan'],
                            $data['alergi_obat'],
                            $data['bb'],
                            $data['tb'],
                            $data['tensi'],
                            $data['bw'],
                        );
                        array_push($arr, $data_arr);
                    }
                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(array(
                        'ID',
                        'Nama Pasien',
                        'Jenis Kelamin',
                        'Diagnosa',
                        'Keluhan',
                        'Anamnesis',
                        'Tindakan',
                        'Keterangan',
                        'Alergi_obat',
                        'BB',
                        'TB',
                        'Tensi',
                        'BW',
                    ));
                });
            })->download($type);
    }

    public function exportPDFRekamMedis(Request $request) {
        $bulan = $request['bulan'];
        $tahun = $request['tahun'];
        $rekamMedis = RK_Medis::with('pasien')->where('dokter_id', Session::get('id'))->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->get()->toArray();
        return view('dokter.pdf', ['bulan' => $bulan, 'tahun' => $tahun, 'rekamMedis' => $rekamMedis]);
    }

    public function getPembayaran() {
            $pembayaran = Pembayaran::with(['dokter','pasien', 'obat'])->where('dokter_id', Session::get('id'))->orderBy('created_at', 'desc')->groupBy('pasien_id')->get()->toArray();
            $hariIni = Pembayaran::where('dokter_id', Session::get('id'))->whereDate('created_at', date('y-m-d'))->get()->toArray();
            $dokter = Pembayaran::where('dokter_id', Session::get('id'))->get()->toArray();
    	return view('dokter.pemeriksaan', ['pembayaran' => $pembayaran, 'hariIni' => $hariIni, 'dokter' => $dokter]);
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
        return view('dokter.pdf-pembayaran', ['bulan' => $bulan, 'tahun' => $tahun, 'pembayaran' => $pembayaran]);
    }

    public function printDetailPembayaran($id) {
        $pembayaran = Pembayaran::with(['dokter', 'pasien', 'obat'])->where(['dokter_id' => Session::get('id'), 'pasien_id' => $id])->get()->toArray();
        return view('dokter.print-pembayaran', ['pembayaran' => $pembayaran]);
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
    return view('dokter.obat', ['obat' => $obat, 'kategori' => $kategori]);
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
    return view('dokter.kategori', ['kategori' => $kategori]);
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