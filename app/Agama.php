<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    protected $table = 'agama';
    protected $primaryKey = 'ID_Agama';
    protected $fillable = [
        'Nama_Agama',
    ];
}
