<div wire:key="{{ $uuid }}">
    @if($label && !$isSingle)
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

    @error($rule)
        <div class="{{ config('x-form.error') }}">{!! $message !!}</div>
    @enderror

    @if($isSingle)
        <div class="{{ $layout }}">
            <div class="{{ config('x-form.checkbox.div') }}">
                <input
                    type="checkbox"
                    {{
                        $attributes->class([
                            config('x-form.checkbox.input'),
                            config('x-form.invalid') => $errors->has($rule)
                        ])
                        ->merge([
                            'id' => $uuid,
                            'name' => $name,
                            'wire:model' . $modifier => $model,
                            'wire:key' => $uuid,
                        ])
                    }}
                >

                <label
                    for="{{ $uuid }}"
                    class="{{ config('x-form.checkbox.label') }}"
                >
                   {!! config('x-form.checkbox.icon') !!}
                </label>

                @if($label)
                    <span class="{{ config('x-form.checkbox.title') }} flex items-center gap-1 select-none">
                        {{ $label }}

                        @if($required)
                            <span class="text-red-500">*</span>
                        @endif

                        @if($tooltip && !$help)
                            <span
                                class="flex items-center ml-1"
                                x-tooltip="{{ str($tooltip)->ucfirst() }}"
                                role="tooltip"
                                tabindex="0"
                            >{!! config('x-form.icons.info') !!}</span>
                        @endif

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
                    </span>
                @endif
            </div>
        </div>
    @else
        @if($total == 0)
            <div class="{{ config('x-form.checkbox.empty') }}">
                {{ __('0 :results found', ['results' => $label]) }}
            </div>
        @else
            <div class="{{ $layout }}">
                @foreach (collect($list)->chunk($perColumn) as $column)
                    <div
                        @class([
                            'w-full',
                            config('x-form.checkbox.horizontal') => $horizontal,
                            config('x-form.checkbox.vertical') => !$horizontal,
                       ])
                    >
                        @foreach ($column as $title => $id)
                            <div
                                @class([
                                    config('x-form.checkbox.div'),
                                ])
                            >
                                <input
                                    type="checkbox" value="{{ $id }}"
                                    {{
                                        $attributes->class([
                                            config('x-form.checkbox.input'),
                                            config('x-form.invalid') => $errors->has($rule)
                                        ])
                                        ->merge([
                                            'id' => str($name)->slug() . '-' . $id,
                                            'name' => $name,
                                            'wire:model' . $modifier => $model,
                                            'wire:key' => str($name)->slug() . '-' . $id,
                                        ])
                                    }}
                                >

                                <label
                                    for="{{ str($name)->slug() . '-' . $id }}"
                                    class="{{ config('x-form.checkbox.label') }}"

                                    @if($tooltipKey && isset($item))
                                        x-tooltip="{{ $item[$tooltipKey] }}"
                                    @endif
                                >
                                   {!! config('x-form.checkbox.icon') !!}
                                </label>
                                <span class="{{ config('x-form.checkbox.title') }}">
                                    {{ $title }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
