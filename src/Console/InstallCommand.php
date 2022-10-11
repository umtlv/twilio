<?php

namespace Umtlv\Twilio\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twilio:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Twilio resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Publishing Twilio Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'twilio-config']);

        $this->info('Twilio installed successfully.');
    }
}