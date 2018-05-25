<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ControllerKeluhanDetail extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_keluhan)
    {
        $data = DB::table('keluhan_detail')->where('id_keluhan',$id_keluhan)
            ->join('users','keluhan_detail.NIM', '=','users.NIM' )
            ->select('keluhan_detail.*','users.name')
            ->get();
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
        $data = new \App\ModelKeluhanDetail();
        $id_keluhandetail= $request->input('id_keluhandetail');
        $id_keluhan = $request->input('id_keluhan');
        $NIM= $request->input('NIM');
        $deskripsi = $request->input('deskripsi');
        $foto = $request->file('foto');
        $lokasi = $request->input('lokasi');
        $ext = $foto->getClientOriginalExtension();
        $newName = rand(100000,1001238912).".".$ext;
        $foto->move('uploads/file',$newName);

        $rating= $request->input('rating');
        $data->id_keluhandetail = $id_keluhandetail;
        $data->id_keluhan = $id_keluhan ;
        $data->NIM = $NIM;
        $data->deskripsi= $deskripsi;
        $data->foto = $newName;
        $data->lokasi=$lokasi;
        $data->rating =$rating;
        if($data->save()){
            $res['message'] = "Success!";
            $res['value'] = $data;
            return response($res);
        }
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
    public function update(Request $request, $id)
    {
        //
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
