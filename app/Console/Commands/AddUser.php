<?php

namespace App\Console\Commands;

use App\Models\UserBalance;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление нового пользователя';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (User::where('email', $email)->exists()) {
            $this->error('Пользователь с таким email уже существует!');
            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        if ($user) {
            UserBalance::create([
                'user_id' => $user->id,
                'balance' => 0,
            ]);
        }

        $this->info('Пользователь успешно создан!');

        return 0;
    }
}
