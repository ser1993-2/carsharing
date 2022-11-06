<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::where('is_active', true)
            ->get();

        if (!$cars) {
            return response(['message' => 'Автомобили не найдены'], 204);
        }

        return response([ 'cars' => CarResource::collection($cars),
            'message' => 'Автомобили найдены'], 200);
    }

    public function show($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response(['message' => 'Автомобиль не найден'], 204);
        }

        return response([ 'car' => new CarResource($car), 'message' => 'Автомобиль найден'], 200);

    }

    public function start($id)
    {

        $isActiveTrip = User::isActiveTrip(Auth::id());

        if ($isActiveTrip) {
            return response(['message' => 'Есть незавершенная поездка'], 200);
        }

        $car = Car::find($id);

        if (!$car) {
            return response(['message' => 'Автомобиль не найден'], 204);
        }

        if (!$car->is_free) {
            return response(['message' => 'Автомобиль занят'], 200);
        }

        Car::changeIsFree($car,false);
        Trip::start($car->id, Auth::id());

        return response(['message' => 'Поездка начата'], 200);
    }

    public function finish($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response(['message' => 'Автомобиль не найден'], 204);
        }

        if ($car->is_free) {
            return response(['message' => 'Автомобиль свободен'], 200);
        }

        Car::changeIsFree($car,true);
        Trip::finish($car->id, Auth::id());

        return response(['message' => 'Поездка закончена'], 200);
    }
}
