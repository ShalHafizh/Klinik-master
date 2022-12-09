<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    // public $incrementing = false;

    protected $fillable = [
    	'dokter_id',
    	'pasien_id',
    	'obat_id',
        'jumlah',
        'biaya_pemeriksaan',
        'keterangan',
    ];

    public function dokter() {
    	return $this->belongsTo('App\Dokter');
    }

    public function pasien() {
    	return $this->belongsTo('App\Pasien');
    }

    public function obat() {
    	return $this->belongsTo('App\Obat');
    }
}
