<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, Session;
class AuthController extends Controller
{
    public function getLogin() {
    	return view('auth.login');
    }

    public function postLogin(Request $request) {
    	$data = [
                         'username' => $request->username,
                         'password' => $request->password,
                         'level'        =>     $request->level,
             ];
             // dd($data);
             // dd(Auth::guard('resepsionist')->attempt($data));
    	if (Auth::guard('admin')->attempt($data)) {
                    // dd(Auth::guard('admin')->check());
                    Session::put('profesi', 'Admin');
                    Session::put('username', Auth::guard('admin')->user()->username);
                    Session::put('id', Auth::guard('admin')->user()->id);
    	       return redirect()->route('admin.index');
    	}elseif(Auth::guard('resepsionist')->attempt($data)) {
                    // dd(Auth::guard('resepsionist')->check());
                    Session::put('profesi', 'Resepsionist'); 
                    Session::put('username', Auth::guard('resepsionist')->user()->username);
                    Session::put('id', Auth::guard('resepsionist')->user()->id);
                    return redirect()->route('resepsionist.index');  
             }elseif(Auth::guard('dokter')->attempt($data)) {
                    // dd(Auth::guard('dokter')->check());
                    Session::put('profesi', 'Dokter');
                    Session::put('username', Auth::guard('dokter')->user()->username);
                    Session::put('id', Auth::guard('dokter')->user()->id);
                    return redirect()->route('dokter.index');
             }elseif(Auth::guard('loket')->attempt($data)) {
                    // dd(Auth::guard('loket')->check());
                    Session::put('profesi', 'Loket');
                    Session::put('username', Auth::guard('loket')->user()->username);
                    Session::put('id', Auth::guard('loket')->user()->id);
                    return redirect()->route('loket.index');
             }

            return redirect()->back()->with('error', 'Gagal Login');
    }

    public function getLogout() {
        Session::flush();
        // dd(Auth::guard('loket')->check());
        return redirect()->route('login');
    }
}
