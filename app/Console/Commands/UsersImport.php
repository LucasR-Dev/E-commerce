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
    $response = Http::get('https://fakestoreapi.com/users?limit=10');
    $usersData = $response->json();
    // dd($usersData);

    foreach ($usersData as $userData) {

        
        // Verifique se o usuário já existe no banco de dados antes de inserir para evitar duplicatas
        $existingUser = User::where(['email' => $userData['email']])->first();

        if (!$existingUser) {
            // Se o usuário não existe, insira-o no banco de dados
            User::create([
                'name' => $userData['username'],
                'email' => $userData['email'],
                'password' => bcrypt($userData['password']),
            ]);
            }
        }

        $this->info('Users imported successfully!');
    }
}

// Comando para importar a cada 2 minutos: php artisan schedule:run >> /dev/null 2>&1
// Comando parar verificar se está rodando: php artisan schedule:work
