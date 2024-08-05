<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    
    protected $table = 'pengiriman';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id', 'user_id', 'status', 'tgl'
    ];

    protected $appends = [
        // 'sisa'
    ];

    public function detail(){
        return $this->hasMany(PengirimanDetail::class, 'pengiriman_id');
    }

    public function driver(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function kendaraan(){
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
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
