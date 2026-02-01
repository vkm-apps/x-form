<?php

/**
 * --------------------------------------------------------------------------
 * X-Form Configuration
 * --------------------------------------------------------------------------
 *
 * This configuration file defines the styling, behavior, and icons used
 * by the X-Form components throughout the application.
 *
 * Features:
 *  - Centralized Tailwind CSS classes for inputs, textareas, dropdowns,
 *    checkboxes, radio buttons, file uploads, and disabled fields.
 *  - Standardized label, error, and required field styles.
 *  - Configurable icon sizes and SVG icons for actions, currencies, and
 *    common UI elements.
 *  - Supports dark mode and responsive styling.
 *  - Easily extendable by updating the $base array or adding new
 *    component definitions.
 *
 * Usage:
 *  Access these settings via `config('xform.input')`, `config('xform.icons')`,
 *  or other keys as needed in Blade templates or PHP code.
 *
 */



/**
 * Base Tailwind classes for X-Form components (inputs, textareas, dropdowns,
 * checkboxes, radios, uploads). Centralizes typography, layout, states, and
 * choice styles for reuse and easier maintenance.
 */
$icon_size = 'size-4';

$base = [
    'typography' => [
        'text_color' => 'text-black/80 dark:text-white/90',
        'text_size'  => 'text-sm',
    ],
    'layout' => [
        'flex_center' => 'flex items-center gap-2',
        'rounded'     => 'rounded-md',
        'transition'  => 'transition-all duration-200',
    ],
    'inputs' => [
        'bg'      => 'bg-black/1 dark:bg-white/5 backdrop-blur-md shadow-xs',
        'border'  => 'border border-black/5 dark:border-white/10',
        'focus'   => 'focus:ring-1 focus:ring-black/50 dark:focus:ring-white/50 focus:ring-blue-500/50 focus:shadow-md outline-none',
        'min_height' => [
            'input'    => 'min-h-5',
            'disabled' => 'min-h-7',
        ],
    ],
    'states' => [
        'disabled_bg'   => 'bg-black/5 dark:bg-white/5 backdrop-blur-md border border-black/5 dark:border-white/10',
        'disabled_text' => 'text-sm text-black/50 dark:text-white/60',
    ],
    'check_radio' => 'flex items-center justify-center cursor-pointer rounded-sm border-1 border-black/20 dark:border-white/20 transition peer-checked:border-black/70 dark:peer-checked:border-white/30 dark:peer-checked:bg-white/10 peer-checked:[&>svg]:flex peer-checked:[&>svg]:opacity-100',
    'choice' => [
        'horizontal' => 'flex flex-row items-center space-x-2 mt-1.5 pe-4',
        'vertical'   => 'flex flex-col gap-2 mt-1',
    ],
    'required' => "after:content-['*'] after:text-red-500 before:mr-2",
    'hover_pointer' => 'hover:cursor-pointer hover:opacity-80',
];

