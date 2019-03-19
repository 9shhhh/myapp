<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title','content','notification','view_count'];

    protected $with = ['user'];
    // 유저
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // 태그
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    // 파일 첨부
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
    // 댓글
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    // 댓글 수
    public function getCommentCountAttribute()
    {
        return (int) $this->comments->count();
    }
}
