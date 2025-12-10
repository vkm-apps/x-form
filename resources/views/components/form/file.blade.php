<div
    x-data="{
    isDragging: false,
    files: [],
    handleDrop(event) {
        this.isDragging = false;
        const droppedFiles = Array.from(event.dataTransfer.files);
        this.files = droppedFiles;
        this.$refs.file.files = event.dataTransfer.files;
        this.$refs.file.dispatchEvent(new Event('change', { bubbles: true }));
    },
    handleFileChange(event) {
        this.files = Array.from(event.target.files);
    }
}"
>
    @if($dropzone)
        <div class="flex items-center justify-center w-full">
            <label
                for="{{ $uuid }}"
                x-on:dragover.prevent="isDragging = true"
                x-on:dragleave.prevent="isDragging = false"
                x-on:drop.prevent="handleDrop"
                :class="{ 'bg-white/20 dark:bg-black/20 border-black/10': isDragging }"
                class="{{ config('x-form.upload.dropzone.button') }}"
            >
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    {!! config('x-form.upload.dropzone.icon') !!}
                    <p class="font-black text-lg {{ config('x-form.upload.dropzone.title') }}">{{ $label }}</p>
                    <template x-if="files.length === 0">
                        <p class="mb-2 {{ config('x-form.upload.dropzone.subtitle') }}">
                            Drop files here or click to browse
                        </p>
                    </template>

                    <template x-if="files.length > 0">
                        <ul class="mb-2 {{ config('x-form.upload.dropzone.subtitle') }} space-y-1">
                            <template x-for="file in files" :key="file.name">
                                <li x-text="file.name"></li>
                            </template>
                        </ul>
                    </template>
                    <p class="text-xs {{ config('x-form.upload.dropzone.subtitle') }}">{{ $help }}</p>
                </div>
                @elseif($button)
                    @if($label)
                        <span class="{{ config('x-form.label') }}">{!! $label !!}</span>
                    @endif

                    <button
                        type="button"
                        {{ $attributes->merge([
                                'class' => 'px-3 py-2 bg-zinc-200 dark:bg-zinc-900 rounded-md flex items-center gap-2 hover:cursor-pointer hover:opacity-80'
                            ])
                        }}
                        x-on:click="$refs.file.click()"
                        aria-label="{{ __('Choose File') }}"
                    >
                        {{ $button }}
                    </button>
                @else
                    {{ $slot }}
                @endif

                <input
                    x-ref="file"
                    x-on:change="handleFileChange"
                    type="file"
                    {{
                        $attributes
                            ->class([
                                config('x-form.upload.button') => !$dropzone && !$button,
                                'hidden' => $dropzone || $button
                            ])
                            ->merge([
                                'id' => $uuid,
                                'name' => $name,
                                'wire:model' . $modifier => $model,
                                'wire:key' => $uuid,
                            ])
                    }}

                    @if($tooltip && !$label)
                        x-tooltip="{{ $tooltip }}"
                    @endif

                    {{ $multiple }}
                />

                @if($dropzone)
            </label>
        </div>
    @endif
</div>

{{ $append }}