return [
    /**
     * --------------------------------------------------------------------------
     * File Upload Disk Configuration
     * --------------------------------------------------------------------------
     *
     * Defines the storage disk, size limits, and allowed file types for X-Form uploads.
     *
     * Keys:
     *  - 'name'                  : The storage disk to use (default: 'media').
     *  - 'filesize'              : Maximum allowed file size per upload (in KB).
     *                              If null, the Livewire default max upload size
     *                              is used. If set higher than Livewire’s limit,
     *                              the upload will fail before validation. Setting
     *                              a lower value further restricts uploads.
     *  - 'mime_types'            : Comma-separated list of allowed file extensions.
     *  - 'virus_scanner_command' : Optional command used to scan uploaded files
     *                              for viruses (e.g. 'clamdscan').
     *
     * Values can be configured via environment variables where applicable.
     */
    'disk' => [
        'name' => env('XFORM_DISK_NAME', 'media'),
        'filesize' => null,
        'mime_types' => 'jpg,jpeg,png,gif,webp,svg,ico,pdf,doc,docx,xls,xlsx,csv,txt,rtf,ppt,pptx,avi,mp4,webm,mov,mp3,wav,ogg',
        'virus_scanner_command' => env('XFORM_VIRUS_SCANNER_COMMAND'),
    ],

    // Default icon size for X-Form components
    'icon_size' => $icon_size,

    // Required Fields classes
    'required' => $base['required'],

    // Label Classes
    'label' => implode(' ', [
        'block capitalize w-full mb-1 tracking-wider font-medium opacity-90',
        $base['typography']['text_color'],
        $base['typography']['text_size'],
    ]),

    // Input Classes
    'input' => implode(' ', [
        $base['layout']['flex_center'],
        'w-full p-2',
        $base['inputs']['min_height']['input'],
        $base['typography']['text_size'],
        $base['typography']['text_color'],
        $base['inputs']['bg'],
        $base['inputs']['border'],
        $base['layout']['rounded'],
        $base['inputs']['focus'],
    ]),

    // Textarea Classes
    'textarea' => implode(' ', [
        $base['layout']['flex_center'],
        'w-full p-2',
        $base['typography']['text_size'],
        $base['typography']['text_color'],
        $base['inputs']['bg'],
        $base['inputs']['border'],
        $base['layout']['rounded'],
        $base['inputs']['focus'],
    ]),

    // Dropdown Classes
    'dropdown' => [
        'background' => 'scrollbar-thin min-w-48 py-2 px-0 text-sm text-left list-none rounded-md shadow-lg backdrop-blur-md bg-white/50 dark:bg-black/50 bg-clip-padding border-gray-400 text-gray-500 dark:text-dark-100 absolute w-full overflow-x-hidden overflow-y-auto z-50',
        'input' => implode(' ', [
            $base['layout']['flex_center'],
            'w-full p-2',
            $base['typography']['text_size'],
            $base['typography']['text_color'],
            $base['inputs']['bg'],
            $base['inputs']['border'],
            $base['layout']['rounded'],
            $base['inputs']['focus'],
            $base['hover_pointer'],
        ]),
        'item' => implode(' ', [
            'flex items-center w-full text-sm text-left gap-3 pl-4 py-2 clear-both capitalize font-normal whitespace-nowrap border-none rounded-none',
            $base['typography']['text_size'],
            $base['typography']['text_color'],
            $base['hover_pointer'],
            'hover:bg-black/5 hover:dark:bg-white/10',
        ]),
        'search' => [
            'border' => 'border-black/30 dark:border-white/30',
        ],
    ],

    // Radio Classes
    'radio' => [
        'label' => implode(' ', [$base['typography']['text_size'], $base['typography']['text_color']]),
        'input' => 'relative w-4 h-4 '.$base['check_radio'],
        'horizontal' => $base['choice']['horizontal'],
        'vertical' => $base['choice']['vertical'],
    ],

    // Checkbox Classes
    'checkbox' => [
        'div' => 'flex items-center space-x-2',
        'label' => 'relative w-5 h-5 '.$base['check_radio'],
        'input' => 'peer hidden',
        'horizontal' => $base['choice']['horizontal'],
        'vertical' => 'flex flex-col gap-1 mt-1',
        'empty_message' => 'capitalize text-zinc-500 dark:text-zinc-300',
        'group' => [
            'label' => 'dark:text-zinc-200 font-bold hover:cursor-pointer relative mb-1',
        ],
        'title' => "{$base['typography']['text_color']} text-xs",
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 stroke-black/80 dark:stroke-white/70 opacity-0 peer-checked:opacity-100 transition lucide lucide-check-icon"><path d="M20 6 9 17l-5-5"/></svg>',
    ],

    // File Upload Classes
    'upload' => [
        'button' => implode(' ', [
            $base['layout']['flex_center'],
            $base['typography']['text_color'],
            $base['typography']['text_size'],
            'mt-1.5 file:cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-black/5 dark:file:bg-white/10 file:text-black/60 dark:file:text-white hover:file:bg-black/10 dark:hover:file:bg-white/20',
        ]),
        'dropzone' => [
            'button' => implode(' ', [
                $base['layout']['flex_center'],
                $base['layout']['rounded'],
                'flex-col items-center justify-center w-full h-64 border border-dashed border-black/90 dark:border-white/90 hover:cursor-pointer bg-transparent hover:bg-white/10 dark:hover:bg-black/10',
            ]),
            'title' => implode(' ', [$base['typography']['text_color'], $base['typography']['text_size']]),
            'subtitle' => implode(' ', [$base['typography']['text_color'], $base['typography']['text_size']]),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 fill-none stroke-black/80 dark:stroke-white/80 lucide lucide-cloud-upload-icon"><path d="M12 13v8"/><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="m8 17 4-4 4 4"/></svg>',
        ],
    ],

    // Error Message Classes
    'error' => 'mt-1 text-sm text-red-500',

    // Disabled Input Classes
    'disabled' => [
        'class' => implode(' ', [
            $base['layout']['flex_center'],
            'w-full text-start truncate p-2',
            $base['inputs']['min_height']['disabled'],
            $base['states']['disabled_bg'],
            $base['states']['disabled_text'],
            $base['layout']['rounded'],
            'space-x-2',
        ]),
        'style' => '',
        'action' => 'w-full hover:opacity-80 '.$base['layout']['transition'],
        'divider' => 'mx-2 h-5 w-px bg-black/10 dark:bg-white/10',
    ],

    /**
     * |---------------------------------------------------------------------------
     * | Icons
     * |---------------------------------------------------------------------------
     * |
     * | This array holds icon definitions for x-form.disabled.
     * | Can be either class names (Lucide/Tabler etc.) or raw SVGs.
     * | 'currency', 'copy', 'link', 'mail', 'phone', 'fax', 'map'
     */
    'icons' => [
        'copy' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucidelucide-copy-icon lucide-copy"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>',

        'link' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucidelucide-link-icon lucide-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>',

        'email' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucidelucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>',

        'phone' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucidelucide-phone-icon lucide-phone"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg>',

        'fax' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucidelucide-printer-icon lucide-printer"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>',

        'map' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucidelucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>',

        'info' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucidelucide-badge-info-icon lucide-badge-info"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><line x1="12" x2="12" y1="16" y2="12"/><line x1="12" x2="12.01" y1="8" y2="8"/></svg>',

        'folder' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucide lucide-folder-icon lucide-folder"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>',
    ],

    /**
     * |---------------------------------------------------------------------------
     * | Currency Icons
     * |---------------------------------------------------------------------------
     * |
     */
    'currency' => [
        'eur' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucide lucide-euro-icon lucide-euro"><path d="M4 10h12"/><path d="M4 14h9"/><path d="M19 6a7.7 7.7 0 0 0-5.2-2A7.9 7.9 0 0 0 6 12c0 4.4 3.5 8 7.8 8 2 0 3.8-.8 5.2-2"/></svg>',

        'dollar' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucide lucide-dollar-sign-icon lucide-dollar-sign"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',

        'pound' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucide lucide-pound-sterling-icon lucide-pound-sterling"><path d="M18 7c0-5.333-8-5.333-8 0"/><path d="M10 7v14"/><path d="M6 21h12"/><path d="M6 13h10"/></svg>',

        'ruble' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucide lucide-russian-ruble-icon lucide-russian-ruble"><path d="M6 11h8a4 4 0 0 0 0-8H9v18"/><path d="M6 15h8"/></svg>',

        'yen' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucide lucide-japanese-yen-icon lucide-japanese-yen"><path d="M12 9.5V21m0-11.5L6 3m6 6.5L18 3"/><path d="M6 15h12"/><path d="M6 11h12"/></svg>',

        'indian' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucide lucide-indian-rupee-icon lucide-indian-rupee"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>',

        'bitcoin' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucide lucide-bitcoin-icon lucide-bitcoin"><path d="M11.767 19.089c4.924.868 6.14-6.025 1.216-6.894m-1.216 6.894L5.86 18.047m5.908 1.042-.347 1.97m1.563-8.864c4.924.869 6.14-6.025 1.215-6.893m-1.215 6.893-3.94-.694m5.155-6.2L8.29 4.26m5.908 1.042.348-1.97M7.48 20.364l3.126-17.727"/></svg>',

        'coins' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.' lucide lucide-coins-icon lucide-coins"><circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18"/><path d="M7 6h1v4"/><path d="m16.71 13.88.7.71-2.82 2.82"/></svg>',
    ],
];
