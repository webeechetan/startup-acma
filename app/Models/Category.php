<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pilot;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public function pilots()
    {
        return $this->belongsToMany(Pilot::class);
    }
}
