<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'bpm_mskegiatan';
    protected $primaryKey = 'keg_id';
    protected $fillable = [
        'jkg_id',
        'keg_kategori',
        'keg_nama',
        'keg_deskripsi',
        'keg_tgl_mulai',
        'keg_jam_mulai',
        'keg_tgl_selesai',
        'keg_jam_selesai',
        'keg_tempat',
        'keg_foto_sampul',
        'keg_link_folder',
        'keg_dok_notulen',
        'keg_status_dok_notulen',
        'keg_status',
        'keg_created_by',
        'keg_created_date',
        'keg_modif_by',
        'keg_modif_date'
    ];

    public function jenisKegiatan()
    {
        return $this->belongsTo(JenisKegiatan::class, 'jkg_id');
    }
}
