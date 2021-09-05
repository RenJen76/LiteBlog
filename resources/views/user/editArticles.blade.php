@extends('master.master')


@section('Title', $Title)


@section('Content')

<div class="container">
    <h1>修改文章</h1>
    <form id="form1" class="form-group" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="account">文章標題</label>
            <input name="contentTitle" class="form-control" type="text" value="{{ $ArticleData['ArticleTitle'] }}" placeholder="請輸入標題"/>
        </div>
        <div class="mb-3">
            <label for="account">文章內容</label>
            <textarea name="content" class="form-control" type="text" placeholder="請輸入內容"/>{{ $ArticleData['ArticleContent'] }}</textarea>
        </div>
        <div class="mb-3">
            <!-- 錯誤訊息模板元件 -->
            @include('normal.ValidatorError')
        </div>
        <div class="mb-3">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn-warning">修改</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    let processResult = "{{ session('ProcessResult') ?: '' }}";
    if(processResult=='success'){
        $.iaoAlert({
            msg: "修改成功！",
            type: "success",
            mode: "dark"
        });
    }
</script>
@endsection