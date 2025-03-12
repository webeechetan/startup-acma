<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pilot extends Model
{
    use HasFactory;

    protected $table = 'pilots';

    protected $fillable = [
        'name',
    ];

    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
