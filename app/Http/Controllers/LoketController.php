<?php

namespace App\Http\Controllers;

use App\KategoriObat;
use App\Obat;
use App\Pasien;
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
}
