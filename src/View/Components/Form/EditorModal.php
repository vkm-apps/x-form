<?php

namespace VkmApps\XForm\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Singleton table editor modal component.
 *
 * Render once per page (before </body>) in your application layout:
 *
 *     <x-form.editor-modal />
 *
 * All <x-form.editor> instances communicate with this modal via the
 * custom window event 'editor:open-table-modal'. The Alpine data component
 * 'editorTableModal' (registered by the JS bundle) handles the state.
 */
class EditorModal extends Component
{
    public function render(): View|Closure|string
    {
        return view('x-form::editor-modal');
    }
}
