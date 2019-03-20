<?php

// 도우미 함수 만들기

if (! function_exists('markdown')) {
    function markdown($text = null) {
        return app(ParsedownExtra::class)->text($text);
    }
}

function gravatar_url($email, $size= 48)
{
    return sprintf("//www.gravatar.com/avatar/%s?s=%s",md5($email),$size);
}

function gravatar_profile_url($email)
{
    return sprintf("//www.gravatar.com/%s",md5($email));
}

// 파일 경로 반환
function attachments_path($path='')
{
    return public_path('files'.($path ? DIRECTORY_SEPARATOR.$path : $path));
}

// 사용자가 읽기 편한 파일 크기 문자열로 반환
function format_filesize($bytes)
{
    // 전달 받은 값이 숫자가 아니면 'NaN' 반환
    if (! is_numeric($bytes)) return 'NaN';
    // 인자로 받은 값을 나눌 값
    $decr = 1024;
    // 반복 수행 값
    $step = 0;
    // 파일 형식 배열
    $suffix = ['bytes','KB','MB'];

    // 0.9 보다 작을 때 까지 나누기
    while (($bytes / $decr) > 0.9){
        // 나눈 값 저장
        $bytes = $bytes / $decr;
        // 반복 카운트
        $step++;
    }

    return round($bytes, 2) . $suffix[$step];
}

//정렬 조건에 맞는 페이지로 이동
function link_for_sort($column, $text, $params = [])
{
    $direction = request()->input('order');
    $reverse = ($direction == 'asc') ? 'desc' : 'asc';

    if (request()->input('sort') == $column){
        $text = sprintf("%s %s", $direction == 'asc'
            ? '<i class="fa fa-sort-alpha-asc"></i>'
            : '<i class="fa fa-sort-alpha-desc"></i>',$text);
    }

    $queryString = http_build_query(array_merge(
       request()->except(['sort','order']),
       ['sort'=>$column, 'order'=>$reverse],$params
    ));

    return sprintf('<a href="%s?%s">%s</a>',urldecode(request()->url()),
        $queryString,$text);
}
//캐시키 발급
function cache_key($base)
{
    $key = ($uri=request()->getQueryString()) ? $base. '.' .urlencode($uri) : $base;

    return md5($key);
}
// 캐시 태그
function taggable()
{
    return in_array(config('cache.default'),['memcached','redis'],true);
}
// 쿼리스트링 재 생산
function current_url()
{
    if(! request()->has('return')){
        return request()->fullUrl();
    }

    return sprintf(
      '%s?%s',
      request()->url(),
      http_build_query(request()->except('return'))
    );
}
//테이블 열과줄 교체
function array_transpose(array $data)
{
    $res = [];

    foreach ($data as $row => $columns){
        foreach ($columns as $row2 => $column2){
            $res[$row2][$row] = $column2;
        }
    }

    return $res;
}

//JWT도우미 함수
function jwt()
{
    return app('tymon.jwt.auth');
}

function is_api_domain()
{
    return starts_with(request()->getHttpHost(), config('project.api_domain'));
}