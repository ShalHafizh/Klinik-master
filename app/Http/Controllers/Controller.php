<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
<<<<<<< HEAD
=======

>>>>>>> c5fe16f4e25e9da2cb8f6a1771d21daa7d09d209
    public function findDataWhere($model, $where)
    {
        $data = $model::where($where)->first();
        if ($data) {
            return $data;
        } else {
            $return   = response()->json([
                'code' => '400',
                'status' => 'Failed',
                'messages' => 'Data tidak ditemukan'
            ]);
            $return->throwResponse();
        }
    }
}
