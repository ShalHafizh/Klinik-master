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

class DokterController extends Controller
{
    public function __construct() {
    	 $this->middleware('dokter');
    }

    public function index(Pasien $pasien) {   
        $antri = $pasien->with('no_antrian')->whereDate('created_at', date('Y-m-d'))->where(['status' => 'antri', 'layanan_dokter' => Session::get('id')])->get();
        $obat = Obat::with('kategori')->get()->toArray();
        $pasien = $pasien->where('layanan_dokter', Session::get('id'))->whereDate('created_at', date('Y-m-d'))->get();
        $kategori = KategoriObat::get()->toArray();
    	return view('dokter.index', ['antri'=> $antri, 'obat' => $obat, 'pasien' => $pasien, 'kategori' => $kategori]);
    }

    public function getRekamMedisPasien($pasien_id, $nama, $tgl_lahir) {
        $dokter_id = $this->getDokterId();
        $pasien = Pasien::find($pasien_id);
        $rekamMedis =  RK_Medis::where(['nama' => $nama, 'dokter_id' => $dokter_id, 'tgl_lahir' => $tgl_lahir])->get()->toArray();
        // dd($rekamMedis);
        $umur = new \DateTime($pasien->tgl_lahir);
        $ubah = new \DateTime();
        $umur = $ubah->diff($umur);
        $obat = Obat::get()->toArray();
        $id = RK_Medis::select('id')->get()->last();
            if ($id == null) {
                $id = 1;
            }
        $id  = substr($id['id'], 4);
        $id = (int) $id;
        $id += 1;
        $id  = "RK" . str_pad($id, 4, "0", STR_PAD_LEFT);
        // dd($id);
        return view('dokter.pasien-rekam-medis', ['pasien' => $pasien, 'rekamMedis' => $rekamMedis, 'obat' => $obat, 'id' => $id, 'nama' => $nama, 'tgl_lahir' => $tgl_lahir, 'umur' => $umur]);
    }

    public function postRekamMedisPasien(Request $request) {
        if ($request->ajax()) {
            $rekamMedis = RK_Medis::create([
                'id' => $request->id,
                'nama' => $request->nama,
                'bb' => $request->bb,
                'tb' => $request->tb,
                'tensi' => $request->tensi,
                'bw' => $request->bw,
                'pasien_id' => $request->pasien_id,
                'dokter_id' => $request->dokter_id,
                'diagnosa' => $request->diagnosa,
                'keluhan' => $request->keluhan,
                'anamnesis' => $request->anamnesis,
                'tindakan' => $request->tindakan,
                'keterangan' => $request->deskripsi,
                'alergi_obat' => $request->alergi_obat,
            ]);


            return response()->json($rekamMedis);
        }
    }

    public function getRekamMedis() {
            $rekamMedis = RK_Medis::with('pasien')->where('dokter_id', Session::get('id'))->get()->toArray();
            $HariIni = RK_Medis::where('dokter_id', Session::get('id'))->whereDate('created_at', date('Y-m-d'))->get()->toArray();
    	return view('dokter.rekam-medis', ['rekamMedis' => $rekamMedis, 'HariIni' => $HariIni]);
    }

    public function postUpdateRekamMedis(Request $request) {
        if ($request->ajax()) {
            $data = RK_Medis::find($request->id)->update($request->all());
            return response()->json($data);
        }
    }

    public function getDeleteRekamMedis(Request $request) {
        if ($request->ajax()) {
            $data = RK_Medis::find($request->id)->delete();
            return response()->json($data);
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
    	return view('dokter.pembayaran', ['pembayaran' => $pembayaran, 'hariIni' => $hariIni, 'dokter' => $dokter]);
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
