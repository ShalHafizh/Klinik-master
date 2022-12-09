<?php

namespace App\Http\Controllers;

use App\KategoriObat;
use App\Obat;
use App\Pasien;
use App\Resep;
use App\TransaksiPasien;
use App\Pembayaran;
use Illuminate\Http\Request;
use PDF, Excel;

class LoketController extends Controller
{
    public function __construct() {
    	  $this->middleware('loket');
    }

    public function index() {
        $obat = Obat::with('kategori')->get()->toArray();
        $kategori = KategoriObat::get()->toArray();
    return view('loket.obat', ['obat' => $obat, 'kategori' => $kategori]);
    }

    public function getDataResep($dokter_id, $pasien_id) {
            $ada = 'ada';
            $habis = 'habis';
            $ada = Resep::with(['obat', 'dokter', 'pasien'])->whereHas('obat', function($q) use($ada){ $q->where('status', '=', $ada); })->where(['dokter_id' => $dokter_id, 'pasien_id' => $pasien_id])->get()->toArray();
            $habis =  Resep::with(['obat', 'dokter', 'pasien'])->whereHas('obat', function($q) use($habis){ $q->where('status', '=', $habis); })->where(['dokter_id' => $dokter_id, 'pasien_id' => $pasien_id])->get()->toArray();
            $nama_dokter = Resep::with('dokter')->first();
            $nama_pasien = Resep::with('pasien')->first();
            return view('loket.getDataResep', ['ada' => $ada, 'habis' => $habis, 'nama_dokter' => $nama_dokter, 'nama_pasien' => $nama_pasien, "dokter_id" => $dokter_id, "pasien_id" => $pasien_id]);
    }

