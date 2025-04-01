<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Pilot;
use App\Models\Startup;
use App\Models\CaseStudy;
use App\Models\KnowledgeSharing;

class Season extends Model
{
    use HasFactory;

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

    public function caseStudies()
    {
        return $this->belongsToMany(CaseStudy::class);
    }

    public function knowledgeSharings()
    {
        return $this->belongsToMany(KnowledgeSharing::class);
    }

    public static function getActiveSeason()
    {
        return self::where('is_active', true)->first();
    }
}
