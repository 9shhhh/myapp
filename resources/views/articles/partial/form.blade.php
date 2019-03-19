<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title">제목</label>
    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="form-control"/>
    {!! $errors->first('title', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
    <label for="tags">태그</label>
    <select name="tags[]" id="tags" multiple="multiple" class="form-control" >
        @foreach($allTags as $tag)
            <option value="{{ $tag->id }}" {{ $article->tags->contains($tag->id) ? 'selected="selected"' : '' }}>
                {{ $tag->name }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('tags', '<span class="form-error">:message</span>') !!}
</div>

<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
    <label for="content">본문</label>
    <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $article->content) }}</textarea>
    {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
</div>

{{--<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">--}}
    {{--<label for="files">파일</label>--}}
    {{--<input type="file" name="files[]" id="files" class="form-control" multiple="multiple"/>--}}
    {{--{!! $errors->first('files.0', '<span class="form-error">:message</span>') !!}--}}
{{--</div>--}}

<div class="form-group">
    <label for="my-dropzone">파일</label>
    <div id="my-dropzone" class="dropzone"></div>
</div>
<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" name="notification" value="{{old('notification',1)}}" checked>
            댓글이 작성되면 이메일 알림 받기
        </label>
    </div>
</div>
@section('script')
    @parent
    {{--<script>--}}
        {{--$("#tags").select2({--}}
            {{--placeholder: '태그를선택하세요(최대3개)',--}}
            {{--maximumSelectionLength: 3--}}
        {{--});--}}
    {{--</script>--}}

    <script>
        var form = $('form').first();

        var myDropzone = new Dropzone('div#my-dropzone',{
          url: '/attachments',
          paramName: 'files',
          maxFilesize:3,
          acceptedFiles:'.jpg,.png,.zip,.tar',
          uploadMultiple:true,
          params:{
            _token: $('meta[name="csrf-token"]').attr('content'),
            article_id: '{{$article->id}}'
          },
          dictDefaultMessage: '<div class="text-center text-muted">' +
                  '<h2>첨부할 파일을 끌어다 놓으세요!</h2>'+
                  '<p>(또는 클릭하셔도 됩니다.)</p></div>',
          dictFileTooBig:'파일당 최대 크기는 3MB입니다.',
          dictInvalidFileType:'jpg, png, zip, tar 파일만 가능합니다.'
        });

        // 이벤트 처리 (파일 업로드 후 서버에서 성공 응답을 받았을 때)
        myDropzone.on('complete', function (file, data){
            // 배열을 순회 하며, 숨은 필드를 만들고, 폼 태그에 붙인다.
            for(var i = 0,len=data.length; i<len; i++) {
                $("<input>",{
                    type: "hidden",
                    name: "attachments[]",
                    value: data[i].id
                }).appendTo(form);
            }
        });

    </script>
@stop