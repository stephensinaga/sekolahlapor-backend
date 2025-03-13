<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'admin_id',
        'status',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
