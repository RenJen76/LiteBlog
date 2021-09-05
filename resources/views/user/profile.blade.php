@extends('master.master')


@section('Title', $Title)


@section('Content')

<script type="text/javascript">
    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e) {
               $("#imagePreview").attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(function(){
        $("#uploadImageBtn").click(function(){
            $("#uploadImage").click();
        })
        $("#uploadImage").change(function(){
            readURL(this);
        });
    })
</script>

<div class="container mb-5">
    <h1>個人資訊</h1>
        
        @include('user.user_info')
        
    <div class="col">

        @include('article.article_block')

    </div>
</div>
@endsection