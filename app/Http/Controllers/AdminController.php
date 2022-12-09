<?php

namespace App\Http\Controllers;

use App\Loket;
use App\Poli;
use App\Dokter;
use App\Resepsionist;
use App\Speasialis;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class AdminController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
            $resepsionist = Resepsionist::select('id')->get()->toArray();
            $dokter = Dokter::select('id')->get()->toArray();
            $loket = Loket::select('id')->get()->toArray();
            $poli = Poli::select('ID_POLI')->get()->toArray();

    	return view('admin.index', [
                        'resepsionist' => $resepsionist,
                        'dokter' => $dokter,
                        'loket' => $loket,
                        'poli' => $poli
            ]);
    }

    // resepsionist
    public function adminResepsionist() {
    	$resepsionist = Resepsionist::get()->toArray();
    	$id = Resepsionist::select('id')->get()->last();
            if ($id == null) {
                $id = 1;
            }
    	$id  = substr($id['id'], 4);
    	$id = (int) $id;
    	$id += 1;
    	$id  = "RS" . str_pad($id, 3, "0", STR_PAD_LEFT);
    	// dd($resepsionist);
    	return view('admin.resepsionist.index', ['resepsionist' => $resepsionist, 'id' => $id]);
    }

    public function postAdminResepsionist(Request $request) {
        // dd($request->all());
    	if ($request) {
                $resepsionist = new Resepsionist;
                $resepsionist->id = $request->id;
                $resepsionist->username = $request->username;
                $resepsionist->password = bcrypt($request->password);
                $resepsionist->nama = $request->nama;
                $resepsionist->alamat = $request->alamat;
                $resepsionist->tgl_lahir = $request->tgl_lahir;
                $resepsionist->level = $request->level;
                // photo
                if ($request->hasFile('photo')) {
                    $file       =   $request->file('photo');
                    $fileName   =   date('Y-m-d') . "." . $file->getClientOriginalName();
                    $location   =   public_path('images/'. $fileName);
                    Image::make($file)->resize(128, 128)->save($location);
                    $resepsionist->photo  =  $fileName;
            }else {
                    $fileName       =   'user-resepsionist.jpg';
                    $resepsionist->photo  =  $fileName;
            }

                $resepsionist->save();

            return redirect()->route('adminResepsionist');
      }
    }

    public function updateAdminResepsionist(Request $request, Resepsionist $resepsionist) {

            $data = $resepsionist->find($request->id);
            if ($request->password != $data->password) {
                $data->id = $request->id;
                $data->username = $request->username;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->tgl_lahir = $request->tgl_lahir;
                $data->level = 'resepsionist';
                if($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $fileName   =   date('Y-m-d') . "." . $file->getClientOriginalName();
                    $location   =   public_path('images/'. $fileName);
                    Image::make($file)->resize(128, 128)->save($location);
                    //gambar lama
                    $oldFileName = $data->photo;
                    // dd($oldFileName);
                    //hapus gambar lama
                    File::delete(public_path('images/' . $oldFileName));
                    //gambar baru
                    $data->photo = $fileName;

                }
                $data->password = bcrypt($request->password);
                $data->save();
                return redirect()->back();
            }elseif($request->password == $data->password) {
                $data->id = $request->id;
                $data->username = $request->username;
                $data->password = $request->password;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->tgl_lahir = $request->tgl_lahir;
                $data->level = 'resepsionist';
                if($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $fileName   =   date('Y-m-d') . "-" . $file->getClientOriginalName();
                    $location   =   public_path('images/'. $fileName);
                    Image::make($file)->resize(128, 128)->save($location);
                    //gambar lama
                    $oldFileName = $data->photo;
                    //hapus gambar lama
                    File::delete(public_path('images/' . $oldFileName));
                    //gambar baru
                    $data->photo = $fileName;

                }
                $data->save();
                return redirect()->back();
            }

    }

    public function deleteAdminResepsionist(Request $request, Resepsionist $resepsionist) {
        if($request->ajax()) {
            $data = $resepsionist->find($request->id)->delete();
            return response()->json($data);
        }
    }

    //poli
    public function getPoli() {
        $poli = Poli::get()->toArray();
        return view('admin.poli.index', ['poli' => $poli]);
    }
    
    public function postPoli(Request $request) {
        if($request->ajax()) {
            $data = Poli::create($request->all());
            return response()->json($data);
        }
    }
    
    public function updatePoli(Request $request) {
        if ($request->ajax()) {
            $data = Poli::find($request->id)->update($request->all());
            return response()->json($data);
        }
    }
    
    public function hapusPoli(Request $request) {
        if ($request->ajax()) {
            $data = Poli::find($request->id)->delete();
            return response()->json($data);
        }
    }

    //Dokter
    public function adminDokter() {
        $dokter = Dokter::with('spesialis')->get()->toArray();
        $spesialis = Speasialis::get()->toArray();
        $id = Dokter::select('id')->get()->last();
            if ($id == null) {
                $id = 1;
            }
        $id  = substr($id['id'], 4);
        $id = (int) $id;
        $id += 1;
        $id  = "DK" . str_pad($id, 3, "0", STR_PAD_LEFT);
        return view('admin.dokter.index', ['dokter' => $dokter, 'id' => $id, 'spesialis' => $spesialis]);
    }

    public function postAdminDokter(Request $request) {
        if ($request) {
                $dokter = new Dokter;
                $dokter->id = $request->id;
                $dokter->username = $request->username;
                $dokter->password = bcrypt($request->password);
                $dokter->nama = $request->nama;
                $dokter->alamat = $request->alamat;
                $dokter->spesialis_id = $request->spesialis_id;
                $dokter->tgl_lahir = $request->tgl_lahir;
                $dokter->level = $request->level;
                // gambar
                if ($request->hasFile('photo')) {
                    $file       =   $request->file('photo');
                    $fileName   =   date('Y-m-d') . "." . $file->getClientOriginalName();
                    $location   =   public_path('images/'. $fileName);
                    Image::make($file)->resize(128, 128)->save($location);
                    $dokter->photo  =  $fileName;
                }else {
                        $fileName       =   'user-dokter.jpg';
                        $dokter->photo  =  $fileName;
                }
                $dokter->save();
                return redirect()->route('adminDokter');
        }
    }

    public function addSpesialis(Request $request, Speasialis $spesialis) {
        if($request->ajax())    {
            $data = Speasialis::create($request->all());
            return response()->json($data);
        }
    }

    public function updateAdminDokter(Request $request, Dokter $dokter) {
            $data = $dokter->find($request->id);
            if ($request->password != $data->password) {
                $data->id = $request->id;
                $data->username = $request->username;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->tgl_lahir = $request->tgl_lahir;
                $data->level = 'dokter';
                $data->spesialis_id = $request->spesialis_id;
                $data->password = bcrypt($request->password);
                if($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $fileName   =   date('Y-m-d') . "." . $file->getClientOriginalName();
                    $location   =   public_path('images/'. $fileName);
                    Image::make($file)->resize(128, 128)->save($location);
                    //gambar lama
                    $oldFileName = $data->photo;
                    //hapus gambar lama
                    File::delete(public_path('images/' . $oldFileName));
                    //gambar baru
                    $data->photo = $fileName;

                }
                $data->save();
                return redirect()->back();
            }elseif($request->password == $data->password) {
                $data->id = $request->id;
                $data->username = $request->username;
                $data->password = $request->password;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->tgl_lahir = $request->tgl_lahir;
                $data->spesialis_id = $request->spesialis_id;
                $data->level = 'dokter';
                if($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $fileName   =   date('Y-m-d') . "." . $file->getClientOriginalName();
                    $location   =   public_path('images/'. $fileName);
                    Image::make($file)->resize(128, 128)->save($location);
                    //gambar lama
                    $oldFileName = $data->photo;
                    //hapus gambar lama
                    Storage::delete($oldFileName);
                    //gambar baru
                    $data->photo = $fileName;

                }
                $data->save();
                return redirect()->back();
            }
    }

    public function deleteAdminDokter(Request $request, Dokter $dokter) {
        if($request->ajax()) {
            $data = $dokter->find($request->id)->delete();
            return response()->json($data);
        }
    }

     //Loket
    public function adminLoket() {
        $loket = Loket::get()->toArray();
        $id = Loket::select('id')->get()->last();
            if ($id == null) {
                $id = 1;
            }
        $id  = substr($id['id'], 4);
        $id = (int) $id;
        $id += 1;
        $id  = "AP" . str_pad($id, 3, "0", STR_PAD_LEFT);
        return view('admin.loket.index', ['loket' => $loket, 'id' => $id]);
    }

    public function postAdminLoket(Request $request) {
        if ($request) {
                $loket = new loket;
                $loket->id = $request->id;
                $loket->username = $request->username;
                $loket->password = bcrypt($request->password);
                $loket->nama = $request->nama;
                $loket->alamat = $request->alamat;
                $loket->tgl_lahir = $request->tgl_lahir;
                $loket->level = $request->level;
                if ($request->hasFile('photo')) {
                    $file       =   $request->file('photo');
                    $fileName   =   date('Y-m-d') . "." . $file->getClientOriginalName();
                    $location   =   public_path('images/'. $fileName);
                    Image::make($file)->resize(128, 128)->save($location);
                    $loket->photo  =  $fileName;
                }else {
                        $fileName       =   'user-apoteker.jpg';
                        $loket->photo  =  $fileName;
                }
                $loket->save();
                return redirect()->route('adminLoket');
        }
    }

    public function updateAdminLoket(Request $request,Loket $loket) {
            $data = $loket->find($request->id);
            if ($request->password != $data->password) {
                $data->username = $request->username;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->tgl_lahir = $request->tgl_lahir;
                $data->level = 'loket';
                if($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $fileName   =   date('Y-m-d') . "." . $file->getClientOriginalName();
                    $location   =   public_path('images/'. $fileName);
                    Image::make($file)->resize(128, 128)->save($location);
                    //gambar lama
                    $oldFileName = $data->photo;
                    //hapus gambar lama
                    File::delete(public_path('images/' . $oldFileName));
                    //gambar baru
                    $data->photo = $fileName;

                }
                $data->password = bcrypt($request->password);
                $data->save();
                return redirect()->back();
            }elseif($request->password == $data->password) {
                $data->username = $request->username;
                $data->password = $request->password;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->tgl_lahir = $request->tgl_lahir;
                $data->photo = $request->photo;
                if($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $fileName   =   date('Y-m-d') . "." . $file->getClientOriginalName();
                    $location   =   public_path('images/'. $fileName);
                    Image::make($file)->resize(128, 128)->save($location);
                    //gambar lama
                    $oldFileName = $data->photo;
                    //hapus gambar lama
                    File::delete(public_path('images/' . $oldFileName));
                    //gambar baru
                    $data->photo = $fileName;

                }
                $data->level = 'loket';
                $data->save();
                return redirect()->back();
            }

    }

    public function deleteAdminLoket(Request $request, Loket $loket) {
        if($request->ajax()) {
            $data = $loket->find($request->id)->delete();
            return response()->json($data);
        }
    }

 

}