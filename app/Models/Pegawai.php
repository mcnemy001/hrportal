<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kontrak;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nomor_telepon',
        'email',
        'status_pegawai'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kontrak()
    {
        return $this->hasMany(Kontrak::class);
    }

    public function kontrakAktif()
    {
        return $this->hasOne(Kontrak::class)
            ->where('status', 'active')
            ->whereDate('tanggal_berakhir', '>', now())
            ->latest();
    }
}
