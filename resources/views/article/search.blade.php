@extends('master.master')


@section('Title', $Title)


@section('Content')

<div class="col pb-5">

    <h1>{{ $Title }}</h1>

    @if(count($ArticleList) > 0)

        @include('article.article_block')  
        
    @else
    
        <p> '{!! $SearchContent !!}' 查無搜尋結果</p>
    
    @endif
</div>
<script type="text/javascript">
</script>
@endsection