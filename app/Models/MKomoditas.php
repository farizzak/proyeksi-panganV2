<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MKomoditas extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function kategori(){
        return $this->belongsTo('\App\Models\Mkategori', 'kategori_id', 'id');
    }
}
