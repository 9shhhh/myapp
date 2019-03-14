<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/***********************************************************

 * @params Request

 * @description 파일 업로드 모델

 * @method

 * @return

 ***********************************************************/

class Attachment extends Model
{
    protected $fillable = ['filename','bytes','mime'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // 파일 사이즈 반환
    public function getBytesAttribute($value)
    {
        return format_filesize($value);
    }

    // 뷰에서 링크를 편리하게 하기위한 함수
    public function getUrlAttribute()
    {
        return url('files/'.$this->filename);
    }
}
