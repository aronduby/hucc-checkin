<?php

namespace App\View\Components;

use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class DateTime extends Component
{
    /**
     * Create a new component instance.
     *
     * @param Carbon $dt
     */
    public $dt;

    public function __construct(?Carbon $dt)
    {
        $this->dt = $dt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.date-time');
    }
}
