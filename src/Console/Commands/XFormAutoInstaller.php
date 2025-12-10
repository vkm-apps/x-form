<?php

namespace VkmApps\XForm\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class XFormAutoInstaller extends Command
{
    protected $signature = 'x-form:install';

    protected $description = 'X-Form Blade Components';

    public function handle(): void
    {
        $this->info('Publishing X-Form Configuration...');

        Artisan::call('vendor:publish --tag=x-form:config');
        Artisan::call('vendor:publish --tag=VkmApps\XForm\ServiceProvider');

        $this->info('Successfully installed!');
    }
}
