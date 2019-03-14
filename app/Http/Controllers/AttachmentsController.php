<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


/***********************************************************

 * @params Request

 * @description 파일 업로드 요청 처리

 * @method POST

 * @return JSON API

 ***********************************************************/

class AttachmentsController extends Controller
{
    public function store(Request $request)
    {
        // 파일 필드 담기
        $attachments = [];

        if($request->hasFile('files')){
            $files = $request->file('files');
            // 넘어온 파일 꺼내기
            foreach ($files as $file) {
                // 파일이름 지정
                $filename = str_random().filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);
                // 메타 데이터로 저장할 값 준비
                $payload = [
                    'filename' => $filename,
                    'bytes' => $file->getClientSize(),
                    'mime' => $file->getClientMimeType()
                ];
                // 파일 이동 경로 지정
                $file->move(attachments_path(), $filename);
                // article_id 입력값으로 로직 분기 (필드가 존재하면 글 수정 폼에서 보낸 것)
                $attachments[] = ($id = $request->input('article_id'))
                    ? \App\Article::findOrFail($id)->attachments()->create($payload)
                    : \App\Attachment::create($payload);
            }
        }
        return response()->json($attachments, 200, [], JSON_PRETTY_PRINT);
    }

}