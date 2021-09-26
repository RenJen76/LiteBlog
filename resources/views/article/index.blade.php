@extends('master.master')


@section('Title', '所有文章')


@section('Content')

<div class="col pb-5">

    <h1>{{ $Title }}</h1>

    @include('article.article_block')  

</div>
<script type="text/javascript">
</script>
@endsection