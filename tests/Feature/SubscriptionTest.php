<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::create([
            'name' => 'Entertainment',
            'icon' => '🎬',
            'color' => '#ef4444',
        ]);
    }

    public function test_user_can_view_subscriptions(): void
    {
        $this->actingAs($this->user)
            ->get(route('subscriptions.index'))
            ->assertStatus(200);
    }

    public function test_user_can_create_subscription(): void
    {
        $response = $this->actingAs($this->user)->post(route('subscriptions.store'), [
            'category_id' => $this->category->id,
            'name' => 'Netflix',
            'amount' => 186000,
            'currency' => 'IDR',
            'billing_cycle' => 'monthly',
            'payment_date' => 25,
            'start_date' => '2024-01-01',
            'auto_renew' => true,
            'reminder_days' => 3,
            'status' => 'active',
        ]);

        $response->assertRedirect(route('subscriptions.index'));
        $this->assertDatabaseHas('subscriptions', ['name' => 'Netflix']);
    }

    public function test_user_can_update_subscription(): void
    {
        $subscription = Subscription::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'name' => 'Netflix',
            'amount' => 186000,
            'currency' => 'IDR',
            'billing_cycle' => 'monthly',
            'payment_date' => 25,
            'start_date' => '2024-01-01',
            'reminder_days' => 3,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->put(route('subscriptions.update', $subscription), [
            'category_id' => $this->category->id,
            'name' => 'Netflix Premium',
            'amount' => 230000,
            'currency' => 'IDR',
            'billing_cycle' => 'monthly',
            'payment_date' => 25,
            'start_date' => '2024-01-01',
            'reminder_days' => 3,
            'status' => 'active',
        ]);

        $response->assertRedirect(route('subscriptions.index'));
        $this->assertDatabaseHas('subscriptions', ['name' => 'Netflix Premium', 'amount' => 230000]);
    }

    public function test_user_can_delete_subscription(): void
    {
        $subscription = Subscription::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'name' => 'Netflix',
            'amount' => 186000,
            'currency' => 'IDR',
            'billing_cycle' => 'monthly',
            'payment_date' => 25,
            'start_date' => '2024-01-01',
            'reminder_days' => 3,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->delete(route('subscriptions.destroy', $subscription));
        $response->assertRedirect(route('subscriptions.index'));
        $this->assertDatabaseMissing('subscriptions', ['id' => $subscription->id]);
    }

    public function test_user_cannot_edit_other_users_subscription(): void
    {
        $otherUser = User::factory()->create();
        $subscription = Subscription::create([
            'user_id' => $otherUser->id,
            'category_id' => $this->category->id,
            'name' => 'Netflix',
            'amount' => 186000,
            'currency' => 'IDR',
            'billing_cycle' => 'monthly',
            'payment_date' => 25,
            'start_date' => '2024-01-01',
            'reminder_days' => 3,
            'status' => 'active',
        ]);

        $this->actingAs($this->user)
            ->get(route('subscriptions.edit', $subscription))
            ->assertStatus(403);
    }
}
