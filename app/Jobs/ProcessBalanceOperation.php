<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserBalance;
use App\Models\Operation;
use Illuminate\Support\Facades\Log;

class ProcessBalanceOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $amount;
    protected $description;

    public function __construct($email, $amount, $description)
    {
        $this->email = $email;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function handle(): void
    {
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            Log::error('Пользователь с email ' . $this->email . ' не найден.');
            return;
        }

        $balance = UserBalance::where('user_id', $user->id)->first();

        if ($balance->balance + $this->amount < 0) {
            Log::error('Операция уводит баланс в минус для пользователя с email ' . $this->email);
            return;
        }

        $balance->balance += $this->amount;
        $balance->save();

        Operation::create([
            'user_id' => $user->id,
            'amount' => $this->amount,
            'description' => $this->description,
        ]);

        Log::info('Операция успешно выполнена для пользователя с email ' . $this->email);
    }
}
