<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\ShopItem;
use App\Models\UserPoint;
use Illuminate\Support\Facades\Session;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_checkout_with_enough_points()
    {
        $user = User::factory()->create();
        $item = ShopItem::factory()->create([
            'stock' => 10,
            'point_cost' => 50
        ]);

        UserPoint::create([
            'user_id' => $user->id,
            'pickup_id' => null,
            'points' => 100
        ]);

        $this->actingAs($user)
            ->withSession([
                'cart' => [
                    $item->id => [
                        'item_id' => $item->id,
                        'name' => $item->name,
                        'qty' => 1,
                        'point_cost' => $item->point_cost,
                        'image' => null,
                    ]
                ]
            ])
            ->post(route('user.cart.checkout'))
            ->assertRedirect(route('user.pointCart'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('point_shop_transactions', [
            'user_id' => $user->id,
            'shop_item_id' => $item->id,
            'quantity' => 1,
            'point_used' => 50
        ]);

        $this->assertDatabaseHas('user_points', [
            'user_id' => $user->id,
            'points' => -50
        ]);
    }

    public function test_checkout_fails_if_not_enough_points()
    {
        $user = User::factory()->create();
        $item = ShopItem::factory()->create(['stock' => 5, 'point_cost' => 100]);

        UserPoint::create([
            'user_id' => $user->id,
            'pickup_id' => null,
            'points' => 50
        ]);

        $this->actingAs($user)
            ->withSession([
                'cart' => [
                    $item->id => [
                        'item_id' => $item->id,
                        'name' => $item->name,
                        'qty' => 1,
                        'point_cost' => $item->point_cost,
                        'image' => null,
                    ]
                ]
            ])
            ->post(route('user.cart.checkout'))
            ->assertSessionHas('error');
    }
}
