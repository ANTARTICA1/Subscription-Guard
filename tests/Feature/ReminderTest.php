<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_reminder_command_runs_successfully(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test', 'icon' => '📦', 'color' => '#000']);

        Subscription::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Test Sub',
            'amount' => 100000,
            'currency' => 'IDR',
            'billing_cycle' => 'monthly',
            'payment_date' => now()->addDays(3)->day,
            'start_date' => now()->subMonth(),
            'reminder_days' => 3,
            'status' => 'active',
        ]);

        $this->artisan('subscriptions:check-reminders')
            ->assertExitCode(0);
    }
}
