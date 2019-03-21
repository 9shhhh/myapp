<?php
namespace App;

use \Illuminate\Database\Eloquent\Model;

/***********************************************************

 * @params Model model, cachekey

 * @description EtagTrait

 * @method

 * @return md5

 ***********************************************************/

trait EtagTrait
{
    // 모델 인스턴스 Etag 값 만들기
    public function etag(Model $model, $cacheKey = null)
    {
        $etag ='';

        if ($model->usesTimestamps()){
            $etag .=$model->updated_at->timestamp;
        }

        return md5($etag.$cacheKey);
    }
    // 컬렉션 Etag 값 만들기
    protected function etags($collection, $cacheKey= null)
    {
        $etag = '';

        foreach ($collection as $instance){
            $etag .=$this->etag($instance);
        }

        return md5($etag.$cacheKey);
    }
}