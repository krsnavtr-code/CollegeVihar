<?php

namespace App\View\Components;

use App\Models\State;
use Illuminate\View\Component;

class University extends Component
{
    private $univ;
    public function __construct($univ)
    {
        $univ['state_name'] = State::where('id', $univ['univ_state'])->get()->first()->toArray()['state_name'];
        $this->univ = $univ;
    }
    public function render()
    {
        return view('components.university', $this->univ);
    }
}
