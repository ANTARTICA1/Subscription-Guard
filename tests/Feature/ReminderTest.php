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
        $category = Category::create(['name' => 'Test', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>', 'color' => '#000']);

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
