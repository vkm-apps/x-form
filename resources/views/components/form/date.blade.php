<div wire:key="{{ $uuid }}">

    {{-- LABEL --}}
    @if ($label)
        <x-form.label
            :for="$uuid"
            :label="$label"
            :model="$model"
            :modifier="$attributes->has('live') || $attributes->has('blur')"
            :icon="$icon"
            :tooltip="$tooltip"
            :help="$help"
            :required="$required"
        />
    @endif

    @php
        $localeModifier = $locale !== 'en' ? '.' . $locale : '';
        $inputClass = trim(config('x-form.input') . ($errors->has($rule) ? ' ' . config('x-form.invalid', '') : ''));
    @endphp

    @if (!$range)
        {{-- ── SINGLE DATE PICKER ─────────────────────────────────────── --}}

        @if ($model)
            {{-- Livewire mode --}}
            <input
                x-datepicker{{ $localeModifier }}
                data-model="{{ $model }}"
                type="text"
                id="{{ $uuid }}"
                name="{{ $model }}"
                class="{{ $inputClass }}"
            />
        @else
            {{-- Plain form mode: visible text input + hidden ISO input --}}
            <input
                x-datepicker{{ $localeModifier }}
                data-name="{{ $name }}"
                type="text"
                id="{{ $uuid }}"
                class="{{ $inputClass }}"
            />
            <input type="hidden" name="{{ $name }}" />
        @endif

    @else
        {{-- ── RANGE DATE PICKER ──────────────────────────────────────── --}}
        <div class="flex gap-2">

            @if ($model)
                {{-- Livewire range mode: both inputs share data-model --}}
                <input
                    x-datepicker.range.start{{ $localeModifier }}
                    data-model="{{ $model }}"
                    data-range-group="{{ $uuid }}"
                    type="text"
                    id="{{ $uuid }}_start"
                    class="{{ $inputClass }}"
                />
                <input
                    x-datepicker.range.end{{ $localeModifier }}
                    data-model="{{ $model }}"
                    data-range-group="{{ $uuid }}"
                    type="text"
                    id="{{ $uuid }}_end"
                    class="{{ $inputClass }}"
                />
            @else
                {{-- Plain form range mode: each has its own hidden input --}}
                <input
                    x-datepicker.range.start{{ $localeModifier }}
                    data-name="{{ $name }}_start"
                    data-range-group="{{ $uuid }}"
                    type="text"
                    id="{{ $uuid }}_start"
                    class="{{ $inputClass }}"
                />
                <input type="hidden" name="{{ $name }}_start" />

                <input
                    x-datepicker.range.end{{ $localeModifier }}
                    data-name="{{ $name }}_end"
                    data-range-group="{{ $uuid }}"
                    type="text"
                    id="{{ $uuid }}_end"
                    class="{{ $inputClass }}"
                />
                <input type="hidden" name="{{ $name }}_end" />
            @endif

        </div>
    @endif

    {{-- VALIDATION ERROR --}}
    @error($rule)
    <div class="{{ config('x-form.error') }}">{!! $message !!}</div>
    @enderror

</div>
