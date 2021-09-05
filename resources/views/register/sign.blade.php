@extends('master.master')


@section('Title', $Title)


@section('Content')
<div class="col-6">
    <h1>註冊</h1>
    <form id="form1" class="form-group" method="post" action="register">
        <div class="mb-3">
            <label for="account">帳號</label>
            <input name="account" type="text" class="form-control" value="{{old('account')}}" placeholder="請輸入帳號"/>
        </div>
        <div class="mb-3">
            <label for="account">密碼</label>
            <input name="password" class="form-control" type="password" value="{{old('password')}}" placeholder="請輸入密碼"/>
            {!! csrf_field() !!}
        </div>
        <div class="mb-3">
            <label for="nickname">姓名</label>
            <input name="nickname" type="text" class="form-control" value="{{old('nickname')}}" placeholder="請輸入姓名"/>
        </div>
        <div class="mb-3">
            <label for="nickname">E-Mail</label>
            <input name="email" type="text" class="form-control" value="{{old('email')}}" placeholder="請輸入EMail"/>
        </div>
        <div class="mb-3">
            <!-- 錯誤訊息模板元件 -->
            @include('normal.ValidatorError')
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">註冊</button>
        </div>
    </form>
</div>
@endsection