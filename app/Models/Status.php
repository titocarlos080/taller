<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;
    protected $table = 'statuses';

    public $timestamps = true;
    protected $fillable = ['name'];

    public function assistance_request():HasMany 
    {
        return $this->hasMany(Assistance_request::class, 'status_id');
    }

}
