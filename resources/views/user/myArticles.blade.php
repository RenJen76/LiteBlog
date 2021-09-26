@extends('master.master')


@section('Title', '我的文章列表')


@section('Content')

<div class="col pb-5">
    <h1>{{ $Title }}</h1>
    
    <input type="button" class="btn btn-primary" value="建立文章" onclick="javascript:location.href = '/user/create-articles'">
    
    @include('article.article_block')

</div>
<script type="text/javascript">
</script>
<?php  
    Log::debug(DB::getQueryLog());
?>
@endsection