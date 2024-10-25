<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserBalance>
 */
class UserBalanceFactory extends Factory
{
    protected $model = UserBalance::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'balance' => 3000,
        ];
    }
}
