<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class TKetersediaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(TKetersediaanDetail::class, 'ketersediaan_id');
    }
}
