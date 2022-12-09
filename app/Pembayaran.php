<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = ['pembayaran'];
	protected $primaryKey = 'id';

    protected $fillable = [
    'invoice_no',
	'obat_id',
	'pasien_id',
	'tanggal_bayar',
	'harga',
	'notes'
    ];

    public function obat() {
    	return $this->belongsTo('App\Obat');
    }

	public function pasien() {
    	return $this->belongsTo('App\Pasien');
    }
}
