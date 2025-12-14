# VKM APPS | X-Form

X-Form is a fully customized package of Blade components for **Laravel 10+**, built with **Livewire 3+**, **Tailwind CSS 4**, and **AlpineJS 3**. It simplifies the creation of dynamic, interactive forms while keeping them fully customizable.

To enjoy full compatibility use along with AlpineJS plugins:
https://github.com/vkm-apps/vkm-js


## Installation

Install X-Form and via Composer:

```
composer require vkm-apps/x-form
```

Publish the configuration files:

```
php artisan x-form:install
# or
php artisan vendor:publish
```
Once published, you can customize field layouts, icons, colors, and Tailwind classes to match your project’s design.

---

## Available Components

X-Form provides the following Blade components:

* `x-form.input`
* `x-form.checkbox`
* `x-form.radio`
* `x-form.select`
* `x-form.textarea`
* `x-form.file`
* `x-form.editor`
* `x-form.date`
* `x-form.password`
* `x-form.disabled`

---

## Usage

All components follow a consistent syntax to bind to Livewire model properties and automatically handle labels, validation, and interactivity.

### Basic Syntax

```blade
<x-form.input
  model="livewireProperty"
  label="Field Label (HTML allowed)"
  blur
  required
/>
```

---

## Input

A fully customizable input field with a label, validation, and input tag by default.

```blade
<x-form.input model="title" label="Title" />
```

**Required field:**

```blade
<x-form.input model="title" label="Title" required />
```

**Live updates:**

```blade
<x-form.input model="title" label="Title" live />
```

**Custom input type:**

```blade
<x-form.input type="number" model="title" label="Title" :required="$is_confirmed"/>
```

**Custom label slot:**

```blade
<x-form.input type="number" model="title">
    <x-slot:label><span class="text-bold">Custom Title</span></x-slot:label>
</x-form.input>
```

---

## Select

Render a select dropdown with an array in the format `['value' => 'label']`.

```blade
<x-form.select :list="$this->yourList" model="country" label="Country of Origin" />
```

**Livewire component example:**

```php
#[Computed]
public function yourList(): array
{
    return YourModel::pluck('option_value', 'text_title')->toArray();
}
```

> Arrays use string keys to preserve frontend ordering.

---

## Editor
> Requires @vkm-js/editor & @vkm-js/dropdown alpine plugins

The Editor component provides a rich content editor with all the essential tools for writing, editing, and styling text. It supports advanced formatting and can optionally integrate a file manager for uploading and selecting media files.

* Add the with-filemanager attribute to enable file management.

* By default, uploaded files are stored on the media disk. You can change this in the x-form.php configuration file.

Example usage:
```
<x-form.editor model="html.en" label="Content" with-filemanager />
```

This will render a fully-featured editor for the html.en property with file manager support enabled.

---

## Checkboxes and Radio Buttons

Checkboxes and radios work similarly to `x-form.select`, using an array for options.

```blade
<x-form.checkbox :list="$this->yourList" model="country" label="Country of Origin" />
```

**Horizontal layout:**

```blade
<x-form.radio :list="$this->yourList" model="country" label="Country of Origin" horizontal />
```

---

## Grouped Checkboxes

Grouped checkboxes support **tooltips** and **toggle actions per group**.

* `label` → Main group label
* `title` → Key name for each subgroup
* `toggle="functionName"` → Function to handle group toggle (e.g., select all)
* `tooltip-key` → Field in the array to show tooltip

**Example array:**

```php
$countries = [
  'europe' => [
      ['id' => '55', 'title' => 'Greece', 'description' => 'Greece, officially the Hellenic Republic...'],
      ['id' => '111', 'title' => 'Italy', 'description' => 'Italy is a country...'],
  ],
];
```

**Example toggle function:**

```php
public function yourFunction($category)
{
    // $category is 'europe'
}
```

**Grouped checkbox Blade example:**

```blade
<x-form.checkbox
    :list="$countries"
    label="Countries"
    model="countries"
    toggle="yourClickFunctionForSelectingAllEuropeCountries"
    tooltip-key="description"
    grouped
    required
/>
```

---

## Disabled Inputs

Use `x-form.disabled` to display non-editable content. You can include copy buttons or other actions without writing additional JS.

```blade
<x-form.disabled label="Title" copy>
    <p>Content here is read-only but can be copied.</p>
</x-form.disabled>
```

> Copy functionality is powered by AlpineJS by default.

```