    public function getDetailResep(Request $request) {
        if ($request->ajax()) {
            $data = Resep::with(['obat', 'dokter', 'pasien'])->where(['dokter_id' => $request->dokter_id, 'pasien_id' => $request->pasien_id])->get();
            $nama_dokter = $data[0]['dokter']['nama'];
            $nama_pasien = $data[0]['pasien']['nama'];
            return response()->json([$data, $nama_dokter, $nama_pasien]);
        }
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

    public function exportExcelObat($type) {
        return  Excel::create('Data Obat ', function ($excel) {
                $excel->sheet('Data Obat ', function ($sheet) {
                    $arr = array();
                    $obat = Obat::with('kategori')->get()->toArray();
                    foreach ($obat as $data) {
                        $data_arr = array(
                            $data['id'],
                            $data['nama'],
                            $data['kandungan'],
                            $data['kategori']['kategori'],
                            $data['harga'],
                            $data['status'],
                        );
                        array_push($arr, $data_arr);
                    }
                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(array(
                        'ID',
                        'Nama Obat',
                        'Kandungan',
                        'Kategori Obat',
                        'Harga',
                        'Status',
                    ));
                });
            })->download($type);
    }

    public function exportPDFObat(Request $request) {
        if ($request->semua) {
            $status = $request->semua;
            $fileName = 'Data Semua Obat.pdf';
            $obat = Obat::with('kategori')->get()->toArray();
        }else{
            $status = $request->habis;
            $fileName = 'Data Obat Stok Habis.pdf';
            $obat = Obat::with('kategori')->where('status', $status)->get()->toArray();
        }
        $pdf = PDF::loadView('loket.pdf-obat', ['obat' => $obat, 'status' => $status]);
        return $pdf->stream($fileName);
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

    public function ambilResep() {
        $resep = Resep::with(['pasien', 'obat'])->where('dokter_id', Session::get('id'))->orderBy('created_at', 'desc')->groupBy('pasien_id')->get()->toArray();
        // dd($resep);
        $hariIni = Resep::where('dokter_id', Session::get('id'))->whereDate('created_at', date('y-m-d'))->get()->toArray();
    return view('dokter.resep', ['resep' => $resep, 'hariIni' => $hariIni]);
}

public function ambilExcelResep(Request $request, $type) {
        Excel::create('Data Resep ' .  $request->bulan .'-' .$request->tahun, function ($excel) use ($request){
            $excel->sheet('Data Resep ' .  $request->bulan .'-' .$request->tahun, function ($sheet) use ($request){
                $bulan = $request->bulan;
                $tahun = $request->tahun;
                $arr = array();
                $barang = Resep::with(['pasien', 'obat'])->where('dokter_id', Session::get('id'))->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->get()->toArray();
                foreach ($barang as $data) {
                    $data_arr = array(
                        $data['id'],
                        $data['pasien']['nama'],
                        $data['obat']['nama'],
                        $data['jumlah'],
                        $data['keterangan'],
                    );
                    array_push($arr, $data_arr);
                }
                $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(array(
                    'ID',
                    'Nama Pasien',
                    'Nama Obat',
                    'Jumlah',
                    'Keterangan',
                ));
            });
        })->download($type);
}

public function ambilPDFResep(Request $request) {
    $bulan = $request['bulan'];
    $tahun = $request['tahun'];
    $resep = Resep::with(['pasien', 'dokter', 'obat'])->where('dokter_id', Session::get('id'))->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->get()->toArray();
    // dd($resep);
    return view('dokter.pdf-resep', ['bulan' => $bulan, 'tahun' => $tahun, 'resep' => $resep]);
}

public function ambilIsiResep(Request $request) {
    if ($request->ajax()) {
        $data = Resep::with('obat')->where(['dokter_id' => Session::get('id'), 'pasien_id' => $request->pasien_id])->get();
        return response()->json($data);
    }
}

    public function postResep(Request $request) {
        if ($request->ajax()) {
            $pasien = Pasien::find($request->pasien_id)->update(['status' => 'selesai']);
            for ($i=0; $i <count($request['id']) ; $i++) {
                $data = Resep::where('id', $request['id'][$i]['value'])->first();
                $data->status = 'selesai';
                $data->save();
            }
            // create transaksi pasien
            $transaksi_pasien = TransaksiPasien::create([
                'dokter_id' => $data['dokter_id'],
                'pasien_id' => $request['pasien_id'],
                'bayar' => $request['bayar'],
                'kembalian' => $request['kembalian'],
                'total' => $request['total'],
                'tgl_resep' => $request['tgl_resep']
            ]);
            return response()->json($transaksi_pasien);
        }
    }


    public function PrintDetailResep(Request $request, $dokter_id, $pasien_id) {
        // dd($request['habis']);
        $pasien = Pasien::find($pasien_id)->update(['status' => 'selesai']);
         for ($i=0; $i <count($request['habis']) ; $i++) {
            $data = Resep::where('id', $request['habis'][$i])->first();
            $data->status = 'selesai';
            $data->save();
        }

        $habis = 'habis';
       $resep = Resep::with(['obat', 'dokter', 'pasien'])->whereHas('obat', function($q) use($habis){ $q->where('status', '=', $habis); })->where(['dokter_id' => $dokter_id, 'pasien_id' => $pasien_id])->get()->toArray();
       $size = array(0,0,393,590);
        $pdf = PDF::loadView('loket.printDetailResep', ['resep' => $resep])->setPaper($size)->setOptions(['dpi' => 72,'defaultFont' => 'sans-serif']);
       return $pdf->stream('resep-dokter.pdf');
    }

    public function getPrintTagihan($tagihan_id, $dokter_id, $pasien_id) {
        $size = array(0,0,204,650);
        $resep = Resep::with(['obat', 'dokter', 'pasien'])->whereHas('obat', function($query) {
            $query->where('status', 'ada');
        })->where(['dokter_id' => $dokter_id, 'pasien_id' => $pasien_id])->get()->toArray();
        $tagihan = TransaksiPasien::where('id', $tagihan_id)->first();
        $pdf = PDF::loadView('loket.print', ['resep' => $resep, 'tagihan' => $tagihan])->setOptions(['dpi' => 72,'defaultFont' => 'sans-serif']);
        return $pdf->stream('Tagihan Klinik.pdf');
    }
}
