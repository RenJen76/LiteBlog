@extends('master.master')


@section('Title', '修改個人資訊')


@section('Content')

<script type="text/javascript">
    let editSuccess = "{{ old('editSuccess') ?: '' }}";
    if(editSuccess==='success'){
        $.iaoAlert({
            msg: "修改成功！",
            type: "success",
            mode: "dark"
        });
    }
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

<h1>修改個人資訊</h1>
<div class="row pb-5 bg-light">
    <form id="form1" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="d-flex justify-content-center pb-2 pt-3" for="userPictrue">
                <strong>個人圖片</strong>
            </label>
            <div class="d-flex justify-content-center">
            @if($UserData->user_picture=="")
                <img id="imagePreview" class="image-circle" src="/images/icon/default.png">
            @else
                <img id="imagePreview" class="image-circle" src="{{ $UserData->user_picture }}">
            @endif
            </div>
            <div class="d-flex justify-content-center">
                <input type="file" id="uploadImage" name="uploadImage" accept=".png,.jpg" style="display: none;">
                <input type="button" id="uploadImageBtn" class="btn btn-sm btn-danger mt-2" value="選擇圖片">
            </div>
            <!-- <input name="userPictrue" class="form-control" type="text" value="{{ $UserData->user_picture }}" placeholder="請輸入使用者名稱"/> -->
        </div>
        <div class="mb-3">
            <label for="account">姓名</label>
            <input name="username" class="form-control" type="text" value="{{ $UserData->nickname }}" placeholder="請輸入使用者名稱"/>
        </div>
        <div class="mb-3">
            <label for="account">E-Mail</label>
            <input name="email" class="form-control" type="text" value="{{ $UserData->email }}" placeholder="請輸入E-Mail"/>
        </div>
        <div class="mb-3">
            <!-- 錯誤訊息模板元件 -->
            @include('normal.ValidatorError')
        </div>
        <div class="mb-3">
            {!! csrf_field() !!}
            <div class="col">
                <button type="submit" class="btn btn-primary form-control">修改</button>
            </div>
        </div>
    </form>
</div>
@endsection