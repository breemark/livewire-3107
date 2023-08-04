<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InlineComponent extends Component
{
    public function render()
    {
        return <<<'blade'
            <div>
                {{-- The Master doesn't talk, he acts. --}}
                InlineComponent
            </div>
        blade;
    }
}
