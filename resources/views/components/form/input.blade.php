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
        {{ $prepend }}

        <input
            {{
                $attributes->class([
                    config('x-form.input'),
                    config('x-form.invalid') => $errors->has($rule),
                ])
                ->merge([
                    'id' => $uuid,
                    'type' => $type,
                    'name' => $name,
                    'wire:key' => $uuid,
                ])
            }}

            {{-- Accessibility attributes --}}
            @if($errors->has($rule))
                aria-invalid="true"
            aria-describedby="error-{{ $uuid }}"
            @endif

            {{-- Wire model conditionally based on live/blur/change attributes --}}
            @if($model)
                @if ($attributes->has('live'))
                    wire:model.live="{{ $model }}"
                @elseif ($attributes->has('change'))
                    wire:model.live.change="{{ $model }}"
                @elseif ($attributes->has('blur'))
                    wire:model.live.blur="{{ $model }}"
                @else
                    wire:model="{{ $model }}"
                @endif
            @endif

            {{-- Validate condition --}}
            @if ($validate)
                @if ($validate === 'blur')
                    @blur="validate"
                @else
                    @keyup="validate"
                @endif
            @endif
        />

        {{-- Append --}}
        {{ $append }}

        @if ($group)
    </div>
@endif

@error($rule)
<div id="error-{{ $uuid }}" class="{{ config('x-form.error') }}">{!! $message !!}</div>
@enderror
