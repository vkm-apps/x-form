@props(['icon_size' => 'size-5'])

<div
    wire:submit.prevent="save" class="p-4"
    x-data="editor('{{ $uuid }}', '{{ $model }}', $wire, '{{ $watchFor }}')"
    @edit-image="image.openImageEditor($event)"
    @insert-image="image.insertImage($event)"
    wire:ignore.self
>
    @if($label)
        <div class="{{ config('x-form.label') }}">{{ $label }}</div>
    @endif

    {{-- ACTIONS --}}
    <div
        class="flex flex-wrap space-x-2 items-center bg-black/5 dark:bg-white/10 px-3 border border-black/5 dark:border-white/20 border-b-0 shadow rounded-t-md"
        x-cloak
    >
        {{-- PARAGRAPH --}}
        <button
            type="button"
            @click="action.paragraph(), open = false"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Paragraph Format') }}"
        >
            <x-form.icon name="paragraph" :class="$icon_size" />
        </button>

        {{-- HEADINGS --}}
        <div x-data="{ open: false }" @click.outside="open = false">
            <button
                type="button"
                x-ref="button"
                @click="open = ! open"
                class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
                title="{{ __('Change headings (H1,H2,H3...)') }}"
            >
                <x-form.icon name="headings" :class="$icon_size" />
            </button>

            <div
                x-show="open"
                x-anchor="$refs.button"
                class="bg-white shadow-lg border border-gray-200 rounded-sm flex flex-col"
            >
                <template x-for="h in [1,2,3,4,5,6]" :key="h">
                    <button
                        type="button"
                        @click="action.heading(h), open = false"
                        class="w-full text-sm px-5 py-1 hover:bg-gray-100 hover:cursor-pointer"
                        :style="{ 'font-size': (30 - (h/0.3)) + 'px' }"
                    >
                        Heading <span x-text="h"></span>
                    </button>
                </template>
            </div>
        </div>

        {{-- TEXT CASE CHANGE --}}
        <div x-data="{ open: false }" @click.outside="open = false">
            <button
                type="button"
                x-ref="button"
                @click="open = ! open"
                class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
                title="{{ __('Text Cases') }}"
            >
                <x-form.icon name="textcase" class="size-6" />
            </button>

            <div
                x-show="open"
                x-anchor="$refs.button"
                class="bg-white shadow-lg border border-gray-200 rounded-sm flex flex-col"
            >
                <button
                    type="button"
                    @click="action.uppercase(), open = false"
                    class="w-full text-sm px-5 py-1 hover:bg-gray-100 hover:cursor-pointer"
                >UPPERCASE
                </button>
                <button
                    type="button"
                    @click="action.lowercase(), open = false"
                    class="w-full text-sm px-5 py-1 hover:bg-gray-100 hover:cursor-pointer"
                >lowercase
                </button>
                <button
                    type="button"
                    @click="action.titlecase(), open = false"
                    class="w-full text-sm px-5 py-1 hover:bg-gray-100 hover:cursor-pointer"
                >Title Case
                </button>
            </div>
        </div>

        {{-- FONT SIZE --}}
        <div x-data="{ open: false }" @click.outside="open = false">
            <button
                type="button"
                x-ref="button"
                @click="open = ! open"
                class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
                title="{{ __('Text Size') }}"
            >
                <x-form.icon name="fontsize" :class="$icon_size" />
            </button>

            <div
                x-show="open"
                x-anchor="$refs.button"
                class="bg-white shadow-lg border border-gray-200 rounded-sm flex flex-col"
            >
                <template x-for="px in [10,12,14,16,18,20,22]" :key="px">
                    <button
                        type="button"
                        @click="action.fontsize(px), open = false"
                        class="w-full px-5 py-1 hover:bg-gray-100 hover:cursor-pointer"
                        :style="{ 'font-size': px + 'px' }"
                    >
                        <span x-text="px"></span>px
                    </button>
                </template>
            </div>
        </div>

        {{-- BOLD --}}
        <button
            type="button"
            @click="action.toggleBold()"
            :class="{'bg-gray-300': action.isBold}"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Bold') }}"
        >
            <x-form.icon name="bold" :class="$icon_size" />
        </button>

        {{-- ITALIC --}}
        <button
            type="button"
            @click="action.toggleItalic()"
            :class="{'bg-gray-300': action.isItalic}"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Italic') }}"
        >
            <x-form.icon name="italic" :class="$icon_size" />
        </button>

        {{-- UNDERLINE --}}
        <button
            type="button"
            @click="action.toggleUnderline()"
            :class="{'bg-gray-300': action.isUnderline}"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Underline') }}"
        >
            <x-form.icon name="underline" :class="$icon_size" />
        </button>

        {{-- STRIKETHROUGH --}}
        <button
            type="button"
            @click="action.toggleStrikethrough()"
            :class="{'bg-gray-300': action.isStrikethrough}"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Strikethrough') }}"
        >
            <x-form.icon name="strikethrough" :class="$icon_size" />
        </button>

        {{-- FONT SUPERSCRIPT --}}
        <button
            type="button"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            @click="action.toggleSuperscript()"
            title="{{ __('Superscript') }}"
        >
            <x-form.icon name="superscript" :class="$icon_size" />
        </button>

        {{-- FONT SUBSCRIPT --}}
        <button
            type="button"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            @click="action.toggleSubscript()"
            title="{{ __('Subscript') }}"
        >
            <x-form.icon name="subscript" :class="$icon_size" />
        </button>

        {{-- CODE --}}
        <button
            type="button"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            @click="action.toggleFormat('code')"
            title="{{ __('Code Block') }}"
        >
            <x-form.icon name="code" :class="$icon_size" />
        </button>

        <div>
            {{-- TEXT COLOR --}}
            <button
                id="{{ $uuid }}_text_picker"
                type="button" @click="color.openColorPicker($el, 'text')"
                class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
                x-ref="text_picker"
                title="{{ __('Text Color') }}"
            >
                <x-form.icon name="textcolor" :class="$icon_size" />
            </button>

            {{-- BG COLOR --}}
            <button
                id="{{ $uuid }}_bg_picker"
                type="button" @click="color.openColorPicker($el, 'background')"
                class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
                x-ref="bg_picker"
                title="{{ __('Background Color') }}"
            >
                <x-form.icon name="backgroundcolor" :class="$icon_size" />
            </button>
        </div>

        {{-- TEXT ALIGNMENT --}}
        <div x-data="{ open: false }" @click.outside="open = false">
            <button
                type="button"
                x-ref="button"
                @click="open = ! open"
                class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
                title="{{ __('Text Alignment') }}"
            >
                <x-form.icon name="alignment" :class="$icon_size" />
            </button>

            <div
                x-show="open"
                x-anchor="$refs.button"
                class="bg-white shadow-lg border border-gray-200 rounded-sm flex flex-col"
            >
                <button
                    type="button"
                    @click="action.alignLeft(), open = false"
                    class="w-full px-5 py-1 hover:bg-gray-100 hover:cursor-pointer"
                >
                    <x-form.icon name="alignleft" :class="$icon_size" />
                </button>

                <button
                    type="button"
                    @click="action.alignCenter(), open = false"
                    class="w-full px-5 py-1 hover:bg-gray-100 hover:cursor-pointer"
                >
                    <x-form.icon name="aligncenter" :class="$icon_size" />
                </button>

                <button
                    type="button"
                    @click="action.alignRight(), open = false"
                    class="w-full px-5 py-1 hover:bg-gray-100 hover:cursor-pointer"
                >
                    <x-form.icon name="alignright" :class="$icon_size" />
                </button>
            </div>
        </div>

        {{-- DECREASE INDENT --}}
        {{--            <button--}}
        {{--                type="button"--}}
        {{--                @click="action.changeIndent(false)"--}}
        {{--                class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm flex items-center gap-1 text-sm"--}}
        {{--                title="{{ __('Decrease Indent') }}"--}}
        {{--            >--}}
        {{--                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $icon_size }}" viewBox="0 -960 960 960" fill="currentColor"><path d="M120-120v-80h720v80H120Zm320-160v-80h400v80H440Zm0-160v-80h400v80H440Zm0-160v-80h400v80H440ZM120-760v-80h720v80H120Zm160 440L120-480l160-160v320Z"/></svg>--}}
        {{--            </button>--}}

        {{-- INCREASE INDENT --}}
        {{--            <button--}}
        {{--                type="button"--}}
        {{--                @click="action.changeIndent(true)"--}}
        {{--                class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm flex items-center gap-1 text-sm"--}}
        {{--                title="{{ __('Increase Indent') }}"--}}
        {{--            >--}}
        {{--                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $icon_size }}" viewBox="0 -960 960 960" fill="currentColor"><path d="M120-120v-80h720v80H120Zm320-160v-80h400v80H440Zm0-160v-80h400v80H440Zm0-160v-80h400v80H440ZM120-760v-80h720v80H120Zm0 440v-320l160 160-160 160Z"/></svg>--}}
        {{--            </button>--}}

        {{-- BULLETED LIST --}}
        <button
            type="button"
            @click="action.toggleList('ul', 'disc')"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Bullet List') }}"
        >
            <x-form.icon name="ul" :class="$icon_size" />
        </button>

        {{-- NUMBERED LIST --}}
        <button
            type="button"
            @click="action.toggleList('ol', 'decimal')"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Numbered List') }}"
        >
            <x-form.icon name="ol" :class="$icon_size" />
        </button>

        <button
            type="button"
            @click="action.toggleList('ol', 'lower-alpha')"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Letter List') }}"
        >
            <x-form.icon name="letter_list" :class="$icon_size" />
        </button>

        {{-- TABLE --}}
        <button
            type="button"
            x-ref="tableBtn"
            @click="table.insert()"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Insert Table') }}"
        >
            <x-form.icon name="table" :class="$icon_size" />
        </button>

        <div
            x-show="table.showModal"
            x-transition.opacity.scale
            class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-1000"
            x-cloak
        >
            <div class="bg-white w-full max-w-7xl max-h-screen rounded-xl shadow-xl p-6 space-y-6 overflow-auto">
                <!-- ROW 1: rows + columns -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm font-medium">Table Style</label>
                        <select
                            x-model="table.tableStyle"
                            @change="table.updateTableClasses()"
                            class="{{ config('x-form.dropdown.input') }}"
                        >
                            <option value="basic">Basic</option>
                            <option value="bordered">Bordered</option>
                            <option value="striped-rows">Striped Rows</option>
                            <option value="striped-columns">Striped Columns</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Columns</label>
                        <input
                            type="number" min="1"
                            x-model.number="table.colCount"
                            @input="table.generateColumns()"
                            class="{{ config('x-form.input') }}"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">Rows</label>
                        <input
                            type="number" min="1"
                            x-model.number="table.rows"
                            @input="table.generateColumns()"
                            class="{{ config('x-form.input') }}"
                        >
                    </div>
                </div>

                <!-- ROW 2: classes + styles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                    <div><label>Table Classes</label><input
                            placeholder="table classes"
                            x-model="table.customClasses.table"
                            class="{{ config('x-form.input') }}"
                        /></div>
                    <div><label>Table Styles</label><input
                            placeholder="table styles"
                            x-model="table.customStyles.table"
                            class="{{ config('x-form.input') }}"
                        /></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                    <div><label>Thead Classes</label><input
                            placeholder="thead classes"
                            x-model="table.customClasses.thead"
                            class="{{ config('x-form.input') }}"
                        /></div>
                    <div><label>Thead Styles</label><input
                            placeholder="thead styles"
                            x-model="table.customStyles.thead"
                            class="{{ config('x-form.input') }}"
                        /></div>
                    <div><label>Th Classes</label><input
                            placeholder="th classes"
                            x-model="table.customClasses.th"
                            class="{{ config('x-form.input') }}"
                        /></div>
                    <div><label>Th Styles</label><input
                            placeholder="th styles"
                            x-model="table.customStyles.th"
                            class="{{ config('x-form.input') }}"
                        /></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                    <div><label>Tbody Classes</label><input
                            placeholder="tbody classes"
                            x-model="table.customClasses.tbody"
                            class="{{ config('x-form.input') }}"
                        /></div>
                    <div><label>Tbody Styles</label><input
                            placeholder="tbody styles"
                            x-model="table.customStyles.tbody"
                            class="{{ config('x-form.input') }}"
                        /></div>
                    <div><label>Td Classes</label><input
                            placeholder="td classes"
                            x-model="table.customClasses.td"
                            class="{{ config('x-form.input') }}"
                        /></div>
                    <div><label>Td Styles</label><input
                            placeholder="td styles"
                            x-model="table.customStyles.td"
                            class="{{ config('x-form.input') }}"
                        /></div>
                </div>

                <!-- PREVIEW -->
                <div>
                    <h3 class="text-sm font-medium mb-2">Preview</h3>

                    <div class="overflow-auto">
                        <table :class="table.customClasses.table" :style="table.customStyles.table">
                            <thead :class="table.customClasses.thead" :style="table.customStyles.thead">
                                <tr :class="table.customClasses.tr">
                                    <template x-for="(col, i) in table.columns.header" :key="i">
                                        <th :class="table.customClasses.th" :style="table.customStyles.th">
                                            <input
                                                type="text"
                                                x-model="table.columns.header[i]"
                                                class="w-full bg-transparent outline-none"
                                                placeholder="Enter Title"
                                            >
                                        </th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody :class="table.customClasses.tbody" :style="table.customStyles.tbody">
                                <template x-for="(row, r) in table.bodyRows" :key="r">
                                    <tr :class="table.customClasses.tr">
                                        <template x-for="(col, c) in row" :key="c">
                                            <td
                                                :class="table.customClasses.td"
                                                :style="table.customStyles.td"
                                                class="text-sm text-gray-600"
                                            >
                                                <input
                                                    type="text"
                                                    x-model="table.bodyRows[r][c]"
                                                    class="w-full bg-transparent outline-none"
                                                    placeholder="Enter Content"
                                                >
                                            </td>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="flex justify-end gap-2">
                    <button
                        type="button" @click="table.showModal = false"
                        class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg hover:bg-gray-200 dark:hover:bg-zinc-700 transition"
                    >
                        Cancel
                    </button>

                    <button
                        type="button" @click="table.add()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        x-text="table.activeTable ? 'Update Table' : 'Insert'"
                    >
                    </button>
                </div>
            </div>
        </div>

        {{-- TABLE CONTEXT MENU --}}
        <div
            id="{{ $uuid }}_table_context_menu"
            x-show="table.tableContext.show"
            x-transition.opacity.duration.150ms
            :style="`position: fixed; left: ${table.tableContext.x}px; top: ${table.tableContext.y}px;`"
            class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-xl rounded-lg p-1.5 space-y-0.5 z-[9999] w-48 text-sm select-none"
            @click.away="table.tableContext.show = false"
            x-cloak
        >
            <button type="button" @click="table.addRow('above')" class="w-full text-left px-2.5 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition duration-150 flex items-center gap-2 text-zinc-700 dark:text-zinc-300 hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
                Add Row Above
            </button>
            <button type="button" @click="table.addRow('below')" class="w-full text-left px-2.5 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition duration-150 flex items-center gap-2 text-zinc-700 dark:text-zinc-300 hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
                Add Row Below
            </button>
            <div class="border-t border-zinc-100 dark:border-zinc-700 my-1"></div>
            <button type="button" @click="table.addCol('left')" class="w-full text-left px-2.5 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition duration-150 flex items-center gap-2 text-zinc-700 dark:text-zinc-300 hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Add Column Left
            </button>
            <button type="button" @click="table.addCol('right')" class="w-full text-left px-2.5 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition duration-150 flex items-center gap-2 text-zinc-700 dark:text-zinc-300 hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                Add Column Right
            </button>
            <div class="border-t border-zinc-100 dark:border-zinc-700 my-1"></div>
            <button type="button" @click="table.openEditModal()" class="w-full text-left px-2.5 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition duration-150 flex items-center gap-2 text-zinc-700 dark:text-zinc-300 hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Table Settings
            </button>
            <div class="border-t border-zinc-100 dark:border-zinc-700 my-1"></div>
            <button type="button" @click="table.deleteRow()" class="w-full text-left px-2.5 py-1.5 hover:bg-red-50 dark:hover:bg-red-950/30 text-red-600 dark:text-red-400 rounded-md transition duration-150 flex items-center gap-2 hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Row
            </button>
            <button type="button" @click="table.deleteCol()" class="w-full text-left px-2.5 py-1.5 hover:bg-red-50 dark:hover:bg-red-950/30 text-red-600 dark:text-red-400 rounded-md transition duration-150 flex items-center gap-2 hover:cursor-pointer">
                type="button" xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Column
            </button>
        </div>

        {{-- LINK INSERT --}}
        <button
            type="button"
            x-ref="linkBtn"
            @click.stop="link.showPopup($event)"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Insert Link') }}"
        >
            <x-form.icon name="link" :class="$icon_size" />
        </button>

        {{-- VIDEO INSERT --}}
        <button
            type="button"
            x-ref="videoBtn"
            @click.stop="video.insert()"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
            title="{{ __('Insert Embed Video') }}"
        >
            <x-form.icon name="video" :class="$icon_size" />
        </button>

        <div
            x-show="video.showModal"
            class="fixed inset-0 flex items-center justify-center backdrop-blur-sm bg-opacity-50 z-1"
            wire:ignore
            x-cloak
        >
            <div
                class="bg-white/80 dark:bg-black/90 backdrop-blur-4xl rounded-2xl shadow max-w-4xl w-full p-8 max-h-screen overflow-y-auto"
            >
                <h2 class="text-lg font-bold mb-4">Add YouTube Video</h2>
                <div class="flex flex-col gap-4 text-sm">
                    <div>
                        <label class="{{ config('x-form.label') }}">YouTube URL:</label>
                        <div class="p-4 rounded-sm text-sm bg-blue-100 text-blue-900 mb-2">
                            Please enter a valid YouTube video URL (https://www.youtube.com/embed/VIDEO_ID) or paste the
                            embed iframe code. If you use embed code, make sure to check and adjust the width, height,
                            and styles as needed.
                        </div>
                        <textarea x-model="video.youtubeUrl" class="{{ config('x-form.textarea') }}"></textarea>
                    </div>

                    <div>
                        <label class="{{ config('x-form.label') }}">Video Title (Accessibility):</label>
                        <input type="text" x-model="video.videoTitle" class="{{ config('x-form.input') }}">
                    </div>

                    <div>
                        <label class="{{ config('x-form.label') }}">Custom Classes:</label>
                        <input type="text" x-model="video.customClasses" class="{{ config('x-form.input') }}">
                    </div>

                    <div>
                        <label class="{{ config('x-form.label') }}">Custom Styles:</label>
                        <input type="text" x-model="video.customStyles" class="{{ config('x-form.input') }}">
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button
                        type="button"
                        @click="video.showModal = false"
                        class="px-4 py-2 mr-2 bg-gray-300 rounded"
                    >{{ __('Cancel') }}</button>
                    <button
                        type="button"
                        @click="video.add()"
                        class="px-4 py-2 bg-blue-500 text-white rounded"
                    >{{ __('Insert') }}</button>
                </div>
            </div>
        </div>

        {{-- IMAGE LINK INSERT --}}
        <div>
            <button
                type="button"
                @click="image.storeSelection(); image.showModal = true"
                class="p-2 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm"
                title="{{ __('Insert Image from URL') }}"
            >
                <x-form.icon name="image" :class="$icon_size" />
            </button>

            <div
                x-show="image.showModal"
                class="fixed inset-0 flex items-center justify-center backdrop-blur-sm bg-opacity-50 z-1"
                wire:ignore
                x-cloak
            >
                <div
                    class="bg-white/80 dark:bg-black/90 backdrop-blur-4xl rounded-2xl shadow max-w-4xl w-full p-8 max-h-screen overflow-y-auto"
                >
                    {{-- IMAGE INPUTS --}}
                    <div class="w-full my-4" x-data>
                        <label for="image_url" class="{{ config('x-form.label') }}">
                            Image URL <span class="text-xs text-red-500">*</span>
                        </label>

                        <input
                            id="{{ $uuid }}_image_url"
                            type="text"
                            x-model="image.src"
                            @input="image.init()"
                            class="{{ config('x-form.input') }}"
                            placeholder="Enter the url link of the image you would like to insert..."
                        />

                        <!-- Informative hint -->
                        <p class="text-xs text-gray-500 mt-1">
                            Please use a <span class="font-medium">secure (https)</span> URL to a
                            <span class="font-medium">copyright-free</span> image.
                        </p>

                        <!-- Optional: Warning if input doesn't meet https requirement -->
                        <template x-if="image.src && !image.src.startsWith('https://')">
                            <p class="text-xs text-red-600 mt-1">
                                ⚠️ URL must start with <span class="font-semibold">https://</span>
                            </p>
                        </template>
                    </div>

                    <div x-show="image.src">
                        <div class="w-full my-4">
                            <label
                                for="image_alt_text"
                                class="{{ config('x-form.label') }}"
                            >
                                ALT Text <span class="text-xs text-red-500">*</span>
                            </label>

                            <input
                                id="{{ $uuid }}_image_alt_text"
                                type="text"
                                x-model="image.alt"
                                class="{{ config('x-form.input') }}"
                                placeholder="Enter the alt title text for your image"
                            />
                        </div>

                        <div class="mt-4 w-full flex justify-center mb-4">
                            <img
                                x-show="image.src"
                                :src="image.src"
                                :style="{
                                      float: image.float,
                                      width: image.width+'px',
                                      height: image.height+'px',
                                      border: image.borderWidth+'px solid '+image.borderColor,
                                      borderRadius: image.borderRadius+'px',
                                      opacity: image.opacity
                                    }"
                                class="shadow"
                            />
                        </div>

                        <div
                            class="w-full flex flex-col gap-2"
                        >
                            <div x-show="image.range == 1" class="flex items-center w-full gap-4">
                                <!-- Width Slider and Input -->
                                <div class="flex items-center flex-grow gap-2">
                                    <input
                                        type="range"
                                        id="{{ $uuid }}_image_width"
                                        min="0"
                                        max="1000"
                                        step="1"
                                        x-model="image.width"
                                        @input="image.changeImageDimensions('w', $el.value)"
                                        class="w-full h-2 accent-blue-500"
                                    />

                                    <div class="relative">
                                        <span class="absolute left-1 top-1/2 -translate-y-1/2 text-gray-400 text-xs">W</span>
                                        <input
                                            type="number"
                                            min="0"
                                            max="1000"
                                            step="1"
                                            x-model="image.width"
                                            @input="image.changeImageDimensions('w', $el.value)"
                                            class="pl-5 w-16 text-xs border border-gray-300 rounded-md py-1 px-1 text-gray-700 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <!-- Height Slider and Input -->
                                <div class="flex items-center flex-grow gap-2">
                                    <input
                                        type="range"
                                        id="{{ $uuid }}_image_height"
                                        min="0"
                                        max="1000"
                                        step="1"
                                        x-model="image.height"
                                        @input="image.changeImageDimensions('h', $el.value)"
                                        class="w-full h-2 accent-blue-500"
                                    />

                                    <div class="relative">
                                        <span class="absolute left-1 top-1/2 -translate-y-1/2 text-gray-400 text-xs">H</span>
                                        <input
                                            type="number"
                                            min="0"
                                            max="1000"
                                            step="1"
                                            x-model="image.height"
                                            @input="image.changeImageDimensions('h', $el.value)"
                                            class="pl-5 w-16 text-xs border border-gray-300 rounded-md py-1 px-1 text-gray-700 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <!-- Aspect Ratio Toggle Button -->
                                <button
                                    type="button"
                                    @click="image.changeConstraint()"
                                    class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md hover:bg-gray-100 transition"
                                >
                                    <!-- Locked Aspect -->
                                    <svg
                                        x-show="image.constraint"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="stroke-gray-600"
                                    >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                    </svg>

                                    <!-- Unlocked Aspect -->
                                    <svg
                                        x-show="!image.constraint"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="stroke-gray-600"
                                    >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 4h10a2 2 0 0 1 2 2v10m-.584 3.412a2 2 0 0 1 -1.416 .588h-12a2 2 0 0 1 -2 -2v-12c0 -.552 .224 -1.052 .586 -1.414" />
                                        <path d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>


                            <div
                                x-show="image.range == 2"
                                class="w-full flex items-center p-2 text-sm h-8 bg-transparent focus:outline-none"
                            >
                                <input
                                    type="range"
                                    id="{{ $uuid }}_image_border"
                                    x-model="image.borderWidth"
                                    class="w-full"
                                    min="0"
                                    max="100"
                                    step="1"
                                />

                                <input
                                    type="number"
                                    min="0"
                                    max="1000"
                                    step="1"
                                    class="ml-2 w-12 text-xs text-gray-700 border border-gray-300 rounded px-1 py-0.5 focus:outline-none"
                                    x-model="image.borderWidth"
                                />

                                <input
                                    type="color"
                                    @input="image.setBorderColor($el.value)"
                                    class="rounded-md h-6 w-12"
                                />
                            </div>

                            <div
                                x-show="image.range == 3"
                                class="grow flex items-center p-2 text-sm h-8 bg-transparent focus:outline-none"
                            >
                                <input
                                    type="range"
                                    id="{{ $uuid }}_image_radius"
                                    x-model="image.borderRadius"
                                    class="w-full"
                                    min="0"
                                    max="100"
                                    step="1"
                                />

                                <input
                                    type="number"
                                    min="0"
                                    max="1000"
                                    step="1"
                                    class="ml-2 w-10 text-xs text-gray-700 border border-gray-300 rounded px-1 py-0.5 focus:outline-none"
                                    x-model="image.borderRadius"
                                />
                            </div>

                            <div
                                x-show="image.range == 4"
                                class="grow flex items-center p-2 text-sm h-8 bg-transparent focus:outline-none"
                            >
                                <input
                                    type="range"
                                    id="{{ $uuid }}_image_brightness"
                                    x-model="image.opacity"
                                    class="w-full"
                                    min="0"
                                    max="1"
                                    step="0.1"
                                />
                            </div>

                            <div class="w-full flex justify-center gap-2">
                                <button
                                    type="button"
                                    @click="image.setRange(1)"
                                    class="bg-gray-200 border border-gray-300/80 shadow hover:border-gray-300 text-black px-3 py-1 text-sm rounded-full min-w-20 hover:cursor-pointer"
                                >
                                    Resize
                                </button>

                                <button
                                    type="button"
                                    @click="image.setRange(2)"
                                    class="bg-gray-200 border border-gray-300/80 shadow hover:border-gray-300 text-black px-3 py-1 text-sm rounded-full min-w-20 hover:cursor-pointer"
                                >
                                    Border
                                </button>

                                <button
                                    type="button"
                                    @click="image.setRange(3)"
                                    class="bg-gray-200 border border-gray-300/80 shadow hover:border-gray-300 text-black px-3 py-1 text-sm rounded-full min-w-20 hover:cursor-pointer"
                                >
                                    Border Radius
                                </button>

                                <button
                                    type="button"
                                    @click="image.setRange(4)"
                                    class="bg-gray-200 border border-gray-300/80 shadow hover:border-gray-300 text-black px-3 py-1 text-sm rounded-full min-w-20 hover:cursor-pointer"
                                >
                                    Brightness
                                </button>
                            </div>
                        </div>

                        <div class="w-full">
                            <label
                                for="image_alignment"
                                class="block text-xs font-medium mt-1 mb-1"
                            >Image placement:</label>
                            <select
                                id="{{ $uuid }}_image_alignment"
                                x-model="image.float"
                                class="rounded-sm border border-gray-300 bg-transparent p-1 w-full text-sm h-7"
                            >
                                <option value="none">None</option>
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                            </select>
                        </div>
                    </div>


                    <button
                        type="button"
                        @click="$dispatch('insert-image')"
                        class="mt-2 bg-blue-600 border-2 border-blue-600 text-sm text-white font-medium px-3 py-1 rounded hover:cursor-pointer hover:opacity-80"
                        x-text="image.selectedImage ? 'Update Image' : 'Insert Image'"
                    >
                    </button>

                    <button
                        type="button"
                        @click="image.closeModal()"
                        class="mt-2 border-2 border-gray-500 text-sm text-gray-500 font-medium px-3 py-1 rounded hover:cursor-pointer hover:opacity-80"
                    >
                        {{ __('Cancel') }}
                    </button>

                    <template x-if="image.selectedImage">
                        <button
                            type="button"
                            @click="image.remove()"
                            class="mt-2 border-2 border-red-500 text-sm text-red-500 font-medium px-3 py-1 rounded hover:cursor-pointer hover:opacity-80"
                        >
                            {{ __('Remove Image') }}
                        </button>
                    </template>
                </div>
            </div>
        </div>

        {{-- FILE MANAGER INSERT --}}
        @if($withFilemanager)
            <livewire:filemanager :key="'file_manager_' . $uuid" :standalone="false" />
        @endif

        {{-- CLEAR HTML FORMAT --}}
        <button
            type="button"
            @click="cleanup.run()"
            class="p-1 hover:bg-black/5 dark:hover:bg-white/5 text-black dark:text-white hover:cursor-pointer rounded-sm flex items-center gap-1 text-sm"
            title="{{ __('Clear formatting on the selected content') }}"
        >
            <x-form.icon name="cleanup" :class="$icon_size" />
        </button>
    </div>

    {{-- EDITOR --}}
    <div
        id="{{ $uuid }}"
        class="p-4 min-h-60 overflow-auto outline-none bg-black/1 dark:bg-white/10 border dark:text-white border-black/5 dark:border-white/20 rounded-b-md [&>img]:hover:cursor-grab [&>img]:active:cursor-grabbing"
        contenteditable="true"
        @input="save()"
        @click="image.handleClick($event)"
        @dragstart="image.handleDragStart($event)"
        @dragend="image.handleDragEnd($event)"
        @contextmenu="table.handleContextMenu($event)"
        @keydown.tab.prevent="action.changeIndent(!$event.shiftKey)"
        @paste.prevent="handlePaste($event)"
        x-ref="editor"
    >
        {!! $content !!}
    </div>


    @error($rule)
    <div class="{{ config('x-form.error') }}">{!! $message !!}</div>
    @enderror
</div>
