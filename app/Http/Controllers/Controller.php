<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
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
