<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pilot;
use App\Models\Startup;
use App\Models\User;

class Season extends Model
{
    use HasFactory;

    protected $table = 'seasons';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function pilots()
    {
        return $this->belongsToMany(Pilot::class);

    }
    public function startups()
    {
        return $this->belongsToMany(Startup::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function getActiveSeason()
    {
        return self::where('is_active', true)->first();
    }
}
