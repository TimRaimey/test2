<?php

namespace App\Console\Commands;

use App\Jobs\ProcessBalanceOperation;
use Illuminate\Console\Command;

class BalanceOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operation:balance {email} {amount} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Выполняет операцию по счету пользователя';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $amount = $this->argument('amount');
        $description = $this->argument('description');

        // Добавление задания в очередь
        ProcessBalanceOperation::dispatch($email, $amount, $description);

        $this->info('Операция добавлена в очередь.');
    }
}
