<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Phone extends Component
{

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $phone_formatted;

    /**
     * Create a new component instance.
     *
     * @param string $phone
     */
    public function __construct(string $phone)
    {
        $this->phone = $phone;
        $this->phone_formatted = sprintf("(%s) %s-%s",
            substr($phone, 2, 3),
            substr($phone, 5, 3),
            substr($phone, 8));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.phone');
    }
}
