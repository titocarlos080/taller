<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'rols';
    public $timestamps = true;
    protected $fillable = ['name'];

    public function users():HasMany 
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}
