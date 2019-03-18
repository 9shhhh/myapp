<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/***********************************************************

 * @params value

 * @description 투표하기

 * @method
 *
 * @return

 ***********************************************************/

class Vote extends Model
{
    // 시간 찍기 비활성
    public $timestamps = false;
    // 화이트 리스트
    protected $fillable = ['user_id','comment_id','up','down','voted_at'];
    // 의미론적인(?) 열 추가
    protected $dates = ['voted_at'];
    // 다대일 관계
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
    // 다대일 관계
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // 저장할 속성값 지정(up투표)
    public function setUpAttribute($value)
    {
        $this->attributes['up'] = $value ? 1 : null;
    }
    // 저장할 속성값 지정(down투표)
    public function setDownAttribute($value)
    {
        $this->attributes['down'] = $value ? 1 : null;
    }

}
