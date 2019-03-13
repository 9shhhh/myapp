<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirm_code', 'activated',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirm_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime', 'activated' => 'boolean',
    ];

    protected $dates = ['last_login'];


    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function scopeSocialUser($query, $email)
    {
        return $query->whereEmail($email)->whererNull("password");
    }

    public function isAdmin()
    {
        return ($this->id === 1) ? true : false;
    }
}
