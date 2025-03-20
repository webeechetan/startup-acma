<?php

namespace App\View\Components\Admin;

use App\Models\Season;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SeasonFilter extends Component
{
    public $seasons;
    public $selectedSeason;

    public function __construct($selectedSeason = null)
    {
        $this->seasons = Season::pluck('name', 'id');
        $this->selectedSeason = $selectedSeason ?? Season::getActiveSeason()?->id;
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.season-filter');
    }
}
