<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TDistribution extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function kecematan(){
        return $this->belongsTo(MKecamatan::class,'kecamatan_id');
    }
}
