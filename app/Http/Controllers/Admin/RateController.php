<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RateResource;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RateController extends Controller
{
    public function index()
    {
        $rates = Rate::all();

        if (!$rates) {
            return response(['message' => 'Тарифы не найдены'], 204);
        }

        return response([ 'rates' => RateResource::collection($rates),
            'message' => 'Тарифы найдены'], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'cost' => 'required|integer',
        ]);


        if($validator->fails()){
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }

        $rate = Rate::create($data);

        return response([ 'car' => new RateResource($rate),
            'message' => 'Тариф добавлен'], 200);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'name' => 'required|string',
            'cost' => 'required|integer',
        ]);


        if($validator->fails()){
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }

        $result = Rate::where('id', $data['id'])
            ->update($request->only(
                ['name', 'cost'])
            );

        return response(['message' => $result], 200);

    }
}
