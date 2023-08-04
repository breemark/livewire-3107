<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Inline extends Component
{
    public function render()
    {
        return <<<'blade'
            <div>
                {{-- The whole world belongs to you. --}}
                Inline Component
            </div>
        blade;
    }
}
