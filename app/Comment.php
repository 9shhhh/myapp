<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['commentable_type','commentable_id','user_id','parent_id','content',];

    protected $with = ['user','votes',];

    protected $appends = ['up_count','down_count',];

    // User 조회
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // 다형적 관계 연결
    public function commentable()
    {
        return $this->morphTo();
    }
    // 댓글의 일대다 관계 표현
    public function replies()
    {
        return $this->hasMany(Comment::class,'parent_id');
    }
    // 부모의 댓글 인스턴스를 조회
    public function parent()
    {
        return $this->belongsTo(Comment::class,'parent_id',id);
    }
    // 투표
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
    // 해당 글의 up 투표 건수
    public function getUpCountAttribute()
    {
        return (int) $this->votes()->sum('up');
    }
    // 해당 글의 down 투표 건수
    public function getDownCountAttribute()
    {
        return (int) $this->votes()->sum('down');
    }
}
