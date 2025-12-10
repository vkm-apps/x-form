<label
    for="{{ e($for) }}"
    @if($modifier && $model)
        wire:target="{{ $model }}"
    @endif
    {{
        $attributes->class([
            'flex items-center space-x-1',
            config('x-form.label'),
            config('x-form.required') => $required,
        ])
    }}
>
    {{-- Label icon --}}
    @if($icon)
        <i
            class="{{ $icon }} inline-block"
            aria-hidden="true"
            @if($modifier && $model) wire:loading.remove wire:target="{{ $model }}" @endif
        ></i>
    @endif

    {{-- Loading spinner --}}
    @if($modifier && $model)
        <svg
            wire:loading
            wire:target="{{ $model }}"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="inline-block size-4 lucide lucide-loader-circle-icon animate-spin"
        >
            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
        </svg>
    @endif

    {{-- Label text --}}
    {!! $label !!}

    {{-- Tooltip icon --}}
    @if($tooltip && !$help)
        <span
            class="flex items-center ml-1"
            x-tooltip="{{ str($tooltip)->ucfirst() }}"
            role="tooltip"
            tabindex="0"
        >{!! config('x-form.icons.info') !!}</span>
    @endif

    {{-- Help popover --}}
    @if($help && !$tooltip)
        <div x-popover.top class="flex items-center ml-1">
            <button type="button" data-trigger>
                {!! config('x-form.icons.info') !!}
            </button>

            <div class="popover p-2" data-popover role="dialog" aria-modal="true">
                {!! $help !!}
            </div>
        </div>
    @endif
</label>
