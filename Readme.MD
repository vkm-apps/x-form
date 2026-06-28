# VKM APPS | X-Form

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vkm-apps/x-form.svg?style=flat-square)](https://packagist.org/packages/vkm-apps/x-form)
[![Total Downloads](https://img.shields.io/packagist/dt/vkm-apps/x-form.svg?style=flat-square)](https://packagist.org/packages/vkm-apps/x-form)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)


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
| [`<x-form.input>`](#input) | Standard text/number inputs | Prepend/append slots, live validation, group sizing, tooltips/popovers |
| [`<x-form.textarea>`](#textarea) | Multiline text input | Auto-resizing heights, character countdown counter, limit restriction |
| [`<x-form.password>`](#password) | Password entry | Interactive visibility toggle (eye/eye-off icon) |
| [`<x-form.select>`](#select-and-dropdown) | Select dropdowns | Rich searchable dropdowns, inline search, native select fallback |
| [`<x-form.checkbox>`](#checkboxes-and-radio-buttons) | Checkboxes | Single/grouped layouts, nested modules with tooltip and group toggles |
| [`<x-form.radio>`](#checkboxes-and-radio-buttons) | Radio buttons | Consistent styling, horizontal/vertical layouts |
| [`<x-form.date>`](#date-picker) | Native date picker | Range date pickers, multi-locale, Livewire & plain HTML form bindings |
| [`<x-form.disabled>`](#disabled-inputs) | Rich read-only displays | Inline actions (Copy, Link, Mail, Phone, Fax, Maps), currency formatting |
| [`<x-form.money>`](#money-input) | Locale-aware currency inputs | Dynamic AlpineJS masking, automatic locale/currency formatting, raw float bindings, dynamic placeholders |
| [`<x-form.editor>`](#rich-text-editor) | Rich text WYSIWYG editor | Formatting, colors, tables, YouTube embeds, custom image editor |
| [`<x-form.editor-modal>`](#rich-text-editor) | Singleton table manager | Renders the shared table management modal |
| [`<x-form.file>`](#file-upload) | File uploader | File previews, drag-and-drop dropzones, multiple file support |
| [`<x-form.file-url>`](#file-url-browser) | File-URL selector | Integrated file manager popup to insert public file URLs directly |
| [`<x-form.icon>`](#icon-helper) | SVG icon utility | Lightweight helper to render predefined system icons |

---

## Global Features & Shared Attributes

All components inheriting from the core `FormElement` support a set of rich, interactive features that make writing beautiful, accessible interfaces straightforward:

### 1. Tooltips & Help Popovers
Add quick informational tips next to your labels automatically.
- `tooltip="Your message"`: Shows a small info icon next to the label that displays a tooltip on hover.
- `help="Your rich HTML message"`: Shows an info icon that opens an AlpineJS popover dialog on click.

```blade
<x-form.input model="title" label="Title" tooltip="This is a short tooltip." />
<x-form.input model="slug" label="Slug" help="<strong>URL friendly</strong> slug. Only letters, numbers, and dashes are allowed." />
```

### 2. Required Markings
- `required`: Adds a red asterisk (`*`) to the label automatically.

```blade
<x-form.input model="name" label="Name" required />
```

### 3. Prepend & Append Slots
Enables nesting icons, buttons, text badges, or custom HTML inside the input layout.
- `<x-slot:prepend>`: Inserts content before the input field.
- `<x-slot:append>`: Inserts content after the input field.

```blade
<x-form.input model="price" label="Price" type="number">
    <x-slot:prepend><span class="px-2 text-gray-500">$</span></x-slot:prepend>
    <x-slot:append><span class="px-2 text-gray-500">USD</span></x-slot:append>
</x-form.input>
```

### 4. Livewire Model Modifiers
Binds model updates utilizing Livewire modifiers out of the box:
- `live`: Updates the model on every keypress (`wire:model.live`).
- `blur`: Updates the model when input focus is lost (`wire:model.live.blur`).
- `change`: Updates the model when input selection changes (`wire:model.live.change`).

```blade
<x-form.input model="search" label="Search" live />
```

---

## Input

A fully customizable input field with automated label generation, validation highlights, accessibility attributes, and error message outputs.

```blade
<x-form.input model="title" label="Title" />
```

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `model` | `string\|null` | `null` | The Livewire model property to bind to. |
| `name` | `string\|null` | `null` | Name attribute (defaults to `model`). |
| `label` | `string\|null` | `null` | Text label display. |
| `type` | `string` | `'text'` | HTML input type (`number`, `email`, `tel`, `url`, `text`, etc.). |
| `placeholder`| `string\|null` | `null` | Input placeholder text. |
| `icon` | `string\|null` | `null` | Icon CSS classes (e.g. FontAwesome) displayed next to the label. |
| `required` | `bool` | `false` | Marks the field as required (red asterisk). |
| `tooltip` | `string\|null` | `null` | Tooltip info text. |
| `help` | `string\|null` | `null` | Rich HTML help popover content. |
| `group` | `string\|bool` | `false` | Flex sizing wrapper. Values: `'sm'`, `'lg'`, `'xl'`, or `false`. |
| `validate` | `string\|bool` | `false` | Client-side validation trigger. Values: `'blur'`, `true` (keyup), or `false`. |
| `border` | `bool` | `true` | Show input border. |
| `invalid` | `bool` | `false` | Manually force the input to show validation error styling. |

```blade
{{-- Large, instantly validating number input --}}
<x-form.input type="number" model="age" label="Age" group="lg" validate="blur" required />
```

---

## Textarea

Textareas support character counts, maximum limits, auto-height resizing, and error bindings.

```blade
<x-form.textarea model="description" label="Description" placeholder="Enter details..." />
```

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `model` | `string\|null` | `null` | The Livewire model property to bind to. |
| `name` | `string\|null` | `null` | Name attribute. |
| `label` | `string\|null` | `null` | Text label display. |
| `rows` | `int` | `5` | Height size in rows. |
| `limit` | `int` | `0` | Character limit. If `> 0`, turns count display into remaining counter. |
| `showCount` | `bool` | `true` | Show/hide the character counter underneath. |
| `icon` | `string\|null` | `null` | Icon classes beside the label. |
| `required` | `bool` | `false` | Marks the field as required. |
| `tooltip` | `string\|null` | `null` | Tooltip text. |
| `help` | `string\|null` | `null` | Help popover content. |

```blade
{{-- Textarea with a 250-character limit counter --}}
<x-form.textarea model="bio" label="Biography" limit="250" rows="4" required />
```

---

## Password

A secure password input that automatically renders a show/hide toggle button (eye icon) using AlpineJS under the hood.

```blade
<x-form.password model="password" label="New Password" required />
```

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `model` | `string\|null` | `null` | The Livewire model property to bind to. |
| `name` | `string\|null` | `null` | Name attribute. |
| `label` | `string\|null` | `null` | Text label display. |
| `icon` | `string\|null` | `null` | Icon classes next to the label. |
| `required` | `bool` | `false` | Marks the field as required. |
| `tooltip` | `string\|null` | `null` | Tooltip text. |
| `help` | `string\|null` | `null` | Help popover content. |
| `group` | `string\|null` | `null` | Sized wrapper. Supported values: `'sm'`, `'lg'`, `'xl'`, or `null`. |
| `validate` | `string\|bool` | `false` | Real-time validation trigger (`'blur'`, `true`, or `false`). |

---

## Select and Dropdown

Renders an interactive dropdown with custom searching, styled scrollbars, and dynamic state bindings. Alternatively, it can fall back to a native browser select element.

```blade
<x-form.select :list="$this->countryList" model="country" label="Country of Origin" />
```

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `list` | `array\|null` | `['yes'=>1,'no'=>0]`| Options mapping array (formatted as `Label => Value` or `Title => ID`). |
| `model` | `string\|null` | `null` | The Livewire model property to bind to. |
| `name` | `string\|null` | `null` | Name attribute. |
| `label` | `string\|null` | `null` | Text label display. |
| `title` | `string` | `'-'` | Default display placeholder text (e.g. "Select an option"). |
| `icon` | `string\|null` | `null` | Prepend HTML or CSS class icon inside the select button. |
| `searchable` | `bool` | `false` | Enable/disable text filter search within the list. |
| `inline` | `bool` | `false` | Place the search input inline inside the popup instead of overlaying the select button. |
| `dropdown` | `bool` | `true` | Renders a styled custom dropdown. Set to `false` to fallback to native `<select>`. |
| `minWidth` | `string` | `'revert-layer'`| Set dropdown container minimum width (e.g. `'250px'`). |
| `maxHeight` | `string` | `'400px'` | Set dropdown container maximum height (e.g. `'300px'`). |
| `required` | `bool` | `false` | Marks the field as required. |
| `tooltip` | `string\|null` | `null` | Tooltip text. |
| `help` | `string\|null` | `null` | Help popover content. |
| `live` | `bool` | `false` | Force live updates immediately upon item selection. |

### Options Array Format
Ensure arrays use string keys to preserve ordering on the frontend:

```php
#[Computed]
public function countryList(): array
{
    return [
        'Greece' => 'gr',
        'Italy' => 'it',
        'Spain' => 'es',
    ];
}
```

### Advanced Select Usage

```blade
{{-- Custom searchable dropdown with inline input --}}
<x-form.select
    :list="$this->countryList"
    model="country"
    label="Country"
    searchable
    inline
    title="Choose a destination..."
/>

{{-- Native browser select fallback --}}
<x-form.select
    :list="$this->countryList"
    model="country"
    label="Country"
    :dropdown="false"
/>
```

---

## Checkboxes and Radio Buttons

Tailwind-styled choice groups supporting horizontal/vertical alignments, descriptions, tooltips, and interactive group toggles.

### Single Checkbox (Boolean)
If you omit the `:list` attribute, the component renders a single checkbox representing a boolean value (e.g., binds to a boolean property `true`/`false`). The label is displayed inline next to the checkbox.
```blade
<x-form.checkbox model="remember_me" label="Remember Me" required />
```

### Flat Checkbox Group
If you pass the `:list` attribute, the component renders a list of checkboxes matching the option keys and values. The label is displayed as a header above the list.
```blade
<x-form.checkbox :list="$this->optionsList" model="interests" label="Interests" />
```

### Radio Group
```blade
<x-form.radio :list="$this->optionsList" model="gender" label="Gender" />
```

### Component Properties (Checkbox & Radio)

| Attribute | Type | Default | Description |
|---|---|---|---|
| `list` | `array\|null` | `null` | Options array (`Title => Value`). If null, renders a single boolean checkbox. |
| `model` | `string\|null` | `null` | Livewire model binding. |
| `name` | `string\|null` | `null` | Name attribute. |
| `label` | `string\|null` | `null` | Label text. |
| `horizontal` | `bool` | `false` | Render list horizontally. (Vertical stack is the default). |
| `required` | `bool` | `false` | Marks the field as required. |
| `tooltip` | `string\|null` | `null` | Tooltip icon and message text. |
| `help` | `string\|null` | `null` | Help popover icon and HTML content. |
| **Checkbox Only** | | | |
| `grouped` | `bool` | `false` | Enables nested category groups (requires multi-dimensional list). |
| `group` | `bool` | `false` | Alias for `grouped`. |
| `perColumn` | `int` | `20` | Columns chunk sizes. |
| `toggle` | `string\|null` | `null` | Livewire method called when category header checkbox is clicked (bypasses default AlpineJS toggle). |
| `tooltipKey` | `string\|null` | `null` | Array key used for items tooltips when `grouped` is true. |

```blade
{{-- Horizontal row alignment for Radios --}}
<x-form.radio :list="$this->optionsList" model="gender" horizontal />
```

---

### Grouped Checkboxes (With Header Checkboxes & Tooltips)

Grouped checkboxes are designed for complex nested layouts (e.g., system permissions categorized by module) and support dynamic **tooltips** and **automatic header toggles**.

You can use either:
```blade
<x-form.checkbox-group :list="$countries" model="selectedCountries" label="Destination Countries" />
```
or the `group` attribute alias:
```blade
<x-form.checkbox :list="$countries" model="selectedCountries" label="Destination Countries" group />
```

**Header Checkbox Select-All**: Each category header features a functional checkbox. Checking/unchecking the header checkbox toggles all items in that category client-side via AlpineJS. In addition, checking all individual items in a category automatically checks the header checkbox.

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

**Custom Livewire Toggle Function (Optional):**
If you want to run backend PHP code when a group header is clicked, pass the `toggle` attribute with your Livewire method name:
```php
public function toggleGroup($groupName)
{
    // $groupName is passed as 'Europe' or 'Asia'
    // Custom select-all or deselect-all logic here...
}
```

```blade
<x-form.checkbox
    :list="$countries"
    model="selectedCountries"
    label="Destination Countries"
    group
    toggle="toggleGroup"
    tooltip-key="description"
/>
```

---

## Date Picker

A powerful, native-feeling calendar date input wrapper that uses the AlpineJS date picker extension. It supports ranges, locales, and handles both Livewire property binding and normal HTML form submissions.

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `model` | `string\|null` | `null` | Livewire model property. |
| `name` | `string\|null` | `null` | Name attribute. |
| `label` | `string\|null` | `null` | Text label display. |
| `range` | `bool` | `false` | Enable range picker (displays side-by-side start and end inputs). |
| `locale` | `string` | `'en'` | Locale language code (e.g. `'el'`, `'es'`, `'de'`). |
| `required` | `bool` | `false` | Marks field as required. |
| `icon` | `string\|null` | `null` | Custom icon beside label. |
| `tooltip` | `string\|null` | `null` | Tooltip info text. |
| `help` | `string\|null` | `null` | Help popover content. |

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
Pass language codes to initialize localized date displays:
```blade
<x-form.date model="appointment_date" locale="el" label="Ημερομηνία" />
```

### Native HTML Form Mode
If the `model` attribute is omitted, the date picker works as a plain form input writing to a hidden field for standard PHP POST requests.
- **Single date mode:** Submits to the input `name` parameter.
- **Range date mode:** Submits to `[name]_start` and `[name]_end` (e.g., if `name="travel_dates"`, POST fields will be `travel_dates_start` and `travel_dates_end`).

```blade
{{-- Submits birth_date --}}
<x-form.date name="birth_date" label="Date of Birth" />

{{-- Submits hotel_dates_start and hotel_dates_end --}}
<x-form.date name="hotel_dates" range label="Hotel Booking" />
```

---

## Disabled Inputs

The `x-form.disabled` component displays non-editable content in a clean, consistent format. It is equipped with quick-action wrapper tags that support instant interactivity without writing extra Javascript.

```blade
<x-form.disabled label="API Token" value="vkm_token_abcdef123456" copy />
```

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `label` | `string\|null` | `null` | Text label display. |
| `value` | `string\|null` | `null` | Value string to display. |
| `icon` | `string\|null` | `null` | Icon classes or custom SVG string overlay. |
| `currency` | `string\|null` | `null` | Currency symbol formatting based on code (e.g., `'USD'`, `'EUR'`). |
| `copy` | `bool` | `false` | Adds a copy-to-clipboard button with instant feedback. |
| `link` | `bool` | `false` | Renders the value as a clickable link that opens in a new tab. |
| `mail` | `bool` | `false` | Renders a `mailto:` link to open the default email client. |
| `phone` | `bool` | `false` | Renders a `tel:` link for direct call features. |
| `fax` | `bool` | `false` | Renders a `fax:` link. |
| `map` | `bool` | `false` | Renders a link that opens Google Maps with the address value preloaded. |
| `tooltip` | `string\|null` | `null` | Tooltip info text. |

### Advanced Usage Examples

**Display Currency Formatting:**
Prepend locale-aware currency symbols dynamically resolved from the ISO code.
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

## Money Input

A locale-aware, highly polished money input component built with AlpineJS masking (`x-mask:dynamic`). It formats user input dynamically with correct thousands and decimal separators based on locale and currency settings, while sending and maintaining a raw numeric float value to Livewire or traditional form submissions.

```blade
<x-form.money model="price" label="Unit Price" />
```

### Key Features

1. **Automatic Locale & Currency Resolution**: Using PHP's `NumberFormatter` class, the component automatically resolves the decimal separator, thousands separator, currency symbol, symbol position (prefix vs. suffix), and default precision.
2. **Dynamic Placeholders**: If no explicit `placeholder` is provided, the component dynamically generates a formatted placeholder representing the currency format (e.g. `1,000.00` for `en-US` / `USD`, or `1.000,00` for `de-DE` / `EUR`).
3. **Dual Bindings**: A visible, styled text input handles the masked presentation using AlpineJS, while a hidden input stores the raw, unformatted float value (`rawValue`) for clean database storing and Livewire updates.
4. **Livewire & Plain HTML Form Support**: Integrates seamlessly with Livewire's binding modifiers (`live`, `blur`, `change`) and supports traditional form submissions using the `name` attribute.

### Component Properties

| Attribute | Type | Default | Description                                                                                                                     |
|---|---|---|---------------------------------------------------------------------------------------------------------------------------------|
| `model` | `string\|null` | `null` | The Livewire model property to bind to.                                                                                         |
| `name` | `string\|null` | `null` | Name attribute for traditional forms (defaults to `model`).                                                                     |
| `label` | `string\|null` | `null` | Text label display.                                                                                                             |
| `placeholder`| `string\|null` | `null` | Custom input placeholder. Defaults to a dynamically generated placeholder (e.g., `1,000.00`) based on resolved settings.        |
| `currency` | `string\|null` | `null` | ISO 3-letter currency code (e.g. `'USD'`, `'EUR'`, `'GBP'`). Falls back to `config('x-form.currency')`.                         |
| `locale` | `string\|null` | `null` | Locale tag (e.g. `'en_US'`, `'el_GR'`, `'de_DE'`, `'en'`) or language (`'en'`, `'de'`, etc.). Falls back to application locale. |
| `precision` | `int` | `2` | Number of decimal places. Falls back to currency's default precision resolved via `NumberFormatter`.                            |
| `icon` | `string\|null` | `null` | Icon classes next to the label.                                                                                                 |
| `required` | `bool` | `false` | Marks the field as required (red asterisk).                                                                                     |
| `tooltip` | `string\|null` | `null` | Tooltip info text.                                                                                                              |
| `help` | `string\|null` | `null` | Rich HTML help popover content.                                                                                                 |
| `group` | `string\|bool` | `false` | Sizing wrapper. Supported values: `'sm'`, `'lg'`, `'xl'`, or `false`.                                                           |
| `validate` | `string\|bool` | `false` | Client-side validation trigger. Supported values: `'blur'`, `true` (keyup), or `false`.                                         |
| `border` | `bool` | `true` | Show input border.                                                                                                              |
| `invalid` | `bool` | `false` | Force the input to display validation error styling.                                                                            |

### Advanced Examples

**Custom Currency & Locale:**
Explicitly define a different currency and locale. The input automatically positions the symbol (prefix or suffix) and formats numbers correctly.
```blade
{{-- German locale with Euro (symbol € placed as suffix, e.g. 1.000,00) --}}
<x-form.money model="price" label="Price" currency="EUR" locale="de-DE" />

{{-- US locale with GBP (symbol £ placed as prefix, e.g. £1,000.00) --}}
<x-form.money model="price" label="Price in Pounds" currency="GBP" locale="en-US" />
```

**Custom Decimal Precision:**
You can specify custom decimal precision (e.g., for commodities, exchange rates, or precision pricing).
```blade
<x-form.money model="rate" label="Exchange Rate" precision="4" />
```

---

## Rich Text Editor

An HTML WYSIWYG editor containing formatting tools, custom text and highlight colors, table structures, and links. It also has features for YouTube embeds, image sizing, and Livewire File Manager integrations.

```blade
<x-form.editor model="html_content" label="Rich Text Content" with-filemanager />
```

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `model` | `string\|null` | `null` | Livewire model property to bind to. |
| `label` | `string\|null` | `null` | Text label display. |
| `content` | `string\|null` | `null` | Initial HTML content. |
| `watchFor` | `string\|null` | `null` | Tracked variable (e.g. record ID) to force reactive HTML updates when records switch. |
| `withFilemanager`| `bool` | `false` | Enable Livewire File Manager button for inserting media URLs. |

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

```blade
<x-form.file model="attachment" label="Document Attachment" button="Choose File..." />
```

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `model` | `string\|null` | `null` | Livewire model binding. |
| `name` | `string\|null` | `null` | Name attribute. |
| `label` | `string\|null` | `null` | Header label. |
| `button` | `string\|null` | `null` | Custom button text (e.g. `'Choose File...'`). |
| `multiple` | `string\|bool\|null`| `null` | Enable multiple file uploads. Set to `true` or `'multiple'`. |
| `dropzone` | `bool` | `false` | Enable drag-and-drop upload zone layout. |
| `help` | `string\|null` | `null` | Information text (usually displayed in dropzone or below button). |
| `required` | `bool` | `false` | Marks field as required. |
| `tooltip` | `string\|null` | `null` | Tooltip info text. |

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

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `model` | `string\|null` | `null` | The Livewire model property to bind to. |
| `label` | `string\|null` | `null` | Text label display. |
| `placeholder`| `string\|null` | `null` | Input placeholder text. |
| `required` | `bool` | `false` | Marks field as required. |
| `tooltip` | `string\|null` | `null` | Tooltip info text. |
| `help` | `string\|null` | `null` | Help popover content. |
| `validate` | `string\|bool` | `false` | Real-time validation trigger (`'blur'`, `true`, or `false`). |
| `border` | `bool` | `true` | Show input border. |

---

## Icon Helper

A lightweight, centralized Blade component that renders vector SVGs from the package's default icon directory. This avoids duplicating inline SVG codes throughout layouts.

```blade
<x-form.icon name="trash" class="text-red-500 size-6" />
```

### Component Properties

| Attribute | Type | Default | Description |
|---|---|---|---|
| `name` | `string` | *(Required)* | Predefined icon name key. |
| `class` | `string` | `'size-5'` | Custom CSS classes applied to the SVG tag. |

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
