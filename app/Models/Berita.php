<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'bpm_msberita';

    // Specify the primary key
    protected $primaryKey = 'ber_id';

    // Disable auto-incrementing if needed
    public $incrementing = true;

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'ber_judul',
        'ber_tgl',
        'ber_penulis',
        'ber_isi',
        'ber_foto1',
        'ber_foto2',
        'ber_foto3',
        'ber_status',
        'ber_created_by',
        'ber_created_date',
        'ber_modif_by',
        'ber_modif_date',
    ];

    // You can also define date casting for fields like 'ber_tgl', 'ber_created_date', 'ber_modif_date'
    protected $casts = [
        'ber_tgl' => 'datetime',
        'ber_created_date' => 'datetime',
        'ber_modif_date' => 'datetime',
    ];
}
