<?php

namespace VkmApps\XForm\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;

class Date extends FormElement
{
    public function __construct(
        public ?string $label    = null,
        public ?string $model    = null,
        public ?string $icon     = null,
        public ?bool   $required = false,
        public ?string $tooltip  = null,
        public ?string $help     = null,
        public ?string $rule     = null,
        public bool    $range    = false,
        public string  $locale   = 'en',
    ) {
        parent::__construct();
    }

    public function render(): View|Closure|string
    {
        return view('x-form::date');
    }
}
