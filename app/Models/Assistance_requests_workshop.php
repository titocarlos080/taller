<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance_requests_workshop extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = 'assistance_requests_workshop';
    protected $fillable = ['id', 'price', 'workshop_id', 'technician_id', 'assistance_request_id'];
    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }
    public function technicians()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }
    public function assistance_request()
    {
        return $this->belongsTo(Assistance_request::class, 'assistance_request_id');
    }
}
