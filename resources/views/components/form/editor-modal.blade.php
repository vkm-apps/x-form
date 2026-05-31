{{--
    Singleton table editor modal.

    This view is auto-injected by <x-form.editor> using @once + x-teleport="body".
    The first editor instance on the page renders this once and Alpine teleports
    it to <body>, giving it a clean stacking context with no CSS transform ancestors.

    No manual placement needed. Shared by all <x-form.editor> instances on the page.
    Communication uses the custom window event 'editor:open-table-modal'.
    The Alpine data component 'editorTableModal' is registered by the JS bundle.
--}}
<div x-data="editorTableModal" x-cloak>
    <div
        x-show="showModal"
        x-transition.opacity.scale
        class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-[1000]"
        @keydown.escape.window="showModal = false"
    >
        <div class="bg-white w-full max-w-7xl max-h-screen rounded-xl shadow-xl p-6 space-y-6 overflow-auto">
            <!-- ROW 1: rows + columns -->
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium">Table Style</label>
                    <select
                        x-model="tableStyle"
                        @change="updateTableClasses()"
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
                        x-model.number="colCount"
                        @input="generateColumns()"
                        class="{{ config('x-form.input') }}"
                    >
                </div>

                <div>
                    <label class="text-sm font-medium">Rows</label>
                    <input
                        type="number" min="1"
                        x-model.number="rows"
                        @input="generateColumns()"
                        class="{{ config('x-form.input') }}"
                    >
                </div>
            </div>

            <!-- ROW 2: classes + styles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                <div><label>Table Classes</label><input
                        placeholder="table classes"
                        x-model="customClasses.table"
                        class="{{ config('x-form.input') }}"
                    /></div>
                <div><label>Table Styles</label><input
                        placeholder="table styles"
                        x-model="customStyles.table"
                        class="{{ config('x-form.input') }}"
                    /></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                <div><label>Thead Classes</label><input
                        placeholder="thead classes"
                        x-model="customClasses.thead"
                        class="{{ config('x-form.input') }}"
                    /></div>
                <div><label>Thead Styles</label><input
                        placeholder="thead styles"
                        x-model="customStyles.thead"
                        class="{{ config('x-form.input') }}"
                    /></div>
                <div><label>Th Classes</label><input
                        placeholder="th classes"
                        x-model="customClasses.th"
                        class="{{ config('x-form.input') }}"
                    /></div>
                <div><label>Th Styles</label><input
                        placeholder="th styles"
                        x-model="customStyles.th"
                        class="{{ config('x-form.input') }}"
                    /></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                <div><label>Tbody Classes</label><input
                        placeholder="tbody classes"
                        x-model="customClasses.tbody"
                        class="{{ config('x-form.input') }}"
                    /></div>
                <div><label>Tbody Styles</label><input
                        placeholder="tbody styles"
                        x-model="customStyles.tbody"
                        class="{{ config('x-form.input') }}"
                    /></div>
                <div><label>Td Classes</label><input
                        placeholder="td classes"
                        x-model="customClasses.td"
                        class="{{ config('x-form.input') }}"
                    /></div>
                <div><label>Td Styles</label><input
                        placeholder="td styles"
                        x-model="customStyles.td"
                        class="{{ config('x-form.input') }}"
                    /></div>
            </div>

            <!-- PREVIEW -->
            <div>
                <h3 class="text-sm font-medium mb-2">Preview</h3>

                <div class="overflow-auto">
                    <table :class="customClasses.table" :style="customStyles.table">
                        <thead :class="customClasses.thead" :style="customStyles.thead">
                            <tr :class="customClasses.tr">
                                <template x-for="(col, i) in columns.header" :key="i">
                                    <th :class="customClasses.th" :style="customStyles.th">
                                        <input
                                            type="text"
                                            x-model="columns.header[i]"
                                            class="w-full bg-transparent outline-none"
                                            placeholder="Enter Title"
                                        >
                                    </th>
                                </template>
                            </tr>
                        </thead>
                        <tbody :class="customClasses.tbody" :style="customStyles.tbody">
                            <template x-for="(row, r) in bodyRows" :key="r">
                                <tr :class="customClasses.tr">
                                    <template x-for="(col, c) in row" :key="c">
                                        <td
                                            :class="customClasses.td"
                                            :style="customStyles.td"
                                            class="text-sm text-gray-600"
                                        >
                                            <input
                                                type="text"
                                                x-model="bodyRows[r][c]"
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
                    type="button" @click="showModal = false"
                    class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg hover:bg-gray-200 dark:hover:bg-zinc-700 transition"
                >
                    Cancel
                </button>

                <button
                    type="button" @click="add()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    x-text="activeTable ? 'Update Table' : 'Insert'"
                >
                </button>
            </div>
        </div>
    </div>
</div>
