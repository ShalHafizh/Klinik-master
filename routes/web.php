<?php

use Illuminate\Support\Facades\Route;

Route::get('/', ['uses' => 'AuthController@getLogin', 'as' => 'login']);
Route::post('/', ['uses' => 'AuthController@postLogin']);
Route::get('/logout', ['uses' => 'AuthController@getLogout', 'as' => 'logout']);

// Admin
Route::group(['prefix' => 'admin'], function() {
	Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin.index']);
	// Admin Resepsionist
	Route::get('/resepsionist', ['uses' => 'AdminController@adminResepsionist', 'as' => 'adminResepsionist']);
	Route::post('/resepsionist/create', ['uses' => 'AdminController@postAdminResepsionist', 'as' => 'postAdminResepsionist']);
	Route::post('/resepsionist/update', ['uses' => 'AdminController@updateAdminResepsionist', 'as' => 'updateAdminResepsionist']);
	Route::get('/resepsionist/delete', ['uses' => 'AdminController@deleteAdminResepsionist', 'as' => 'deleteAdminResepsionist']);
    	// Admin Dokter
    	Route::get('/dokter', ['uses' => 'AdminController@adminDokter', 'as' => 'adminDokter']);
    	Route::post('/dokter/create', ['uses' => 'AdminController@postAdminDokter', 'as' => 'postAdminDokter']);
    	Route::post('/dokter/addSpesialis', ['uses' => 'AdminController@addSpesialis', 'as' => 'addSpesialis']);
	Route::post('/dokter/update', ['uses' => 'AdminController@updateAdminDokter', 'as' => 'updateAdminDokter']);
	Route::get('/dokter/delete', ['uses' => 'AdminController@deleteAdminDokter', 'as' => 'deleteAdminDokter']);
	//Admin Loket
	Route::get('/loket', ['uses' => 'AdminController@adminLoket', 'as' => 'adminLoket']);
	Route::post('/loket/create', ['uses' => 'AdminController@postAdminLoket', 'as' => 'postAdminLoket']);
	Route::post('/loket/update', ['uses' => 'AdminController@updateAdminLoket', 'as' => 'updateAdminLoket']);
	Route::get('/loket/delete', ['uses' => 'AdminController@deleteAdminLoket', 'as' => 'deleteAdminLoket']);

	//Admin Poli
	Route::get('/getPoli', ['uses' => 'AdminController@getPoli', 'as' => 'getPoli']);
	Route::post('/postPoli', ['uses' => 'AdminController@postPoli', 'as' => 'postPoli']);
	Route::post('/updatePoli', ['uses' => 'AdminController@updatePoli', 'as' => 'updatePoli']);
	Route::get('/hapusPoli', ['uses' => 'AdminController@hapusPoli', 'as' => 'hapusPoli']);
	
});

// Respsionist
Route::group(['prefix' => 'resepsionist'], function() {
	Route::get('/', ['uses' => 'ResepsionistController@index', 'as' => 'resepsionist.index']);
	Route::get('/no-antrian-pasien/pasien_id={id}', ['uses' => 'ResepsionistController@no_antrian', 'as' => 'resepsionist.no_antrian']);
	Route::get('/reset-no-antrian-pasien', ['uses' => 'ResepsionistController@resetNoAntrian', 'as' => 'resepsionist.reset_no_antrian']);
	Route::post('/pendaftaran-pasien', ['uses' => 'ResepsionistController@postPendaftaranPasien', 'as' => 'postPendaftaranPasien']);
	Route::get('/pasien/hapus', ['uses' => 'ResepsionistController@getHapusPasien', 'as' => 'getHapusPasien']);
	Route::get('/pasien', ['uses' => 'ResepsionistController@getPasien', 'as' => 'getPasien']);
	Route::post('/pasien/pasien-terdaftar', ['uses' => 'ResepsionistController@postPasienTerdaftar', 'as' => 'postPasienTerdaftar']);
	Route::post('/pasien/update', ['uses' => 'ResepsionistController@postUpdatePasien', 'as' => 'postUpdatePasien']);
	Route::post('/pasien/export/{type}', ['uses' => 'ResepsionistController@exportExcelPasien', 'as' => 'exportExcelPasien']);
	Route::post('/pasien/exportPdf', ['uses' => 'ResepsionistController@exportPDFPasien', 'as' => 'exportPDFPasien']);
	Route::get('/scan', ['uses' => 'ResepsionistController@scan', 'as' => 'scan']);
	Route::post('/validasi', ['uses' => 'ResepsionistController@validasi', 'as' => 'validasi']);
});

