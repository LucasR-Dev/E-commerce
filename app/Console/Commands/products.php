<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class products extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will import the requested item using the id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
