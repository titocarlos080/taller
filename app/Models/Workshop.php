<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    protected $table = 'workshops';

    protected $fillable = [
        'description',
        'location',
        'contact_info',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function assistance_requests()
    {
        return $this->hasMany(Assistance_requests_workshop::class, 'workshop_id');
    }
    public function technicians()
    {
        return $this->hasMany(Technician::class, 'workshop_id');
    }
}
