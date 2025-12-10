<?php

namespace VkmApps\XForm;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use VkmApps\XForm\Console\Commands\XFormAutoInstaller;
use VkmApps\XForm\Livewire\FileManager;
use VkmApps\XForm\View\Components\Form\Checkbox;
use VkmApps\XForm\View\Components\Form\Date;
use VkmApps\XForm\View\Components\Form\Disabled;
use VkmApps\XForm\View\Components\Form\Editor;
use VkmApps\XForm\View\Components\Form\File;
use VkmApps\XForm\View\Components\Form\Input;
use VkmApps\XForm\View\Components\Form\Label;
use VkmApps\XForm\View\Components\Form\Password;
use VkmApps\XForm\View\Components\Form\Radio;
use VkmApps\XForm\View\Components\Form\Select;
use VkmApps\XForm\View\Components\Form\Textarea;

class XFormServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register Livewire component filemanager
        Livewire::component('filemanager', FileManager::class);

        // Publish config file
        $this->publishes([__DIR__ . '/../config/x-form.php' => $this->getConfigPath()], 'x-form:config');

        // Load views for components (Blade components)
        $this->loadViewsFrom(__DIR__.'/../resources/views/components/form', 'x-form');

        // Optionally load general package views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'x-form');

        // Publish Blade components' views
        $this->publishes([
            __DIR__ . '/../resources/views/components/form' => resource_path('views/vendor/x-form'),
        ], 'x-form:views');

        // Publish Livewire views
        $this->publishes([
            __DIR__.'/../resources/views/livewire' => resource_path('views/vendor/vkm-apps/filemanager'),
        ], 'views');

        // Register Blade components (if necessary)
        $this->registerBladeComponents();

        // Register console commands
        if ($this->app->runningInConsole()) {
            $this->commands([XFormAutoInstaller::class]);
        }
    }

    public function register(): void
    {
        // Merge package config with the app's config
        $this->mergeConfigFrom(__DIR__.'/../config/x-form.php', 'x-form');
    }

    protected function registerBladeComponents(): void
    {
        Blade::component('form.checkbox-group', Checkbox::class);
        Blade::component('form.checkbox', Checkbox::class);
        Blade::component('form.input', Input::class);
        Blade::component('form.date', Date::class);
        Blade::component('form.editor', Editor::class);
        Blade::component('form.label', Label::class);
        Blade::component('form.radio', Radio::class);
        Blade::component('form.select', Select::class);
        Blade::component('form.file', File::class);
        Blade::component('form.textarea', Textarea::class);
        Blade::component('form.disabled', Disabled::class);
        Blade::component('form.password', Password::class);
    }

    public function provides()
    {
        return ['x-form'];
    }

    protected function getConfigPath()
    {
        return config_path('x-form.php');
    }
}

