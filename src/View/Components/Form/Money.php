<?php

namespace VkmApps\XForm\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use VkmApps\XForm\Traits\HasMoneyFormatting;

class Money extends FormElement
{
    use HasMoneyFormatting;

    public string $symbol;
    public string $position;
    public string $decimalSeparator;
    public string $thousandsSeparator;

    public function __construct(
        public ?string $label = null,
        public ?string $model = null,
        public ?string $placeholder = null,
        public ?string $icon = null,
        public ?bool $required = false,
        public ?string $tooltip = null,
        public ?string $help = null,
        public ?string $rule = null,
        public bool $invalid = false,
        public bool $border = true,
        public string|bool|null $group = false,
        public string|bool $validate = false,
        public ?string $locale = null,
        public ?string $currency = null,
        public ?int $precision = 2,
    ) {
        parent::__construct();

        // Fallback to app configuration/defaults if parameters not provided
        $this->locale ??= app()->getLocale();
        // Determine currency default from package config, falling back to USD
        $this->currency ??= config('x-form.currency');

        $format = $this->resolveMoneyFormat($this->locale, $this->currency);

        $this->symbol = $format['symbol'];
        $this->position = $format['position'];
        $this->decimalSeparator = $format['decimal_separator'];
        $this->thousandsSeparator = $format['thousands_separator'];

        // If precision was not explicitly specified as a parameter, use the resolved currency default
        $this->precision ??= $format['precision'];

        // Fallback to format-based placeholder if not provided
        if ($this->placeholder === null) {
            $integerPart = $this->thousandsSeparator ? '1' . $this->thousandsSeparator . '000' : '1000';
            if ($this->precision > 0) {
                $this->placeholder = $integerPart . $this->decimalSeparator . str_repeat('0', $this->precision);
            } else {
                $this->placeholder = $integerPart;
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('x-form::money');
    }
}
