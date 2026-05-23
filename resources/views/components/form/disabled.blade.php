{{-- Label as stylized text (not a <label>) --}}
@if($label)
    <div class="{{ config('x-form.label') }}">
        {{ $label }}
    </div>
@endif

{{-- Disabled Component Wrapper --}}
<div class="{{ config('x-form.disabled.class') }}">
    {{-- Prepend --}}
    @if($prepend)
        {{ $prepend }}
    @endif

    {{-- Fallback: Standard Disabled Block --}}
    @php
        if ($copy ?? false) {
            $valueHtml = '<span x-show="!copied">' . ($slot->isNotEmpty() ? $slot : $value) . '</span>' .
                         '<span x-cloak x-show="copied" class="text-emerald-600 dark:text-emerald-400">Copied to clipboard</span>';
        } else {
            $valueHtml = ($slot->isNotEmpty() ? $slot : $value);
        }

        $content = '<div class="flex items-center">'
            . ($icon ? $icon . '<div class="' . config('x-form.disabled.divider') . '"></div>' : '')
            . $valueHtml
            . '</div>';
    @endphp

    @if($wrapper_tag)
        <{{ $wrapper_tag }}
            @foreach($wrapper_attributes as $attr => $val)
                {!! $attr !!}="{{ $val }}"
            @endforeach
            >
            {!! $content !!}
        </{{ $wrapper_tag }}>
    @else
        {!! $content !!}
    @endif

    {{-- Append --}}
    {{ $append }}
</div>

