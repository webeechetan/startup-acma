<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Season;

class KnowledgeSharing extends Model
{
    use HasFactory;

    protected $fillable = [
        'thumbnail',
        'title',
        'overview',
        'description',
        'collaterals'
    ];

    protected $casts = [
        'collaterals' => 'array',
    ];

    public function seasons()
    {
        return $this->belongsToMany(Season::class);
    }

}
