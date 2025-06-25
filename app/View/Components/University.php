<?php

namespace App\View\Components;

use App\Models\State;
use Illuminate\View\Component;

class University extends Component
{
    private $univ;
    public function __construct($univ)
    {
        $stateName = 'N/A';
        if (!empty($univ['univ_state'])) {
            $state = State::where('id', $univ['univ_state'])->first();
            if ($state) {
                $stateName = $state->state_name;
            }
        }
        $univ['state_name'] = $stateName;
        $this->univ = $univ;
    }
    public function render()
    {
        return view('components.university', $this->univ);
    }
}
