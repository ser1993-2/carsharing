<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAdminTest extends TestCase
{

    use RefreshDatabase;

    public function test_index_cars()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);
        $user = User::find(2);

        $response = $this->actingAs($user)
            ->withToken($user->createToken('API Token')->accessToken)
            ->get('/api/admin/car');

        $response->assertStatus(403);

        $response = $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->get('/api/admin/car');

        $response->assertStatus(200);
    }

    public function test_show_car()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $response = $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->get('/api/admin/car/1');

        $response->assertStatus(200);
    }

    public function test_store_car()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $carId = Car::insertGetId([
            'car_brand_id' => rand(1,10),
            'rate_id' => rand(1,5),
            'is_active' => true,
            'is_free' => true,
        ]);

        $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->post('/api/admin/car/');

        $this->assertDatabaseHas('cars', [
            'id' => $carId,
        ]);
    }

    public function test_update_car()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $carId = Car::insertGetId([
            'car_brand_id' => rand(1,10),
            'rate_id' => rand(1,5),
            'is_active' => true,
            'is_free' => true,
        ]);

        $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->put('/api/admin/car/', [
                'id' => $carId,
                'car_brand_id' => rand(1,10),
                'rate_id' => rand(1,5),
                'is_active' => true,
                'is_free' => false,
            ]);

        $car = Car::find($carId);

        $this->assertEquals(false, $car->is_free);
    }

    public function test_destroy_car()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $car = Car::find(1);

        $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->delete('/api/admin/car/1');


        $this->assertDatabaseMissing('cars', [
            'id' => 1,
        ]);
    }

    public function test_index_user()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $response = $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->get('/api/admin/user');

        $response->assertStatus(200);
    }

    public function test_show_user()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $response = $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->get('/api/admin/user/1');

        $response->assertStatus(200);
    }

    public function test_update_user()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $user = User::find(3);

        $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->put('/api/admin/user/', [
                'id' => $user->id,
                'name' => 'test',
                'email' => 'test@test.ru',
            ]);

        $user = User::where('email', 'test@test.ru')->first();

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.ru'
        ]);
    }

    public function test_index_rate()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $response = $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->get('/api/admin/rate');

        $response->assertStatus(200);
    }

    public function test_store_rate()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $rateId = Rate::insertGetId([
            'name' => rand(1,10),
            'cost' => rand(1,5),
        ]);

        $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->post('/api/admin/rate/');

        $this->assertDatabaseHas('rates', [
            'id' => $rateId,
        ]);
    }

    public function test_update_rate()
    {
        $this->artisan('passport:install');

        $admin = User::find(1);

        $rate = Rate::find(1);
        echo($rate->cost);
        $this->actingAs($admin)
            ->withToken($admin->createToken('API Token')->accessToken)
            ->put('/api/admin/rate/', [
                'id' => $rate->id,
                'name' => 'test',
                'cost' => 777,
            ]);

        $rate = Rate::where('id', $rate->id)->first();

        $this->assertEquals(777, $rate->cost);
    }
}
