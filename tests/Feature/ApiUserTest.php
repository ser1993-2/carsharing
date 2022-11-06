<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiUserTest extends TestCase
{

    public function test_index_cars()
    {
        $this->artisan('passport:install');

        $user = User::find(2);

        $response = $this->actingAs($user)
            ->withToken($user->createToken('API Token')->accessToken)
            ->get('/api/user/car');

        $response->assertStatus(200);
    }

    public function test_show_car()
    {
        $this->artisan('passport:install');

        $user = User::find(2);

        $response = $this->actingAs($user)
            ->withToken($user->createToken('API Token')->accessToken)
            ->get('/api/user/car/1');

        $response->assertStatus(200);
    }

    public function test_start_and_finish()
    {
        $this->artisan('passport:install');

        $freeCar = Car::where('is_free', true)->first();

        $user = User::find(2);

        $response = $this->actingAs($user)
            ->withToken($user->createToken('API Token')->accessToken)
            ->post('/api/user/car/' . $freeCar->id . '/start');

        $currentCar = Car::where('id', $freeCar->id)->first();

        $response->assertStatus(200);
        $this->assertEquals(false, $currentCar->is_free);

        $response = $this->actingAs($user)
            ->withToken($user->createToken('API Token')->accessToken)
            ->post('/api/user/car/' . $freeCar->id . '/finish');

        $currentCar = Car::where('id', $freeCar->id)->first();

        $response->assertStatus(200);
        $this->assertEquals(true, $currentCar->is_free);
    }

    public function test_index_trip()
    {
        $this->artisan('passport:install');

        $user = User::find(2);

        $response = $this->actingAs($user)
            ->withToken($user->createToken('API Token')->accessToken)
            ->get('/api/user/trip');

        $response->assertStatus(200);
    }

    public function test_show_trip()
    {
        $this->artisan('passport:install');

        $user = User::find(2);

        $response = $this->actingAs($user)
            ->withToken($user->createToken('API Token')->accessToken)
            ->get('/api/user/trip/1');

        $response->assertStatus(200);
    }
}
