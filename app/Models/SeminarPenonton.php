<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeminarPenonton extends Model
{
    use HasFactory;

    protected $table = 'seminar_penonton';

    protected $fillable = [
        'nim',
        'tanggal_nonton',
    ];

    protected $casts = [
        'tanggal_nonton' => 'date',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
