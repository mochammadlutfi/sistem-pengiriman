<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Training;
use App\Models\Payment;

use Carbon\Carbon;
class BerandaController extends Controller
{

    public function index(){
        $user = auth()->user();
        $now = Carbon::today();

        return view('admin.beranda',[
            // 'ovr' => $ovr,
            // 'berlangsung' => $berlangsung 
        ]);
    }
}
