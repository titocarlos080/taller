<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    
    protected $table = 'vehicles';
    public $timestamps = true;
    protected $fillable = [
        'brand',
        'model',
        'year',
        'licence_plate',
        'client_id'
    ];
    
    public function cliente()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
