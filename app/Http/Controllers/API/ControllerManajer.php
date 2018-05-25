<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ControllerManajer extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('keluhan')->where('is_approved', "=",0)
            ->join('users','keluhan.NIM', '=','users.NIM' )
            ->join('kategori', 'keluhan.id_kategori', "=","kategori.id_kategori")
            ->select('keluhan.*','users.name','kategori.kategori','kategori.icon')
            ->orderBy('is_approved','desc')->orderBy('id_keluhan','desc' )
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id_keluhan)
    {
        if ($data= DB::table('keluhan')->where('id_keluhan',$id_keluhan)->where('is_approved',0)->update([
            'is_approved' => 1
        ]));
        elseif ($data =  DB::table('keluhan')->where('id_keluhan',$id_keluhan)->where('is_approved',1)->update([
            'is_approved' => 2
        ]));
        elseif ($data = DB::table('keluhan')->where('id_keluhan',$id_keluhan)->where('is_approved',2)->update([
            'is_approved' => 3
        ]));
        if($data != null){ //mengecek apakah data kosong atau tidak
            $res['message'] = "Success!";
            $res['values'] = $data;
            return response($res);
        }
        else{
            $res['message'] = "Empty!";
            return response($res);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
