<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/***********************************************************

 * @params

 * @description 댓글 유효성 검사

 * @method

 * @return

 ***********************************************************/

class CommentRequest extends FormRequest
{

    // 유효성 체크 사용 여부
    public function authorize()
    {

        return true;
    }

    // 유효성 규칙
    public function rules()
    {

        return [
            'content' => ['required','min:10'],
            'parent_id' => ['numeric','exists:comments,id']
        ];
    }
}
