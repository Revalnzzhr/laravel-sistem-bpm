<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKegiatan extends Model
{
    use HasFactory;

    protected $table = 'bpm_msJenisKegiatan';
    protected $primaryKey = 'jkg_id';
    protected $fillable = ['jkg_nama', 'jkg_status'];

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'jkg_id');
    }
}
