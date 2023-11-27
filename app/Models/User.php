<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'phone_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function getAllUsers() {
    //     return $this->get();
    // }
    public static function getAllUsers(): Builder
    {
        return static::query();
    }
    public function getUsers() {
        return $this->get();
    }

    public function searchUser($searchInput) {
        return $this->where('last_name', 'like', '%' .$searchInput. '%')
            ->orWhere('first_name', 'like', '%' .$searchInput. '%')
            ->orWhere('address', 'like', '%' .$searchInput. '%')
            ->orWhere('email', 'like', '%' .$searchInput. '%')
            ->get();
    }

    public function getUserByRole($role_id): Builder {
        return $this->select('*')
            ->where('role_as', $role_id);
    }
}
