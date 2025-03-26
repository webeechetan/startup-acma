<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Season;

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
        'year_founded',
        'type',
        'industry',
        'size',
        'revenue',
        'poc_name',
        'poc_designation',
        'poc_email',
        'poc_phone',
        'website',
        'linkedin',
        'facebook',
        'instagram',
        'twitter',
        'collaterals'
    ];

    protected $casts = [
        'collaterals' => 'array'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class);
    }

}
