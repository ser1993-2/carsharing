<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token','email_verified_at','created_at','updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userRole() {
        return $this->hasMany(UserRole::class);
    }

    public function roles() {
        return $this->belongsToMany( Role::class,UserRole::class);
    }

    public static function updateBalance($userId, $totalCost) {
        $user = User::find($userId);

        if ($user) {
            $user->balance = $user->balance - $totalCost;
            $user->save();
        }
    }

    public static function isActiveTrip($userId) {
        $trip = Trip::where('user_id', $userId)
            ->where('finish', null)
            ->first();

        return $trip ? true : false;
    }
}
