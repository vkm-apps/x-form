<?php

namespace VkmApps\XForm\View\Components\Form;

class CheckboxGroup extends Checkbox
{
    public function __construct(
        public ?array $list = null,
        public ?int $perColumn = 20,
        public ?int $total = 0,
        public ?string $uuid = null,
        public ?string $name = null,
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $model = null,
        public ?string $modifier = null,
        public ?string $rule = null,
        public ?string $tooltip = null,
        public ?string $help = null,
        public ?string $tooltipKey = null,
        public ?string $toggle = null,
        public ?string $layout = null,
        public bool $required = false,
        public bool $horizontal = false,
        public bool $grouped = true,
        public bool $group = true,
    ) {
        parent::__construct(
            list: $list,
            perColumn: $perColumn,
            total: $total,
            uuid: $uuid,
            name: $name,
            label: $label,
            icon: $icon,
            model: $model,
            modifier: $modifier,
            rule: $rule,
            tooltip: $tooltip,
            help: $help,
            tooltipKey: $tooltipKey,
            toggle: $toggle,
            layout: $layout,
            required: $required,
            horizontal: $horizontal,
            grouped: $grouped,
            group: $group,
        );
    }
}
