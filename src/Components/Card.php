<?php

namespace Hjbdev\Nimbus\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public ?string $title = null,
        public bool $flush = false
    ) {}

    public function render()
    {
        return view('nimbus::components.card');
    }
}
