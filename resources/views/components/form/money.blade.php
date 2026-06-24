{{-- Label --}}
@if ($label)
    <x-form.label
        :for="$uuid"
        :label="$label"
        :model="$model"
        :modifier="$attributes->has('live') || $attributes->has('blur') || $attributes->has('change')"
        :icon="$icon"
        :tooltip="$tooltip"
        :help="$help"
        :required="$required"
    />
@endif

@if ($group)
    <div
        @class([
            'flex items-center',
            'text-sm' => $group == 'sm',
            'text-lg' => $group == 'lg',
            'text-xl' => $group == 'xl',
        ])
    >
@endif

{{-- Prepend --}}
{{ $prepend ?? '' }}

@php
    $is_live = $attributes->has('live') ?? $attributes->has('blur') ?? $attributes->has('change');
@endphp

<div
    wire:key="{{ $uuid }}_container"
    x-data="{
        displayValue: '',
        rawValue: null,
        decimalSeparator: '{{ $decimalSeparator }}',
        thousandsSeparator: '{{ $thousandsSeparator }}',
        precision: {{ $precision }},

        init() {
            let raw = this.$wire.get('{{ $model }}');
            this.rawValue = raw ? parseFloat(raw) : null;
            this.syncDisplay(this.rawValue);
        },

        syncDisplay(num) {
            if (num === null || num === undefined || isNaN(num)) {
                this.displayValue = '';
                return;
            }
            this.displayValue = this.formatNumber(num);
        },

        formatNumber(num) {
            let parts = num.toFixed(this.precision).split('.');
            let integerPart = parts[0];
            let decimalPart = parts[1] || '';
            if (this.thousandsSeparator) {
                integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, this.thousandsSeparator);
            }
            return decimalPart ? integerPart + this.decimalSeparator + decimalPart : integerPart;
        },

        parseFloatValue(val) {
            if (val === null || val === undefined || val === '') return null;
            let cleaned = String(val);
            if (this.thousandsSeparator) {
                let esc = this.thousandsSeparator.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                cleaned = cleaned.replace(new RegExp(esc, 'g'), '');
            }
            if (this.decimalSeparator && this.decimalSeparator !== '.') {
                cleaned = cleaned.replace(this.decimalSeparator, '.');
            }
            let parsed = parseFloat(cleaned);
            return isNaN(parsed) ? null : parsed;
        },

        onInput(e) {
            let parsed = this.parseFloatValue(e.target.value);
            this.rawValue = parsed;
            this.$wire.set('{{ $model }}', parsed, '{{ $is_live }}');
        },

        onBlur() {
            let parsed = this.parseFloatValue(this.displayValue);
            this.rawValue = parsed;
            this.displayValue = parsed !== null ? this.formatNumber(parsed) : '';
            this.$wire.set('{{ $model }}', parsed, '{{ $is_live }}');
        }
    }"
    class="relative w-full flex items-center"
>
    {{-- Hidden input for traditional form submissions --}}
    <input
        type="hidden"
        id="{{ $uuid }}"
        name="{{ $name }}"
        :value="rawValue"
    />

    {{-- Symbol Prefix --}}
    @if($position === 'prefix')
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 z-1">
            <span class="text-sm text-black/80 dark:text-white/60 select-none">{!! $symbol !!}</span>
        </div>
    @endif

    {{-- Visible Text Input with Mask --}}
    <input
        {{
            $attributes->whereDoesntStartWith('wire:model')
            ->class([
                config('x-form.input'),
                config('x-form.invalid') => $errors->has($rule),
            ])
            ->merge([
                'type' => 'text',
                'wire:key' => $uuid . '_visible',
                'placeholder' => $placeholder,
            ])
        }}
        x-model="displayValue"
        x-mask:dynamic="$money($input, decimalSeparator, thousandsSeparator, precision)"
        @input="onInput"
        @blur="onBlur(){{ $validate === 'blur' ? '; validate()' : '' }}"
        style="
            @if($position === 'prefix') padding-left: {{ max(1.5, mb_strlen(html_entity_decode($symbol, ENT_QUOTES, 'UTF-8')) * 0.7 + 1) }}rem; @endif
            @if($position === 'suffix') padding-right: {{ max(1.5, mb_strlen(html_entity_decode($symbol, ENT_QUOTES, 'UTF-8')) * 0.7 + 1) }}rem; @endif
        "

        {{-- Accessibility attributes --}}
        @if($errors->has($rule))
            aria-invalid="true"
            aria-describedby="error-{{ $uuid }}"
        @endif

        {{-- Validate condition (keyup only; blur validation is combined in @blur above) --}}
        @if ($validate && $validate !== 'blur')
            @keyup="validate"
        @endif
    />

    {{-- Symbol Suffix --}}
    @if($position === 'suffix')
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <span class="text-sm text-black/50 dark:text-white/60 select-none">{!! $symbol !!}</span>
        </div>
    @endif
</div>

{{-- Append --}}
{{ $append ?? '' }}

@if ($group)
    </div>
@endif

@error($rule)
    <div id="error-{{ $uuid }}" class="{{ config('x-form.error') }}">{!! $message !!}</div>
@enderror
