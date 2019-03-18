<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'confirm_code', 'activated',];

    protected $hidden = [
        'password', 'remember_token', 'confirm_code',];

    protected $casts = [
        'email_verified_at' => 'datetime', 'activated' => 'boolean',];

    protected $dates = ['last_login'];
    // 게시글
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    // 소셜 유저
    public function scopeSocialUser(\Illuminate\Database\Eloquent\Builder $query, $email)
    {
        return $query->whereEmail($email)->whererNull("password")->whereActivated(1);
    }
    // 관리자 접근
    public function isAdmin()
    {
        return ($this->id === 1) ? true : false;
    }
    // 댓글
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // 투표
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
