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
                $data->pelanggan_id = $request->pelanggan_id;
                $data->tujuan = $request->tujuan;
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
        $data = Pengiriman::where('id', $id)->first();

        return view('admin.pengiriman.edit',[
            'data' => $data
        ]);
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
            'nama' => 'required',
            'telp' => 'required',
            'email' => 'required',
            'nama_cp' => 'required',
            'hp_cp' => 'required',
            'alamat' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $data = Pengiriman::where('id', $id)->first();
                $data->nama = $request->nama;
                $data->telp = $request->telp;
                $data->email = $request->email;
                $data->nama_cp = $request->nama_cp;
                $data->hp_cp = $request->hp_cp;
                $data->alamat = $request->alamat;
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

    
    public function peserta($id, Request $request)
    {
        if ($request->ajax()) {
            $query = UserTraining::with('user')->where('training_id', $id)->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="dropdown">
                        <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" id="dropdown-default-outline-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Aksi
                        </button>
                        <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-default-outline-primary" style="">';
                        $btn .= '<a class="dropdown-item" href="'. route('admin.pengiriman.edit', $row->id).'"><i class="si si-note me-1"></i>Ubah</a>';
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="hapus('. $row->id.')"><i class="si si-trash me-1"></i>Hapus</a>';
                    $btn .= '</div></div>';
                    return $btn; 
                })
                ->editColumn('tgl_training', function ($row) {
                    $tgl_mulai = Carbon::parse($row->tgl_mulai);
                    $tgl_selesai = Carbon::parse($row->tgl_selesai);
                    if($tgl_mulai->eq($tgl_selesai) || $row->tgl_selesai == null){
                        return $tgl_mulai->translatedformat('d M Y');
                    }else{
                        return $tgl_mulai->translatedformat('d') . ' - '. $tgl_selesai->translatedformat('d M Y');
                    }
                })
                ->editColumn('tgl_daftar', function ($row) {
                    $tgl_mulai = Carbon::parse($row->tgl_mulai_daftar);
                    $tgl_selesai = Carbon::parse($row->tgl_selesai_daftar);
                    if($tgl_mulai->eq($tgl_selesai) || $row->tgl_selesai_daftar == null){
                        return $tgl_mulai->translatedformat('d M Y');
                    }else{
                        return $tgl_mulai->translatedformat('d M') . ' - '. $tgl_selesai->translatedformat('d M Y');
                    }
                })
                ->rawColumns(['action',]) 
                ->make(true);
        }

        $data = Training::where('id', $id)->first();
        $user = User::orderBy('nama', 'ASC')->get();

        return view('admin.pengiriman.peserta',[
            'data' => $data,
            'user' => $user
        ]);
    }
}
