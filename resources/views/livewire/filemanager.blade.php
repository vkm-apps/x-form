<div
    x-data="{
        uuid: '{{ $uuid }}',
        open: false,
        files: @entangle('files'),
        image_selected: false,
        current_path: @entangle('current_path'),
        standalone: @js($standalone),
        error: @entangle('error') ?? null,
        isSubfolder() {
            this.current_path = this.current_path.replace(/\\/g, '/');
            return this.current_path && this.current_path !== '/';
        },
        confirmAndCreateFolder() {
            const folder_name = prompt(
                'Enter the folder name:\n' +
                '(Note: spaces and special characters will be replaced with dashes. ' +
                'For example, My New Folder will become my-new-folder)'
            );

            if (folder_name && folder_name.trim() !== '') {
                $wire.set('folder_name', folder_name.trim());
            }
        }
    }"
    wire:ignore
>
    <button
        type="button"
        @click="
            if (!standalone) image.init();
            $wire.loadGallery();
            open = true;
        "
        class="flex items-center"
    >
        <div
            @class([
                'text-black dark:text-white hover:cursor-pointer',
                'rounded-r-xl p-3 w-full h-full bg-black/10 dark:bg-white/10 text-black dark:text-white hover:opacity-80 hover:cursor-pointer' => $uuid,
                'p-2 hover:bg-black/5 dark:hover:bg-white/5 rounded-sm' => !$uuid,
            ])
            @unless($uuid)
                x-tooltip="Open Media Manager"
            @endunless
        >
            {!! config('x-form.icons.folder') !!}
        </div>
    </button>

    {{-- FILE MANAGER MODAL --}}
    <div class="fixed inset-0 backdrop-blur-lg flex justify-center items-center z-100" x-show="open" @close-modal="open = false" x-cloak>
        <div class="relative bg-white/90 dark:bg-black/90 p-4 rounded-lg border border-black/10 shadow-lg w-3/4 min-h-2/4">
            {{-- LOADING SPINNER --}}
            <div
                wire:loading.class.remove="hidden"
                wire:loading.class="flex"
                class="hidden opacity-80 absolute inset-0 gap-2 items-center justify-center bg-white/50 dark:bg-black/50 backdrop-blur-lg rounded-lg z-10"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="animate-spin w-10 text-black dark:text-white"
                >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10 -10 10s-10 -4.477 -10 -10s4.477 -10 10 -10zm6 9a1 1 0 0 0 -1 1a5 5 0 0 1 -5 5a1 1 0 0 0 0 2a7 7 0 0 0 7 -7a1 1 0 0 0 -1 -1z" />
                </svg>

                <p class="text-xs capitalize font-medium text-black dark:text-white">{{ __('please wait...') }}</p>
            </div>

            <div x-show="!image_selected">
                <div class="w-full flex items-center justify-between max-sm:flex-col max-sm:items-start gap-2">
                    {{-- BACK BUTTON ON FOLDERS --}}
                    <div class="flex items-center gap-4">
                        <button
                            type="button"
                            x-show="isSubfolder()"
                            @click="$wire.goBack()"
                            class="float-left p-1 rounded-sm bg-black/10 dark:bg-white/10 text-black/90 dark:text-white/90 hover:cursor-pointer hover:opacity-80"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="size-5" fill="currentColor"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg>
                        </button>

                        <div class="flex items-center gap-2">
                            <span class="text-xs bg-black/10 dark:bg-white/5 text-black/90 dark:text-white/90 rounded py-1.5 overflow-hidden">
                                <span class="font-medium bg-black/5 dark:bg-white/10  py-2 px-2">DISK: </span>
                                <span class="px-2" x-text="$wire.disk_name"></span>
                            </span>

                            <span class="text-xs bg-black/10 dark:bg-white/5 text-black/90 dark:text-white/90 rounded py-1.5 overflow-hidden">
                                <span class="font-medium bg-black/5 dark:bg-white/10 py-2 px-2">PATH: </span>
                                <span class="px-2" x-text="current_path"></span>
                            </span>
                        </div>
                    </div>

                    {{-- CREATE NEW FOLDER --}}
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            class="flex items-center justify-center align-middle text-xs px-3 py-1.5 rounded-sm bg-black/10 dark:bg-white/10 text-black/90 dark:text-white/90 font-medium  hover:cursor-pointer hover:opacity-80"
                            @click="confirmAndCreateFolder();"
                        >
                            📁 {{ __('New Folder') }}
                        </button>

                        {{-- UPLOAD FILE --}}
                        <button
                            type="button"
                            class="flex items-center justify-center align-middle text-xs px-3 py-1.5 rounded-sm bg-black/10 dark:bg-white/10 text-black/90 dark:text-white/90 font-medium  hover:cursor-pointer hover:opacity-80"
                            @click="$refs.fileInput.click();"
                        >
                            ⬆️ {{ __('Upload File') }}
                        </button>

                        <input
                            type="file"
                            x-ref="fileInput"
                            wire:model="media_file"
                            class="hidden"
                            accept="{{ $this->allowed_mime_types }}"
                        />

                        {{-- DELETE DIRECTORY --}}
                        <button
                            type="button"
                            @click="
                                if (confirm('Deleting a folder will delete all content including all sub folders and files. Are you sure?')) {
                                    $wire.deleteDirectory();
                                }
                            "
                            x-show="isSubfolder()"
                            class="flex items-center justify-center align-middle text-xs px-3 py-1.5 rounded-sm bg-black/10 dark:bg-white/10 text-black/90 dark:text-white/90 font-medium hover:cursor-pointer hover:opacity-80"
                        >
                            🗑️ {{ __('Delete Directory') }}
                        </button>

                        {{-- CLOSE FILE MANAGER --}}
                        <button
                            type="button"
                            @click="open = false"
                            class="p-1 rounded-sm bg-black/10 dark:bg-white/10 text-black/90 dark:text-white/90  hover:cursor-pointer hover:opacity-80"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 -960 960 960" fill="currentColor"><path d="m336-280-56-56 144-144-144-143 56-56 144 144 143-144 56 56-144 143 144 144-56 56-143-144-144 144Z"/></svg>
                        </button>
                    </div>
                </div>

                {{-- ERROR DISPLAY --}}
                <template x-if="error">
                    <div class="w-full text-sm bg-red-200 text-red-800 rounded p-2 my-2">
                        File error: <span x-text="error"></span>
                    </div>
                </template>

                {{-- FILE LIST --}}
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-8 max-h-[90vh] overflow-y-auto">
                    <template x-for="file in files" :key="file.name">
                        <div class="w-full">
                            {{-- FOLDERS --}}
                            <template x-if="file.type === 'folder'" :title="file.name">
                                <button
                                    type="button"
                                    @click="$wire.loadGallery(file.path)"
                                    class="w-full aspect-square group hover:cursor-pointer"
                                >
                                    <div class="relative w-full h-full flex flex-col justify-between">
                                        <div class="flex flex-col flex-1 px-3 py-2 relative group-hover:opacity-80">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="w-full fill-amber-400 icon icon-tabler icons-tabler-filled icon-tabler-folder"
                                            >
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9 3a1 1 0 0 1 .608 .206l.1 .087l2.706 2.707h6.586a3 3 0 0 1 2.995 2.824l.005 .176v8a3 3 0 0 1 -2.824 2.995l-.176 .005h-14a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-11a3 3 0 0 1 2.824 -2.995l.176 -.005h4z" />
                                            </svg>
                                        </div>

                                        <div class="w-full absolute bottom-2 text-sm truncate">
                                            <span x-text="file.name" class="group-hover:underline"></span>
                                        </div>
                                    </div>
                                </button>
                            </template>

                            {{-- FILES --}}
                            <template x-if="file.type === 'file'">
                                <div x-data="{ visible: false }" :title="file.name">
                                    <div
                                        class="w-full aspect-square rounded-lg bg-black/5 dark:bg-white/10 opacity-80 hover:opacity-100 group"
                                        x-intersect:enter="visible = true"
                                        x-intersect:leave="visible = false"
                                    >
                                        <template x-if="visible">
                                            <div class="w-full h-full flex flex-col justify-between">
                                                <div class="p-2 flex flex-none basis-12 items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 lucide lucide-file-icon lucide-file"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/></svg>
                                                    <span
                                                        x-text="file.name"
                                                        class="w-full text-xs text-black dark:text-white opacity-80 text-ellipsis overflow-hidden whitespace-nowrap group-hover:overflow-none group-hover:break-all group-hover:whitespace-normal"
                                                    ></span>
                                                </div>

                                                <div class="flex flex-1 px-3 py-2 relative">
                                                    <div class="w-full h-full flex flex-col justify-start gap-1 mt-2">
                                                        <div class="h-1 bg-gray-300 rounded w-3/4"></div>
                                                        <div class="h-1 bg-gray-300 rounded w-2/3"></div>
                                                        <div class="h-1 bg-gray-300 rounded w-1/2"></div>
                                                        <div class="h-1 bg-gray-300 rounded w-5/6"></div>
                                                        <div class="h-1 bg-gray-300 rounded w-2/4"></div>
                                                        <div class="h-1 bg-gray-300 rounded w-3/4"></div>
                                                        <div class="h-1 bg-gray-300 rounded w-3/5"></div>
                                                        <div class="h-1 bg-gray-300 rounded w-4/6"></div>
                                                    </div>
                                                </div>

                                                <div class="relative p-2 flex flex-none items-center justify-between text-xs">
                                                    <div class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                                                        <span class="text-black dark:text-white opacity-70" x-text="file.modified_at"></span>
                                                    </div>

                                                    <div x-data="{ openDropdown: false }">
                                                        <button
                                                            type="button"
                                                            x-ref="dropdownButton"
                                                            class="bg-black/10 dark:bg-white/10 dark:text-white/50 flex size-6 rounded-full align-middle items-center justify-center p-1 hover:cursor-pointer hover:opacity-80"
                                                            @click="openDropdown = !openDropdown"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                                        </button>

                                                        <div
                                                            x-show="openDropdown"
                                                            x-anchor="$refs.dropdownButton"
                                                            @click.outside="openDropdown = false"
                                                            x-transition:enter="transition ease-out duration-200"
                                                            x-transition:enter-start="opacity-0 scale-90"
                                                            x-transition:enter-end="opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-150"
                                                            x-transition:leave-start="opacity-100 scale-100"
                                                            x-transition:leave-end="opacity-0 scale-90"
                                                            class="mt-2 w-48 bg-white/70 dark:bg-black/70 backdrop-blur-lg rounded-lg shadow-lg ring-1 ring-black/5 dark:ring-white/10 overflow-hidden z-50"
                                                        >
                                                            <button
                                                                type="button"
                                                                role="button"
                                                                class="w-full block px-4 py-2 text-black/80 dark:text-white/80 hover:bg-black/5 dark:hover:bg-white/10 hover:cursor-pointer"
                                                                @click="
                                                                    if (!standalone) image.insertFile(file.url);
                                                                    if (standalone) $dispatch('xform-set-url', {url: file.url, uuid: uuid});
                                                                    open = false
                                                                "
                                                            >
                                                                {{ __('Insert Link') }}
                                                            </button>

                                                            <button
                                                                type="button"
                                                                role="button"
                                                                class="w-full block px-4 py-2 text-black/80 dark:text-white/80 hover:bg-black/5 dark:hover:bg-white/10 hover:cursor-pointer"
                                                                @click="if (confirm('Are you sure you want to delete the file?')) {
                                                                    $wire.deleteSelectedFile(file.path)
                                                                }"
                                                            >
                                                                {{ __('Delete File') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            {{-- IMAGES --}}
                            <template x-if="file.type === 'image'">
                                <div x-data="{ visible: false }" :title="file.name">
                                    <div
                                        class="w-full aspect-square rounded-lg bg-black/5 dark:bg-white/10 opacity-80 hover:opacity-100"
                                        x-intersect:enter="visible = true"
                                        x-intersect:leave="visible = false"
                                    >
                                        <template x-if="visible">
                                            <div class="w-full h-full flex flex-col justify-between group">
                                                <div class="p-2 flex flex-none basis-12 items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 lucide lucide-image-icon lucide-image"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                                    <span
                                                        x-text="file.name"
                                                        class="w-full text-xs text-black dark:text-white opacity-80 text-ellipsis overflow-hidden whitespace-nowrap group-hover:overflow-none group-hover:break-all group-hover:whitespace-normal"
                                                    ></span>
                                                </div>

                                                <div class="relative flex-1 overflow-hidden relative">
                                                    <img
                                                        :src="file.url"
                                                        class="absolute inset-0 w-full h-full object-cover"
                                                    />
                                                </div>

                                                <div class="relative p-2 flex flex-none items-center justify-between text-xs">
                                                    <div class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                                                        <span class="text-black dark:text-white opacity-70" x-text="file.modified_at"></span>
                                                    </div>

                                                    <div x-data="{ openDropdown: false }">
                                                        <button
                                                            type="button"
                                                            x-ref="dropdownButton"
                                                            class="bg-black/10 dark:bg-white/10 dark:text-white/50 flex size-6 rounded-full align-middle items-center justify-center p-1 hover:cursor-pointer hover:opacity-80"
                                                            @click="openDropdown = !openDropdown"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                                        </button>

                                                        <div
                                                            x-show="openDropdown"
                                                            x-anchor="$refs.dropdownButton"
                                                            @click.outside="openDropdown = false"
                                                            x-transition:enter="transition ease-out duration-200"
                                                            x-transition:enter-start="opacity-0 scale-90"
                                                            x-transition:enter-end="opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-150"
                                                            x-transition:leave-start="opacity-100 scale-100"
                                                            x-transition:leave-end="opacity-0 scale-90"
                                                            class="mt-2 w-48 bg-white/70 dark:bg-black/70 backdrop-blur-lg rounded-lg shadow-lg ring-1 ring-black/5 dark:ring-white/10 overflow-hidden z-50"
                                                        >
                                                            <button
                                                                type="button"
                                                                role="button"
                                                                class="w-full block px-4 py-2 text-black/80 dark:text-white/80 hover:bg-black/5 dark:hover:bg-white/10 hover:cursor-pointer"
                                                                @click="
                                                                    $dispatch('edit-image', {url: file.url, path: file.path});
                                                                    if (standalone) $dispatch('xform-set-url', {url: file.url, uuid: uuid});
                                                                    open = false
                                                                "
                                                                x-text="standalone ? '{{ __('Insert Link') }}' : '{{ __('Select Image') }}'"
                                                            >
                                                            </button>

                                                            <button
                                                                type="button"
                                                                role="button"
                                                                class="w-full block px-4 py-2 text-black/80 dark:text-white/80 hover:bg-black/5 dark:hover:bg-white/10 hover:cursor-pointer"
                                                                @click="if (confirm('Are you sure you want to delete the file?')) {
                                                                    $wire.deleteSelectedFile(file.path)
                                                                }"
                                                            >
                                                                {{ __('Delete File') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
