<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['car_id','user_id','start'];
    protected $casts = ['start' => 'datetime' , 'finish' => 'datetime'];
    protected $hidden = ['user_id', 'car_id', 'total_cost', 'created_at', 'updated_at'];
    protected $appends = ['car_name'];

    public function car() {
        return $this->belongsTo(Car::class);
    }

    public function getCarNameAttribute() {
        return $this->car->carBrand->brand . ' ' . $this->car->carBrand->model;
    }

    public static function start($carId, $userId) {
        Trip::create([
            'car_id' => $carId,
            'user_id' => $userId,
            'start' => now(),
        ]);
    }

    public static function finish($carId, $userId) {
        $trip = Trip::where('user_id', $userId)
            ->where('car_id', $carId)
            ->where('finish', null)
            ->first();

        $trip->finish = now();

        $car = Car::find($carId);
        $rateCost = $car->rate->cost;

        $totalMinutes = $trip->finish->diffInMinutes($trip->start);
        $calculateTotalCost = $totalMinutes * $rateCost;


        $trip->total_cost = $calculateTotalCost;
        $trip->save();

        User::updateBalance($userId,$calculateTotalCost);
    }

}
