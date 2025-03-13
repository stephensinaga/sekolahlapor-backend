<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Pastikan kolom yang boleh diisi

    // ✅ Tambahkan relasi ke District
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
