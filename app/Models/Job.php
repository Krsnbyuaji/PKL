<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'deadline',
        'title',
        'client',
        'description',
        'pic_designer_id',
        'file_path',
        'file_designer',
        'komen_koordinator',
        'komen_qc'
    ];

    // Relasi dengan model User sebagai PIC Designer
    public function picDesigner()
    {
        return $this->belongsTo(User::class, 'pic_designer_id');
    }
}
