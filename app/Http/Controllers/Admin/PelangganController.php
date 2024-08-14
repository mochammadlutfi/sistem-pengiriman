<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Storage;
use Carbon\Carbon;
use PDF;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Pelanggan::orderBy('id', 'DESC')->get();
        // dd($data);
        return view('admin.pelanggan.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pelanggan.create');
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
            'nama' => 'required',
            'telp' => 'required',
            'email' => 'required',
            'nama_cp' => 'required',
            'hp_cp' => 'required',
            'alamat' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            dd($validator->errors());
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $data = new Pelanggan();
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
            return redirect()->route('admin.pelanggan.index');
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
        $data = Pelanggan::where('id', $id)->first();

        return view('admin.pelanggan.edit',[
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
                $data = Pelanggan::where('id', $id)->first();
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
            return redirect()->route('admin.pelanggan.index');
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

            $data = Pelanggan::where('id', $id)->first();
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
    
    public function report(Request $request)
    {
        $data = Pelanggan::latest()->get();


        $config = [
            'format' => 'A4-L'
        ];
        $pdf = PDF::loadView('reports.pelanggan', [
            'data' => $data,
        ], [ ], $config);

        return $pdf->stream('Laporan Pelanggan.pdf');
    }
}
