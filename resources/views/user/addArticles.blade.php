@extends('master.master')


@section('Title', $Title)


@section('Content')

<!-- <script src="{{ URL::asset('js/ckeditor5/classic/ckeditor.js') }}"></script> -->
<div class="col">
    <h1>建立文章</h1>
    <form id="form1" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="account">文章標題</label>
            <input name="contentTitle" class="form-control" type="text" value="{{old('contentTitle')}}" placeholder="請輸入標題"/>
        </div>
        <div class="mb-3">
            <label for="account">文章內容</label>
            <textarea id="content" name="content" class="form-control" type="text" placeholder="請輸入內容"/>{{ old('content') }}</textarea>
        </div>
        <div class="mb-3">
            <!-- 錯誤訊息模板元件 -->
            @include('normal.ValidatorError')
        </div>
        <div class="mb-3">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn-primary">建立</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    let processResult = "{{ session('ProcessResult') ?: '' }}";
    if(processResult=='success'){
        $.iaoAlert({
            msg: "建立成功！",
            type: "success",
            mode: "dark"
        });
    }
    // ClassicEditor
    //     .create( document.querySelector( '#content' ) )
    //     .catch( error => {
    //         console.error( error );
    //     } );
</script>
@endsection