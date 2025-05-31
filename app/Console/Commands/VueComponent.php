<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VueComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new vue component';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
    }
}
