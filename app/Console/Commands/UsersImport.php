<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UsersImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando de importar usuários do fakestoreapi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://fakestoreapi.com/users?limit=5');
        $users = $response->json();
        dd($users);

        $this->info('Users imported successfully!');

    }
}