// Dokter
Route::group(['prefix' => 'dokter'], function() {
	// Periksa Pasien
	Route::get('/', ['uses' => 'DokterController@index', 'as' => 'dokter.index']);
	Route::get('/periksa/pasien/id={id}&nama={nama}&tgl={tgl}', ['uses' => 'DokterController@getRekamMedisPasien', 'as' => 'getRekamMedisPasien']);
	Route::post('/periksa/pasien', ['uses' => 'DokterController@postRekamMedisPasien', 'as' => 'postRekamMedisPasien']);
	Route::get('/getObat', ['uses' => 'DokterController@getObat', 'as' => 'getObat']);

	// Rekam Medis
	Route::get('/rekam-medis', ['uses' => 'DokterController@getRekamMedis', 'as' => 'getRekamMedis']);
	Route::post('/rekam-medis', ['uses' => 'DokterController@postUpdateRekamMedis', 'as' => 'postUpdateRekamMedis']);
	Route::post('/rekam-medis/excel/{type}', ['uses' => 'DokterController@exportExcelRekamMedis', 'as' => 'exportExcelRekamMedis']);
	Route::post('/rekam-medis/export/pdf', ['uses' => 'DokterController@exportPDFRekamMedis', 'as' => 'exportPDFRekamMedis']);
	Route::get('/rekam-medis/delete', ['uses' => 'DokterController@getDeleteRekamMedis', 'as' => 'getDeleteRekamMedis']);

	// Resep Dokter
	Route::get('/resep', ['uses' => 'DokterController@getResep', 'as' => 'getResep']);
	Route::post('/resep/excel/{type}', ['uses' => 'DokterController@excelResep', 'as' => 'excelResep']);
	Route::post('/resep/export/pdf', ['uses' => 'DokterController@PDFResep', 'as' => 'PDFResep']);
	Route::get('/resep/print/detail/{id}', ['uses' => 'DokterController@printDetailResep', 'as' => 'printDetailResep']);
	Route::get('/resep/detail', ['uses' => 'DokterController@getIsiResep', 'as' => 'getIsiResep']);

	//Obat
	Route::get('/obat', ['uses' => 'DokterController@getObat', 'as' => 'ambilGetObat']);
	Route::post('/obat', ['uses' => 'DokterController@postObat', 'as' => 'postObat']);
	Route::post('/obat/update', ['uses' => 'DokterController@postUpdateObat', 'as' => 'postUpdateObat']);
	Route::get('/obat/getHapusObat', ['uses' => 'DokterController@getHapusObat', 'as' => 'getHapusObat']);

	//Kategori Obat
	Route::get('/getKategori', ['uses' => 'DokterController@getKategori', 'as' => 'ambilGetKategori']);
	Route::post('/postKategori', ['uses' => 'DokterController@postKategori', 'as' => 'postKategori']);
	Route::get('/getHapusKategori', ['uses' => 'DokterController@getHapusKategori', 'as' => 'ambilGetHapusKategori']);
	Route::post('/postUpdateKategori', ['uses' => 'DokterController@postUpdateKategoriObat', 'as' => 'postUpdateKategori']);


});

// Loket
Route::group(['prefix' => 'loket'], function() {
	Route::get('/', ['uses' => 'LoketController@index', 'as' => 'loket.obat']);
	Route::post('/obat', ['uses' => 'LoketController@postObat', 'as' => 'postObat']);
	Route::post('/obat/update', ['uses' => 'LoketController@postUpdateObat', 'as' => 'postUpdateObat']);
	Route::get('/obat/getHapusObat', ['uses' => 'LoketController@getHapusObat', 'as' => 'getHapusObat']);
	Route::get('/obat/excel/{type}', ['uses' => 'LoketController@exportExcelObat', 'as' => 'exportExcelObat']);
	Route::post('/obat/export/Pdf', ['uses' => 'LoketController@exportPDFObat', 'as' => 'exportPDFObat']);
	Route::get('/DetailResep/dokter_id={dokter_id}&pasien_id={pasien_id}', ['uses' => 'LoketController@getDataResep', 'as' => 'getDataResep']);
	Route::post('/DetailResep/postResep', ['uses' => 'LoketController@postResep', 'as' => 'postResep']);
	Route::post('/DetailResep/dokter_id={dokter_id}&pasien_id={pasien_id}/Print', ['uses' => 'LoketController@PrintDetailResep', 'as' => 'PrintDetailResep']);
	Route::get('/getDetailResep', ['uses' => 'LoketController@getDetailResep', 'as' => 'getDetailResep']);
	Route::get('/getKategori', ['uses' => 'LoketController@getKategori', 'as' => 'getKategori']);
	Route::post('/postKategori', ['uses' => 'LoketController@postKategori', 'as' => 'postKategori']);
	Route::get('/getHapusKategori', ['uses' => 'LoketController@getHapusKategori', 'as' => 'getHapusKategori']);
	Route::post('/postUpdateKategori', ['uses' => 'LoketController@postUpdateKategoriObat', 'as' => 'postUpdateKategori']);
	Route::get('/print-tagihan/tagihan={tagihan_id}&dokter_id={dokter_id}&pasien_id={pasien_id}', ['uses' => 'LoketController@getPrintTagihan', 'as' => 'loket.getPrintTagihan']);

});




?>