<?php

/**
 * --------------------------------------------------------------------------
 * X-Form Configuration
 * --------------------------------------------------------------------------
 *
 * This configuration file defines the styling, behavior, and icons used
 * by the X-Form components throughout the application.
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
        'bg'      => 'bg-black/5 dark:bg-white/5 backdrop-blur-md shadow-xs', // Softened light mode bg slightly for contrast
        'border'  => 'border border-black/5 dark:border-white/10',
        'focus'   => 'focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-blue-400/50 focus:shadow-md outline-none', // Resolved multi-ring color conflicts
        'min_height' => [
            'input'    => 'min-h-5',
            'disabled' => 'min-h-7',
        ],
    ],
    'states' => [
        'disabled_bg'   => 'bg-black/5 dark:bg-white/5 backdrop-blur-md border border-black/5 dark:border-white/10',
        'disabled_text' => 'text-sm text-black/50 dark:text-white/60',
    ],
    'check_radio' => 'flex items-center justify-center cursor-pointer rounded-sm border border-black/20 dark:border-white/20 transition peer-checked:border-black/70 dark:peer-checked:border-white/30 dark:peer-checked:bg-white/10 peer-checked:[&>svg]:flex peer-checked:[&>svg]:opacity-100',
    'choice' => [
        'horizontal' => 'flex flex-row items-center space-x-2 mt-1.5 pe-4',
        'vertical'   => 'flex flex-col gap-2 mt-1',
    ],
    'required' => "after:content-['*'] after:text-red-500 before:mr-2",
    'hover_pointer' => 'hover:cursor-pointer hover:opacity-80',
];

// Reusable standard element composition
$standard_input_classes = implode(' ', [
    $base['layout']['flex_center'],
    'w-full p-2',
    $base['typography']['text_size'],
    $base['typography']['text_color'],
    $base['inputs']['bg'],
    $base['inputs']['border'],
    $base['layout']['rounded'],
    $base['inputs']['focus'],
]);

return [
    'disk' => [
        'name' => env('XFORM_DISK_NAME', 'media'),
        'filesize' => env('XFORM_MAX_FILESIZE'), // Exposed to env variable safely
        'mime_types' => 'jpg,jpeg,png,gif,webp,svg,ico,pdf,doc,docx,xls,xlsx,csv,txt,rtf,ppt,pptx,avi,mp4,webm,mov,mp3,wav,ogg',
        'virus_scanner_command' => env('XFORM_VIRUS_SCANNER_COMMAND'),
    ],

    'icon_size' => $icon_size,
    'required'  => $base['required'],

    'label' => implode(' ', [
        'block capitalize w-full mb-1 tracking-wider font-medium opacity-90',
        $base['typography']['text_color'],
        $base['typography']['text_size'],
    ]),

    'input'    => $standard_input_classes,
    'textarea' => $standard_input_classes,

    'dropdown' => [
        'background' => 'scrollbar-thin min-w-48 py-2 px-0 text-sm text-left list-none rounded-md shadow-lg backdrop-blur-md bg-white/80 dark:bg-black/80 border border-black/5 dark:border-white/10 absolute w-full overflow-x-hidden overflow-y-auto z-50 ' . $base['typography']['text_color'],
        'input' => implode(' ', [
            $standard_input_classes,
            $base['hover_pointer'],
        ]),
        'item' => implode(' ', [
            'flex items-center w-full text-left gap-3 pl-4 py-2 clear-both capitalize font-normal whitespace-nowrap border-none rounded-none',
            $base['typography']['text_size'],
            $base['typography']['text_color'],
            $base['hover_pointer'],
            'hover:bg-black/5 hover:dark:bg-white/10',
        ]),
        'search' => [
            'border' => 'border-black/30 dark:border-white/30',
        ],
    ],

    'radio' => [
        'label'      => implode(' ', [$base['typography']['text_size'], $base['typography']['text_color']]),
        'input'      => 'relative w-4 h-4 ' . $base['check_radio'],
        'horizontal' => $base['choice']['horizontal'],
        'vertical'   => $base['choice']['vertical'],
    ],

    'checkbox' => [
        'div'           => 'flex items-center space-x-2',
        'label'         => 'relative w-5 h-5 ' . $base['check_radio'],
        'input'         => 'peer hidden',
        'horizontal'    => $base['choice']['horizontal'],
        'vertical'      => 'flex flex-col gap-1 mt-1',
        'empty_message' => 'capitalize text-zinc-500 dark:text-zinc-300',
        'group' => [
            'label' => 'dark:text-zinc-200 font-bold hover:cursor-pointer relative mb-1',
        ],
        'title' => "{$base['typography']['text_color']} text-xs",
        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 stroke-black/80 dark:stroke-white/70 opacity-0 peer-checked:opacity-100 transition"><path d="M20 6 9 17l-5-5"/></svg>',
    ],

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
                'flex-col items-center justify-center w-full h-64 border border-dashed border-black/40 dark:border-white/40 hover:cursor-pointer bg-transparent hover:bg-white/5 dark:hover:bg-black/5', // Fixed high opacity heavy border (90 to 40)
            ]),
            'title'    => implode(' ', [$base['typography']['text_color'], $base['typography']['text_size']]),
            'subtitle' => implode(' ', [$base['typography']['text_color'], $base['typography']['text_size']]),
            'icon'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 fill-none stroke-black/80 dark:stroke-white/80"><path d="M12 13v8"/><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="m8 17 4-4 4 4"/></svg>',
        ],
    ],

    'error' => 'mt-1 text-sm text-red-500 dark:text-red-400', // Added dark mode optimization for error text

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
        'style'   => '',
        'action'  => 'w-full hover:opacity-80 ' . $base['layout']['transition'],
        'divider' => 'mx-2 h-5 w-px bg-black/10 dark:bg-white/10',
    ],

    'icons' => [
        'copy'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.'"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>',
        'link'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.'"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>',
        'email'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.'"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>',
        'phone'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.'"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg>',
        'fax'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.'"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>',
        'map'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.'"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>',
        'info'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.'"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><line x1="12" x2="12" y1="16" y2="12"/><line x1="12" x2="12.01" y1="8" y2="8"/></svg>',
        'folder' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$icon_size.'"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>',
    ],

    'currency' => [
        'currency' => [
            // Original currencies
            'euro'     => '&euro;',      // € Euro
            'dollar'  => '&#36;',       // $ US Dollar (also used for CAD, AUD, MXN, SGD, etc.)
            'pound'   => '&pound;',     // £ British Pound
            'ruble'   => '&#8381;',     // ₽ Russian Ruble
            'yen'     => '&yen;',       // ¥ Japanese Yen / Chinese Yuan
            'indian'  => '&#8377;',     // ₹ Indian Rupee
            'bitcoin' => '&#8383;',     // ₿ Bitcoin
            'coins'   => '&curren;',    // ¤ Generic Currency Sign

            // Added common currencies
            'won'     => '&#8361;',     // ₩ South Korean Won
            'lira'    => '&#8378;',     // ₺ Turkish Lira
            'baht'    => '&#3647;',     // ฿ Thai Baht
            'naira'   => '&#8358;',     // ₦ Nigerian Naira
            'peso'    => '&#8369;',     // ₱ Philippine Peso (Note: Mexican/Latin American pesos generally use '$')
            'franc'   => '&#8355;',     // ₣ Franc (often used for Swiss Franc, though 'CHF' text is also common)
            'real'    => 'R&#36;',      // R$ Brazilian Real
            'rand'    => 'R',           // R South African Rand
            'dirham'  => '&#1583;.&#1573;', // د.إ UAE Dirham (Arabic characters)
            'shekel'  => '&#8362;',     // ₪ Israeli New Shekel
        ],
    ],
];
