<?php

namespace App\Http\Controllers\API;

use App\ModelChat;
use App\ModelKategori;
use App\ModelKeluhanDetail;
use App\ModelRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ControllerChat extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($NIM)
    {
        $data = DB::table('chat_detail')
            ->select('users.NIM','users.name','chat_detail.id_chatdetail','chat_detail.message','chat.id_room','chat.time')
            ->join('users', 'chat_detail.NIM', '=', 'users.NIM' )
            ->join('chat', 'chat_detail.id_room', "=","chat.id_room")
            ->where('users.NIM',$NIM)
            ->groupBy('chat_detail.id_room')
            ->orderBy('chat_detail.id_room','desc')
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
    public function create($NIM)
    {
        /*$datas = DB::table('t')
            ->join('users', 'users.NIM', '=', 't.recipient_id')
            ->select('t.id', 't.owner_id', 't.recipient_id', 'users.name', 't.content', 't.created')
            ->where('t.owner_id', $NIM)
            ->orderBy('t.id', 'desc')
            ->groupBy('users.name')
            ->get();*/

        $datas = DB::table('t')
            ->join('users', 'users.NIM', '=', 't.recipient_id')
            ->select('t.id', 't.owner_id', 't.recipient_id', 'users.name', 't.content', 't.created')
            ->where('t.owner_id', $NIM)
            //->distinct('users.name')
            ->orderBy('t.created', 'desc')
            //->distinct()
            ->groupBy('users.name')
            //->max('t.id')
            ->get();

        //$datas = ModelKategori::all();

        if(count($datas) > 0){
            $res['message'] = "Sukses!";
            $res['value'] = $datas;
            return response($res);
        }else{
            $res['message'] = "Gagal!";
            return response($res);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($Nama,$Penerima)
    {
        /*$datas = DB::table('t')
            ->join('users', 'users.NIM', '=', 't.recipient_id')
            ->select('t.id', 't.owner_id', 't.recipient_id', 'users.name', 't.content', 't.created')
            ->Where('t.owner_id', $Nama)
            ->Where('t.recipient_id', $Penerima)
            ->orWhere('t.owner_id', $Penerima)
            ->orWhere('t.recipient_id', $Nama)
            ->orderBy('t.created', 'desc')
            ->get();*/
        $hoho = "";
        $datas = DB::table('t')
            ->join('users', 'users.NIM', '=', 't.owner_id')
            ->select('t.id', 't.owner_id', 't.recipient_id', 'users.name', 't.content', 't.created')
            ->where(function ($query) use ($Nama, $Penerima) {
                $query->where('t.owner_id', $Nama)
                    ->where('t.recipient_id', $Penerima);
            })
            ->orWhere(function ($query) use ($Nama, $Penerima) {
                $query->where('t.owner_id', $Penerima)
                    ->where('t.recipient_id', $Nama);
            })

            ->orderBy('t.created', 'asc')
            ->get();

        if(count($datas) > 0){
            $res['message'] = "Sukses!";
            $res['value'] = $datas;
            return response($res);
        }else{
            $res['message'] = "Gagal!";
            return response($res);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = new ModelChat();
        $data->owner_id = $request->pengirim;
        $data->recipient_id = $request->penerima;
        $data->content = $request->pesan;
        $data->created = $request->dibuat;

        if($data->save()){
            $res['message'] = "Berhasil!";
            return response($res);
        }else{
            $res['message'] = "Gagal!";
            return response($res);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $idKeluhan = $request->idkeluhan;
        $nim = $request->nim;
        $Rating = $request->rating;

        $ngecheck = ModelRating::where('id_keluhandetail', $idKeluhan)
            ->where('NIM', $nim)
            ->first();

        if($ngecheck == true){
            $idSaatIni = $ngecheck->id;
            $ratingSaatIni = $ngecheck->rating;
            $totalRating = ($ratingSaatIni+$Rating)/2;

            $dataupdate = ModelRating::where('id', $idSaatIni)->first();
            $dataupdate->rating = $totalRating;

            if($dataupdate->save()){
                $resss['message']="Berhasil!";
                return response($resss);
            }else{
                $resss['message']="Gagal!";
                return response($resss);
            }

        }else{
            $datas = new ModelRating();
            $datas->id_keluhandetail = $idKeluhan;
            $datas->NIM = $nim;
            $datas->rating = $Rating;

            if($datas->save()){
                $ress['message'] = "Berhasil!";
                return response($ress);
            }else{
                $ress['message'] = "Gagal!";
                return response($ress);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $datas = DB::table('keluhan_detail')
            ->join('rating', 'keluhan_detail.id_keluhandetail', '=', 'rating.id_keluhandetail')
            ->join('users', 'keluhan_detail.NIM', '=', 'users.NIM')
            ->select('keluhan_detail.id_keluhandetail','users.name', 'keluhan_detail.foto', 'keluhan_detail.lokasi', 'keluhan_detail.deskripsi', 'rating.rating')
            ->where('keluhan_detail.id_keluhan', $id)
            ->first();

        if($datas == true){
            $res['value'] = $datas;
            return response($res);
        }else{

            $datass = DB::table('keluhan_detail')
                ->join('users', 'keluhan_detail.NIM', '=', 'users.NIM')
                ->select('keluhan_detail.id_keluhandetail', 'users.name', 'keluhan_detail.foto', 'keluhan_detail.lokasi', 'keluhan_detail.deskripsi', 'keluhan_detail.rating')
                ->where('keluhan_detail.id_keluhan', $id)
                ->first();

            $res['value'] = $datass;
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
