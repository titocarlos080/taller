<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $table = 'technicians';
    public $timestamps = true;

    protected $fillable = [
        'phone',
        'workshop_id',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }
    public function assistance_requests()
    {
        return $this->hasMany(Assistance_requests_workshop::class, 'technician_id');
    }
}
