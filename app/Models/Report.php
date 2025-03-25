<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'photo_1',
        'photo_2',
        'photo_3',
        'description',
        'location',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments() {
        return $this->hasMany(Assignment::class);
    }
    
    public function officers() {
        return $this->belongsToMany(User::class, 'assignments', 'report_id', 'officer_id');
    }
    
}
