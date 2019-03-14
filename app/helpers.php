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
