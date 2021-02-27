<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    const IS_BANNED = 1;
    const IS_ACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    /**
     * bun the user
     */
    public function bun()
    {
        // $this->is_banned = true;
        $this->status = self::IS_BANNED;
        $this->save();
    }

    /**
     * unbun the user
     */
    public function unbun()
    {
        // $this->is_banned = false;
        $this->status = self::IS_ACTIVE;
        $this->save();
    }

    public function toggleStatus()
    {
        if ($this->status == self::IS_BANNED) {
            $this->unbun();
        } else {
            $this->bun();
        }
    }

    public function isBanned()
    {

        return ($this->status == self::IS_BANNED) ? true : false;
    }
    /**
     * @param $fields
     * {
     *  name: string,
     *  email: string,
     *  password: string,
     * }
     * @return User
     */
    public static function create($fields)
    {
        $fields['password'] = Hash::make($fields['password']);
        $user = new static;
        $user->fill($fields);
        $user->save();
        return $user;
    }

    /**
     * @param $fields
     * {
     *  name: string,
     *  email: string,
     *  password: string,
     * }
     */
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    /**
     * remove the user
     */
    public function remove()
    {
        $this->delete();
    }
    
}
