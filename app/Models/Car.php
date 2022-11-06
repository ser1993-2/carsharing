<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['rate_id', 'car_brand_id','is_active','is_free'];
    protected $hidden = ['rate_id', 'car_brand_id', 'created_at', 'updated_at','is_active','is_free'];
    protected $appends = ['brand', 'model', 'rate_name','cost', 'free'];

    public function carBrand() {
        return $this->hasOne(CarBrand::class,'id', 'car_brand_id');
    }

    public function rate() {
        return $this->hasOne(Rate::class, 'id', 'rate_id');
    }

    public function getBrandAttribute() {
        return $this->carBrand->brand;
    }

    public function getModelAttribute() {
        return $this->carBrand->model;
    }

    public function getRateNameAttribute() {
        return $this->rate->name;
    }

    public function getCostAttribute() {
        return $this->rate->cost;
    }

    public function getFreeAttribute() {
        return $this->is_free ? 'Свободен' : 'Занят';
    }

    public static function changeIsFree($car,$isFree) {
        $car->is_free = $isFree;
        $car->save();
    }
}
