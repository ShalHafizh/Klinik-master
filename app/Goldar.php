<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goldar extends Model
{
    protected $table = 'golongan_darah';
    protected $primaryKey = 'ID_Darah';
    protected $fillable = [
        'Nama_Darah',
    ];
}
