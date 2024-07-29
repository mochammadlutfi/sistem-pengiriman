<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;
    
    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id', 'nama',
    ];

    public function sparepart(){
        return $this->belongsTo(Sparepart::class, 'sparepart_id');
    }
    
    public function pembelian(){
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

}
