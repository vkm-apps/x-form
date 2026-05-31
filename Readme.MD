# VKM APPS | X-Form

#### ✨ Supercharge your Laravel form building!

Create beautiful, fully interactive forms in a single line of Blade code. No more repeating boilerplate layouts, validation classes, error handlers, and input styles! 🚀💻

**X-Form** is a highly polished collection of Blade components for **Laravel 11, 12, and 13+**, built on top of **Livewire 3**, **Tailwind CSS 4**, and **AlpineJS 3**. It makes form creation lightning-fast and fully interactive while ensuring complete customization via published configurations.

To enjoy full compatibility, please install the VKM JS plugins bundle:
👉 [https://github.com/vkm-apps/vkm-js](https://github.com/vkm-apps/vkm-js)

---

## Requirements

- **PHP**: `^8.1`
- **Laravel / Support**: `^11.0 | ^12.0 | ^13.0`
- **Livewire**: `^3.0`
- **AlpineJS**: `^3.0`
- **Tailwind CSS**: `^4.0`

---

## Installation & Setup

Install the package via Composer:

```bash
composer require vkm-apps/x-form
```

Install and publish the configuration files using the setup command:

```bash
php artisan x-form:install
```

> [!NOTE]
> The install command automatically publishes the package configuration file to `config/x-form.php`. You can customize styles, Tailwind classes, default icons, and other behavioral settings.

---

## Available Components

Here is a summary of the available Blade components and their key features:

| Component Tag | Core Purpose | Special Features |
|---|---|---|
| [`<x-form.input>`](#input) | Standard text/number inputs | Prepend/append slots, live validation, group sizing |
| [`<x-form.textarea>`](#textarea) | Multiline text input | Auto-resizing heights, custom scrollbar styling |
| [`<x-form.password>`](#password) | Password entry | Interactive visibility toggle (eye icon) |
| [`<x-form.select>`](#select-and-dropdown) | Select dropdowns | Rich searchable dropdowns, inline search, native select fallback |
| [`<x-form.checkbox>`](#checkboxes-and-radio-buttons) | Checkboxes | Single checkbox inputs, grouped layouts with tooltip and group toggles |
| [`<x-form.radio>`](#checkboxes-and-radio-buttons) | Radio buttons | Consistent Tailwind styling, horizontal/vertical layouts |
| [`<x-form.date>`](#date-picker) | Native date picker | Range date pickers, multi-locale, Livewire & plain HTML form bindings |
| [`<x-form.disabled>`](#disabled-inputs) | Rich read-only displays | Inline actions (Copy, Link, Mail, Phone, Fax, Maps), currency formatting |
| [`<x-form.editor>`](#rich-text-editor) | Rich text WYSIWYG editor | Formatting, colors, tables, YouTube embeds, custom image editor |
| [`<x-form.editor-modal>`](#rich-text-editor) | Singleton table manager | Renders the shared table management modal |
| [`<x-form.file>`](#file-upload) | File uploader | File previews, drag-and-drop dropzones, multiple file support |
| [`<x-form.file-url>`](#file-url-browser) | File-URL selector | Integrated file manager popup to insert public file URLs directly |
| [`<x-form.icon>`](#icon-helper) | SVG icon utility | Lightweight helper to render predefined system icons |

---

## Input

A fully customizable input field with automated label generation, validation highlights, accessibility attributes, and error message outputs.

```blade
<x-form.input model="title" label="Title" />
```

### Basic Options

**Required Fields:**
Adds a red asterisk to the label layout.
```blade
<x-form.input model="title" label="Title" required />
```

**Live Updates & Modifiers:**
Bind your Livewire models with modifiers like `live`, `blur`, or `change`.
```blade
{{-- Binds using wire:model.live --}}
<x-form.input model="title" label="Title" live />

{{-- Binds using wire:model.live.blur --}}
<x-form.input model="title" label="Title" blur />

{{-- Binds using wire:model.live.change --}}
<x-form.input model="title" label="Title" change />
```

**Custom Types:**
Specify types like `number`, `email`, `tel`, or `url`.
```blade
<x-form.input type="number" model="age" label="Age" />
```

**Custom Label Slots:**
Use the slot for complex layouts inside the label tag.
```blade
<x-form.input model="title">
    <x-slot:label><span class="font-bold text-blue-600">Custom Title</span></x-slot:label>
</x-form.input>
```

**Prepend & Append Slots:**
Enables prepending and appending icons, badges, or buttons inside the input group.
```blade
<x-form.input model="price" label="Price" type="number">
    <x-slot:prepend><span class="px-2 text-gray-500">$</span></x-slot:prepend>
    <x-slot:append><span class="px-2 text-gray-500">USD</span></x-slot:append>
</x-form.input>
```

**Group Sizing:**
Sizes the outer input group wrapper container. Supported values: `sm`, `lg`, `xl`.
```blade
<x-form.input model="search" label="Search" group="lg" />
```

**Instant Validation:**
Performs real-time validation via client-side events. Supported values: `true` (keyup) or `blur`.
```blade
<x-form.input model="username" label="Username" validate="blur" />
```

---

## Textarea

Textareas share the same basic features as `<x-form.input>`, including prepended/appended slots, validation, and Livewire binding modifiers.

```blade
<x-form.textarea model="description" label="Description" placeholder="Enter details..." />
```

---

## Password

A secure password input that automatically renders a show/hide toggle button (eye icon) using AlpineJS under the hood.

```blade
<x-form.password model="password" label="New Password" required />
```

---

## Select and Dropdown

Render an interactive dropdown with custom searching, styled scrollbars, and dynamic state bindings. Alternatively, falls back to a native browser `<select>` element.

```blade
<x-form.select :list="$this->countryList" model="country" label="Country of Origin" />
```

### Options Array Format
Ensure arrays use string keys to preserve ordering on the frontend:
```php
#[Computed]
public function countryList(): array
{
    return [
        'gr' => 'Greece',
        'it' => 'Italy',
        'es' => 'Spain',
    ];
}
```

### Search & Display Options

**Searchable Dropdowns:**
Enables text filter search inputs within the dropdown list.
```blade
<x-form.select :list="$this->countryList" model="country" label="Country" searchable />
```

**Inline Search Inputs:**
Places the search input directly inline rather than hiding it inside the popup.
```blade
<x-form.select :list="$this->countryList" model="country" label="Country" searchable inline />
```

**Native Select Fallback:**
Disables custom Tailwind dropdown layouts and renders a standard HTML `<select>` tag instead.
```blade
<x-form.select :list="$this->countryList" model="country" label="Country" :dropdown="false" />
```

**Custom Dimension Limits:**
Modify dropdown sizes manually.
```blade
<x-form.select :list="$this->countryList" model="country" minWidth="250px" maxHeight="300px" />
```

---

## Checkboxes and Radio Buttons

Tailwind-styled choices supporting horizontal and vertical layouts, tooltips, and interactive group toggles.

### Checkbox Group
```blade
<x-form.checkbox :list="$this->optionsList" model="interests" label="Interests" />
```

### Radio Group
```blade
<x-form.radio :list="$this->optionsList" model="gender" label="Gender" />
```

**Layout Layout Modifiers:**
Arrange buttons horizontally or vertically.
```blade
{{-- Horizontal row alignment --}}
<x-form.radio :list="$this->optionsList" model="gender" horizontal />

{{-- Vertical stack alignment (Default) --}}
<x-form.radio :list="$this->optionsList" model="gender" vertical />
```

---

### Grouped Checkboxes (With Toggles & Tooltips)

Grouped checkboxes are designed for complex nested layouts (e.g., system permissions categorized by module) and support dynamic **tooltips** and **all-group toggling actions**.

**Example Array Structure:**
```php
$countries = [
    'Europe' => [
        ['id' => 'gr', 'title' => 'Greece', 'description' => 'Greece is located in southeastern Europe.'],
        ['id' => 'it', 'title' => 'Italy', 'description' => 'Italy is a peninsula in the Mediterranean Sea.'],
    ],
    'Asia' => [
        ['id' => 'jp', 'title' => 'Japan', 'description' => 'Japan is an island country in East Asia.'],
    ],
];
```

**Example Toggle Function (Livewire Component):**
```php
public function toggleGroup($groupName)
{
    // $groupName is passed as 'Europe' or 'Asia'
    // Implement select-all or deselect-all logic here...
}
```

**Blade Implementation:**
```blade
<x-form.checkbox
    :list="$countries"
    model="selectedCountries"
    label="Destination Countries"
    grouped
    toggle="toggleGroup"
    tooltip-key="description"
/>
```

---

## Date Picker

A powerful, native-feeling calendar date input wrapper that uses the AlpineJS date picker extension. It supports ranges, locales, and handles both Livewire property binding and normal HTML form submissions.

### Single Date Picker
```blade
<x-form.date model="appointment_date" label="Appointment Date" />
```

### Date Range Picker
When `range` is enabled, the component displays two side-by-side inputs for selecting start and end boundaries.
```blade
<x-form.date model="travel_dates" range label="Travel Duration" />
```

### Locales Support
Pass language codes to initialize localized date displays (e.g. `el`, `es`, `de`):
```blade
<x-form.date model="appointment_date" locale="el" label="Ημερομηνία" />
```

### Native HTML Form Mode
If the `model` attribute is omitted, the date picker works as a plain form input that writes to a hidden field for standard PHP POST requests.
```blade
<x-form.date name="birth_date" label="Date of Birth" />
```

---

## Disabled Inputs

The `x-form.disabled` component is used to display non-editable content in a clean, consistent format. It is equipped with quick-action wrapper tags that support instant interactivity without writing extra Javascript.

```blade
<x-form.disabled label="API Token" value="vkm_token_abcdef123456" copy />
```

### Supported Action Types

| Attribute | Core Behavior |
|---|---|
| `copy` | Clipboard copy button with automatic "Copied to clipboard" feedback |
| `link` | Displays as a clickable link that opens in a new tab |
| `mail` | Renders a `mailto:` link to open default email clients |
| `phone` | Renders a `tel:` link for direct call features |
| `fax` | Renders a `fax:` link |
| `map` | Renders a link that opens Google Maps with the address value preloaded |

### Advanced Usage Examples

**Display Currency Formatting:**
Prepend currency symbols based on config settings.
```blade
<x-form.disabled label="Invoice Value" value="1,240.00" currency="USD" />
```

**Custom Icon Overlay:**
```blade
<x-form.disabled label="Status" value="Active" icon="fa-solid fa-circle-check" />
```

**Prepend & Append Slots:**
```blade
<x-form.disabled value="vasilis.milopoulos@gmail.com" mail>
    <x-slot:prepend><span class="text-xs text-gray-500">[Verified]</span></x-slot:prepend>
</x-form.disabled>
```

---

## Rich Text Editor

An advanced WYSIWYG editor containing formatting tools, custom text and highlight colors, table structures, and links. It also has features for YouTube embeds, image sizing with borders/opacity, and Livewire File Manager integrations.

```blade
<x-form.editor model="html_content" label="Rich Text Content" with-filemanager />
```

> [!IMPORTANT]
> **Singleton Table Editor Requirement**  
> To use the rich text editor's custom table builder, you must render the shared editor modal singleton once in your application's layout file (usually right before the closing `</body>` tag):
> ```blade
> <x-form.editor-modal />
> ```

### Reactive Array Updates
If you are updating dynamic models and arrays inside Livewire and need the text editor's HTML to stay reactive without breaking input focus, pass the identifier of the tracked array inside the `watchFor` property:
```blade
<x-form.editor model="item.content" :watchFor="$item['id']" label="Editable Item" />
```

---

## File Upload

Allows users to upload files via standard buttons or high-fidelity, drag-and-drop dropzones.

### Standard Button Upload
```blade
<x-form.file model="attachment" label="Document Attachment" button="Choose File..." />
```

### Dropzone Uploader
Adds a dashed drag-and-drop zone that supports drop events and file list displays.
```blade
<x-form.file 
    model="attachments" 
    label="Upload Gallery" 
    dropzone 
    multiple 
    help="PNG, JPG or WEBP up to 5MB" 
/>
```

---

## File URL Browser

The `x-form.file-url` component combines a standard input field with the package's Livewire File Manager. Clicking the input allows the user to browse files inside their storage disk and attaches the selected file's public URL directly back to the text input.

```blade
<x-form.file-url model="avatar_url" label="Avatar Image URL" placeholder="Browse or paste URL..." />
```

---

## Icon Helper

A lightweight, centralized Blade component that renders vector SVGs from the package's default icon directory. This avoids duplicating inline SVG codes throughout layouts.

```blade
<x-form.icon name="trash" class="text-red-500 size-6" />
```

### Predefined Icon Names
The following keys are supported out-of-the-box:

`paragraph`, `headings`, `textcase`, `fontsize`, `bold`, `italic`, `underline`, `strikethrough`, `superscript`, `subscript`, `code`, `textcolor`, `backgroundcolor`, `alignment`, `alignleft`, `aligncenter`, `alignright`, `ul`, `ol`, `letter_list`, `table`, `link`, `video`, `image`, `cleanup`, `chevron-up`, `chevron-down`, `chevron-left`, `chevron-right`, `settings`, `trash`.

---

## Customization

### Publishing Component Views
If you need to tweak the HTML architecture of the inputs directly, publish the view files to your application directory:

```bash
php artisan vendor:publish --tag=x-form:views
```
The view files will be copied to `resources/views/vendor/x-form/`, allowing you to modify them without losing package update capabilities.

### Custom Styling in `config/x-form.php`
The styling is completely driven by configuration values. You can change global background behaviors, focus states, sizes, and borders:

```php
'inputs' => [
    'bg'      => 'bg-black/5 dark:bg-white/5 backdrop-blur-md shadow-xs',
    'border'  => 'border border-black/5 dark:border-white/10',
    'focus'   => 'focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-blue-400/50 focus:shadow-md outline-none',
],
```

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
