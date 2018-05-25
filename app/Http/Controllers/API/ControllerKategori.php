<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ControllerKategori extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = \App\ModelKategori::all();
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
        $data = new \App\ModelKategori();
        $id_kategori = $request->input('id_kategori');
        $kategori= $request->input('kategori');
        $icon = $request->file('icon');
        $ext = $icon->getClientOriginalExtension();
        $newName = rand(100000,1001238912).".".$ext;
        $icon->move('uploads/file',$newName);

        $time_deleted = $request->input('time_deleted');
        $is_deleted = $request->input('is_deleted');

        $data->id_kategori= $id_kategori;
        $data->kategori = $kategori;
        $data->icon= $newName;
        $data->time_deleted= $time_deleted;
        $data->is_deleted= $is_deleted;
        if($data->save()){
            $res['message'] = "Success!";
            $res['value'] = "$data";
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
    public function search($kategori)
    {
        $data = \App\ModelKategori::where('kategori', 'LIKE', '%' . $kategori . '%')->get();
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
