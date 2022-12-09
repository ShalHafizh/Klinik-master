<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Loket extends Authenticatable
{
    use Notifiable;

    protected $guard = 'loket';
    protected $table = 'lokets';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
             'id',
    	'username',
    	'password',
    	'nama',
    	'alamat',
    	'tgl_lahir',
    	'level',
             'photo'
    ];

    public function getPhoto() {
        return $this->photo;
    }
}
