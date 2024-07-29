<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanDetail extends Model
{
    use HasFactory;
    
    protected $table = 'pengiriman_detail';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id', 'user_id', 'status', 'tgl'
    ];

    protected $appends = [
        // 'sisa'
    ];

    public function detail(){
        return $this->hasMany(PembelianDetail::class, 'pembelian_id');
    }

    
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }
}
