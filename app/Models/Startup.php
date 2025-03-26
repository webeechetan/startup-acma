<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Season;
use App\Models\Pilot;

class Startup extends Model
{
    /** @use HasFactory<\Database\Factories\StartupFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'bio',
        'country',
        'state',
        'city',
        'pincode',
        'address',
        'year',
        'type',
        'industry',
        'size',
        'revenue',
        'pocs',
        'website',
        'linkedin',
        'facebook',
        'instagram',
        'twitter',
        'collaterals'
    ];

    protected $casts = [
        'collaterals' => 'array',
        'pocs' => 'array'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class);
    }

    public function pilots()
    {
        return $this->belongsToMany(Pilot::class);
    }
}
