<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kontrak extends Model
{
    use HasFactory;

    protected $table = 'kontrak';

    protected $fillable = [
        'pegawai_id',
        'nomor_kontrak',
        'tanggal_mulai',
        'tanggal_berakhir',
        'gaji_pokok',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'gaji_pokok' => 'decimal:2'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatKontrak::class);
    }

    public function getSisaHariAttribute()
    {
        if ($this->tanggal_berakhir) {
            return Carbon::today()->diffInDays($this->tanggal_berakhir, false);
        }
        return null;
    }

    public function getStatusKontrakTextAttribute()
    {
        if ($this->status === 'tidak_aktif') {
            return 'Tidak Aktif';
        }

        $sisaHari = $this->sisa_hari;
        
        if ($sisaHari < 0) {
            return 'Berakhir';
        } elseif ($sisaHari <= 30) {
            return 'Hampir Berakhir';
        } else {
            return 'Aktif';
        }
    }

    public function getStatusKontrakColorAttribute()
    {
        if ($this->status === 'tidak_aktif') {
            return 'gray';
        }

        $sisaHari = $this->sisa_hari;
        
        if ($sisaHari < 0) {
            return 'red';
        } elseif ($sisaHari <= 30) {
            return 'yellow';
        } else {
            return 'green';
        }
    }
}
