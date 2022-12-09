<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table = 'poli';
    protected $fillable = [
        'ID_POLI',
        'NAMA_POLI',
    	'KETERANGAN_POLI',
        'STATUS_POLI',
    ];
}
