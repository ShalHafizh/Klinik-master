<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $table = 'pekerjaan';
    protected $primaryKey = 'ID_Pekerjaan';
    protected $fillable = [
        'Nama_Pekerjaan',
    ];
}
