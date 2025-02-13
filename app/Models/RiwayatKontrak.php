<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kontrak;

class RiwayatKontrak extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kontrak';

    protected $fillable = [
        'kontrak_id',
        'tanggal_perubahan',
        'jenis_perubahan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_perubahan' => 'date',
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak::class);
    }
}
