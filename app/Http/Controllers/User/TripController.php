<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::where('user_id', Auth::id())
            ->get();

        if (!$trips) {
            return response(['message' => 'Поездки не найдены'], 204);
        }

        return response([ 'trips' => TripResource::collection($trips),
            'message' => 'Поездки найдены'], 200);
    }

    public function show($id)
    {
        $trip = Trip::find($id);

        if (!$trip) {
            return response(['message' => 'Поездка не найдена'], 204);
        }

        return response([ 'trip' => new TripResource($trip), 'message' => 'Поездка найдена'], 200);

    }
}
