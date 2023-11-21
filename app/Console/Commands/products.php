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
    protected $signature = 'products:import {--id=} {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command to import data from another api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      
    }
}
