<?php

namespace App\Http\Controllers;

/***********************************************************

 * @params

 * @description 캐시태그 인터페이스

 * @method

 * @return

 ***********************************************************/

interface  Cacheable
{
    public function cacheTags();
}