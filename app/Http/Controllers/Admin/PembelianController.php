<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Sparepart;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Pembelian::orderBy('id', 'DESC')->get();

        return view('admin.pembelian.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sparepart = Sparepart::latest()->get();

        return view('admin.pembelian.create',[
            'sparepart' => $sparepart 
        ]);
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
            'supplier' => 'required|string',
            'tgl' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return back()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = new Pembelian();
                $data->nomor = $this->getNomor();
                $data->supplier = $request->supplier;
                $data->tgl = $request->tgl;
                $data->total = $request->total;
                $data->save();

                foreach($request->lines as $l){
                    $line = new PembelianDetail();
                    $line->sparepart_id = $l['sparepart_id'];
                    $line->jml = $l['jumlah'];
                    $line->harga = $l['harga'];

                    $data->detail()->save($line);
                }

            }catch(\QueryException $e){
                DB::rollback();
                return response()->json([
                    'fail' => true,
                    'errors' => $e,
                    'pesan' => 'Error Menyimpan Data Anggota',
                ]);
            }

            DB::commit();
            return redirect()->route('admin.pembelian.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $data = Booking::with('user')
        ->withSum([ 'bayar' => fn ($query) => $query->where('status', 'setuju')], 'jumlah')
        ->where('id', $id)
        ->first();
        // dd($data);

        return view('admin.booking.detail',[
            'data' => $data,
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pembelian::where('id', $id)->first();
        $sparepart = Sparepart::latest()->get();

        return view('admin.pembelian.edit',[
            'sparepart' => $sparepart,
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
        // dd($request->all());
        $rules = [
            'supplier' => 'required|string',
            'tgl' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return back()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = Pembelian::where('id', $id)->first();
                $data->supplier = $request->supplier;
                $data->tgl = $request->tgl;
                $data->total = $request->total;
                $data->save();

                if(count($request->deleted)){
                    PembelianDetail::whereIn('id', $request->deleted)->delete();
                }

                foreach($request->lines as $l){
                    if(array_key_exists('id', $l)){
                        $line = PembelianDetail::where('id', $l['id'])->first();
                    }else{
                        $line = new PembelianDetail();
                    }
                    $line->sparepart_id = $l['sparepart_id'];
                    $line->jml = $l['jumlah'];
                    $line->harga = $l['harga'];
                    $data->detail()->save($line);
                }

            }catch(\QueryException $e){
                DB::rollback();
                return response()->json([
                    'fail' => true,
                    'errors' => $e,
                    'pesan' => 'Error Menyimpan Data Anggota',
                ]);
            }

            DB::commit();
            if($request->level_id > 2){
                return back()->withErrors($validator->errors());
            }

            return redirect()->route('admin.pembelian.index');
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

            $data = Pembelian::where('id', $id)->first();
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

    public function cek(Request $request)
    {
        dd($request->all());
    }

    
    private function getNomor()
    {
        $q = Pembelian::select(DB::raw('MAX(RIGHT(nomor,5)) AS kd_max'));

        $code = 'PMB';
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
