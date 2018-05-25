<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ControllerSurveyor extends Controller
{
    public function index()
    {
        $data = DB::table('keluhan')->where('is_approved', "=", 2)->orWhere('is_approved', "=", 1)
            ->join('users','keluhan.NIM', '=','users.NIM' )
            ->join('kategori', 'keluhan.id_kategori', "=","kategori.id_kategori")
            ->select('keluhan.*','users.name','kategori.kategori','kategori.icon')
            ->orderBy('is_approved','asc')->orderBy('id_keluhan','desc' )
            ->simplePaginate(8)
        ;

        if(count($data) > 0){ //mengecek apakah data kosong atau tidak
            $res['message'] = "Success!";
            $res['values'] = $data;
            return response($res);
        }
        else{
            $res['message'] = "Empty!";
            return response($res);
        }
    }
}
