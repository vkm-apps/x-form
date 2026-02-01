<x-form.input
    :model="$model"
    :label="$label ?? null"
    :placeholder="$placeholder ?? null"
    :required="$required ?? false"
    :tooltip="$tooltip ?? null"
    :help="$help ?? null"
    :rule="$rule ?? null"
    :invalid="$invalid ?? false"
    :border="$border?? false"
    :group="true"
    :validate="$validate ?? false"
    class="rounded-r-none"
    @xform-set-url.window="if ($event.detail.uuid && $event.detail.uuid == 'file_manager_{{ $uuid }}') $wire.set('{{ $model }}', $event.detail.url, false)"
>
    <x-slot:append>
        <livewire:filemanager
            :key="'file_manager_' . $uuid"
            :uuid="'file_manager_' . $uuid"
        />
    </x-slot:append>
</x-form.input>
