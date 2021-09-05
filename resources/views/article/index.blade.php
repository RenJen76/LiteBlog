@extends('master.master')


@section('Title', $Title)


@section('Content')

<div class="col pb-5">

    <h1>{{ $Title }}</h1>

    @include('article.article_block')  

</div>
<script type="text/javascript">
</script>
@endsection