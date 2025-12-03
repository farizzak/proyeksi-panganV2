<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TKetersediaanDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function ketersediaan()
    {
        return $this->belongsTo(TKetersediaan::class, 'ketersediaan_id');
    }

    public function komoditas()
    {
        return $this->belongsTo(MKomoditas::class, 'komoditas_id');
    }
}
