<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Storage;
use Carbon\Carbon;

use App\Models\Pengiriman;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\User;


class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Pengiriman::orderBy('id', 'DESC')->get();

        return view('admin.pengiriman.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pelanggan = Pelanggan::select('nama as label', 'id as value')->orderBy('id', 'DESC')->get()->toArray();
        $driver = User::select('nama as label', 'id as value')
        ->where('level', 'Driver')->orderBy('id', 'DESC')->get()->toArray();
        $kendaraan = Kendaraan::select('no_polisi as label', 'id as value')->orderBy('id', 'DESC')->get()->toArray();

        return view('admin.pengiriman.create',compact('pelanggan', 'driver', 'kendaraan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'pelanggan_id' => 'required',
            'tujuan' => 'required',
            'nama_penerima' => 'required',
            'hp_penerima' => 'required',
            'surat_jalan' => 'required',
            'kendaraan_id' => 'required',
            'driver_id' => 'required',
            'barang' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $data = new Pengiriman();
                $data->nomor = $this->getNomor();
                $data->pelanggan_id = $request->pelanggan_id;
                $data->tujuan = $request->tujuan;
                $data->tgl = $request->tgl;
                $data->nama_penerima = $request->nama_penerima;
                $data->hp_penerima = $request->hp_penerima;
                $data->surat_jalan = $request->surat_jalan;
                $data->kendaraan_id = $request->kendaraan_id;
                $data->user_id = $request->driver_id;
                $data->barang = $request->barang;
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->route('admin.pengiriman.index');
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
        $data = Pengiriman::where('id', $id)->first();
        
        return view('admin.pengiriman.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pengiriman::where('id', $id)->first();

        $pelanggan = Pelanggan::select('nama as label', 'id as value')->orderBy('id', 'DESC')->get()->toArray();
        $driver = User::select('nama as label', 'id as value')
        ->where('level', 'Driver')->orderBy('id', 'DESC')->get()->toArray();
        $kendaraan = Kendaraan::select('no_polisi as label', 'id as value')->orderBy('id', 'DESC')->get()->toArray();

        return view('admin.pengiriman.edit',compact('pelanggan', 'driver', 'kendaraan', 'data'));
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
        $rules = [
            'pelanggan_id' => 'required',
            'tujuan' => 'required',
            'nama_penerima' => 'required',
            'hp_penerima' => 'required',
            'surat_jalan' => 'required',
            'kendaraan_id' => 'required',
            'driver_id' => 'required',
            'barang' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $data = Pengiriman::where('id', $id)->first();
                $data->pelanggan_id = $request->pelanggan_id;
                $data->tujuan = $request->tujuan;
                $data->tgl = $request->tgl;
                $data->nama_penerima = $request->nama_penerima;
                $data->hp_penerima = $request->hp_penerima;
                $data->surat_jalan = $request->surat_jalan;
                $data->kendaraan_id = $request->kendaraan_id;
                $data->user_id = $request->driver_id;
                $data->barang = $request->barang;
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->route('admin.pengiriman.index');
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
        DB::beginTransaction();
        try{

            $data = Pengiriman::where('id', $id)->first();
            $data->delete();

        }catch(\QueryException $e){
            DB::rollback();
            return response()->json([
                'fail' => true,
                'errors' => $e,
                'pesan' => 'Gagal Hapus Data!',
            ]);
        }

        DB::commit();
        return response()->json([
            'fail' => false,
            'pesan' => 'Berhasil Hapus Data!',
        ]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $rules = [
            'status' => 'required',
        ];

        $pesan = [
            'status.required' => 'Status Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{
            DB::beginTransaction();
            try{
                $data = Training::where('id', $request->id)->first();
                $data->status = $request->status;
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                return response()->json([
                    'fail' => true,
                    'pesan' => $e,
                ]);
            }

            DB::commit();
            return response()->json([
                'fail' => false,
            ]);
        }
    }

    
    private function getNomor()
    {
        $q = Pengiriman::select(DB::raw('MAX(RIGHT(nomor,5)) AS kd_max'));

        $code = 'KRM';
        $no = 1;
        date_default_timezone_set('Asia/Jakarta');

        if($q->count() > 0){
            foreach($q->get() as $k){
                return $code . date('ym') .'/'.sprintf("%05s", abs(((int)$k->kd_max) + 1));
            }
        }else{
            return $code . date('ym') .'/'. sprintf("%05s", $no);
        }
    }
}
