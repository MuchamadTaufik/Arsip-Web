<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
