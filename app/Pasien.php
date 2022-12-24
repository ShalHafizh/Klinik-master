<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasiens';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'NIK',
    	'nama',
        'tgl_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'id_desa',
        'alamat',
        'id_pekerjaan',
        'id_agama',
        'id_golongan_darah',
        'telp',
        'status_perkawinan',
        'alergi',
        'foto',

    ];

    public function no_antrian() {
        return $this->belongsTo('App\NoAntrian', 'id', 'pasien_id');
    }


    public function pekerjaan() {
        return $this->belongsTo('App\Pekerjaan');
    }

    public function golongan_darah() {
        return $this->belongsTo('App\Goldar');
    }

    public function agama() {
        return $this->belongsTo('App\Agama');
    }
}
