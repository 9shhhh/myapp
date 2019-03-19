<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/***********************************************************

 * @params key, minutes, query, method, args

 * @description 캐싱 공통 적용 컨트롤러

 * @method

 * @return Cache

 ***********************************************************/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $cache;

    public function __construct()
    {
        $this->cache = app('cache');

        if((new \ReflectionClass($this))->implementsInterface(Cacheable::class) and taggable()) {
            $this->cache = app('cache')->tags($this->cacheTags());
        }
    }

    // 캐시 적용
    protected function cache($key, $minutes, $query, $method, ...$args)
    {
        $cache = taggable() ? app('cache')->tags('???') : app('cache');
        $args = (! empty($args)) ? implode(',',$args) : null;

        if(config('project.cache') === false) {
            return $query->{$method} ($args);
        }

        return \Cache::remember($key,$minutes, function () use($query,$method,$args){
            dd("캐싱되면 출력");
           return $query->{$method} ($args);
        });
    }
}
