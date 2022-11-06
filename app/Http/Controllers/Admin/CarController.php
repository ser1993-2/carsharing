<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{

    public function index()
    {
        $cars = Car::all();

        if (!$cars) {
            return response(['message' => 'Автомобили не найдены'], 204);
        }

        return response([ 'cars' => CarResource::collection($cars),
            'message' => 'Автомобили найдены'], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'car_brand_id' => 'required|integer',
            'rate_id' => 'required|integer',
            'is_active' => 'required|boolean',
            'is_free' => 'required|boolean',
        ]);


        if($validator->fails()){
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }

        $car = Car::create($data);

        return response([ 'car' => new CarResource($car),
            'message' => 'Success'], 200);
    }

    public function show($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response(['message' => 'Автомобиль не найден'], 204);
        }

        return response([ 'car' => new CarResource($car), 'message' => 'Автомобиль найден'], 200);

    }

    public function update(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'car_brand_id' => 'required|integer',
            'rate_id' => 'required|integer',
            'is_active' => 'required|boolean',
            'is_free' => 'required|boolean',
        ]);


        if($validator->fails()){
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }

        $result = Car::where('id', $data['id'])
            ->update($request->only(
                ['car_brand_id', 'rate_id', 'is_active', 'is_free'])
            );

        return response(['message' => $result], 200);

    }

    public function destroy($id)
    {
        $car = Car::find($id);

        $result = false;

        if ($car) {
            $result = $car->delete();
        }

        return response(['message' => $result], 200);
    }
}
