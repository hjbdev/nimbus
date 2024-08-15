<?php

namespace Hjbdev\Nimbus\Components;

use Illuminate\View\Component;

class NavLink extends Component
{
    public function __construct(
        public string $text = '',
        public string $href = '',
        public bool $active = false
    ) {}

    public function render()
    {
        return view('nimbus::components.nav-link');
    }
}
