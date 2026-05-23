<?php

namespace VkmApps\XForm\View\Components\Form;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;

class Disabled extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $value = null,
        public ?string $icon = null,
        public ?string $tooltip = null,
        public ?string $prepend = null,
        public ?string $append = null,
        public ?string $currency = null,
        public bool $copy = false,
        public bool $link = false,
        public bool $mail = false,
        public bool $phone = false,
        public bool $fax = false,
        public bool $map = false,
        public ?string $wrapper_tag = null,
        public array $wrapper_attributes = [],
    ) {
        $this->setIcon();
    }

    public ?string $copyText = null;

    private function setIcon(): void
    {
        if ($this->currency) {
            $symbol = $this->getCurrencyIcon();
            $rawSymbol = html_entity_decode($symbol, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $this->copyText = $rawSymbol . ' ' . $this->value;
            $this->value = "<span class=\"font-medium pe-1\">{$symbol}</span>" . $this->value;
        } else {
            $this->copyText = $this->value;
        }

        if (!$this->icon) {
            $this->icon = $this->getIconFromAttributes();
        }

        if ($this->icon) {
            $this->renderIcon();
        }

        $this->renderButton();
    }

    /**
     * Retrieve the icon value based on the attributes.
     *
     * @return string|null
     */
    private function getIconFromAttributes(): ?string
    {
        return match (true) {
            $this->copy => config('x-form.icons.copy'),
            $this->link => config('x-form.icons.link'),
            $this->mail => config('x-form.icons.mail'),
            $this->phone => config('x-form.icons.phone'),
            $this->fax => config('x-form.icons.fax'),
            $this->map => config('x-form.icons.map'),
            default => null,
        };
    }

    private function getCurrencyIcon(): ?string
    {
        return config("x-form.currency.currency.{$this->currency}", config('x-form.currency.currency.coins'));
    }

    /**
     * Render the icon as an <i> tag or use it directly.
     *
     * @return void
     */
    private function renderIcon(): void
    {
        // If it's not an HTML icon string, wrap it in an <i> tag.
        if (!Str::contains($this->icon, ['<', '>'])) {
            $this->icon = "<i class=\"$this->icon\"></i>";
        }
    }

    /**
     * Render the button (with proper link behavior) for different icon types.
     *
     * @return void
     */
    private function renderButton(): void
    {
        if ($this->copy) {
            $this->wrapper_tag = 'button';
            $this->wrapper_attributes = [
                'type' => 'button',
                'x-data' => '{ copied: false }',
                '@click' => "window.navigator.clipboard.writeText('" . addslashes($this->copyText) . "'); copied = true; setTimeout(() => copied = false, 1000);",
                'class' => config('x-form.disabled.action'),
                'aria-label' => "Click to Copy {$this->copyText}",
            ];
        } elseif ($this->link) {
            $this->wrapper_tag = 'a';
            $this->wrapper_attributes = [
                'href' => $this->value,
                'target' => '_blank',
                'class' => config('x-form.disabled.action'),
                'aria-label' => "Click to open {$this->value} to a new tab",
            ];
        } elseif ($this->mail) {
            $this->wrapper_tag = 'a';
            $this->wrapper_attributes = [
                'href' => 'mailto:' . $this->value,
                'class' => config('x-form.disabled.action'),
                'aria-label' => "Click to send email to {$this->value}",
            ];
        } elseif ($this->phone) {
            $this->wrapper_tag = 'a';
            $this->wrapper_attributes = [
                'href' => 'tel:' . $this->value,
                'class' => config('x-form.disabled.action'),
                'aria-label' => "Click to call phone number: $this->value",
            ];
        } elseif ($this->fax) {
            $this->wrapper_tag = 'a';
            $this->wrapper_attributes = [
                'href' => 'fax:' . $this->value,
                'class' => config('x-form.disabled.action'),
                'aria-label' => "Click to call fax number: {$this->value}",
            ];
        } elseif ($this->map) {
            $this->wrapper_tag = 'a';
            $this->wrapper_attributes = [
                'href' => 'http://maps.google.com/?q=' . urlencode($this->value),
                'target' => '_blank',
                'class' => config('x-form.disabled.action'),
                'aria-label' => "Click to view location on Google Maps",
            ];
        }
    }

    public function render(): View|Closure|string
    {
        return view('x-form::disabled');
    }
}
