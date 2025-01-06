<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentang extends Model
{
    use HasFactory;


    protected $table = 'bpm_tentang';

    protected $fillable = [
        'ten_id',
        'ten_category',
        'ten_isi',
        'ten_status',
        'ten_created_by',
        'ten_created_date',
        'ten_modif_by',
        'ten_modif_date',
    ];

    public $timestamps = true;
}
