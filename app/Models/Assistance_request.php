<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance_request extends Model
{
    use HasFactory;

    protected $table = 'assistance_requests';
    public $timestamps = true;

    protected $fillable = [
        'client_id',
        'vehicle_id',
        'problem_description',
        'latitud',
        'longitud',
        'photos',
        'voice_note',
        'status_id'
    ];
    public function estado()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
