<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Season;
class CaseStudy extends Model
{

    use HasFactory;

    protected $fillable = [
        'thumbnail',
        'title',
        'overview',
        'description'
    ];

    public function seasons()
    {
        return $this->belongsToMany(Season::class);
    }
}
