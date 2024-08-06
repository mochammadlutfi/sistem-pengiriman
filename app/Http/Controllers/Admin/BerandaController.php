<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Pengiriman;
use App\Models\Pembelian;
use App\Models\Kendaraan;

use Carbon\Carbon;
class BerandaController extends Controller
{

    public function index(){
        $user = auth()->user();
        $now = Carbon::today();

        $data = Collect([
            'pengiriman' => Pengiriman::latest()->get()->count(),
            'driver' => User::where('level', 'Driver')->get()->count(),
            'pembelian' => Pembelian::latest()->get()->count(),
            'kendaraan' => Kendaraan::latest()->get()->count(),
        ]);

        return view('admin.beranda',[
            'data' => $data,
            // 'ovr' => $ovr,
            // 'berlangsung' => $berlangsung 
        ]);
    }
}
