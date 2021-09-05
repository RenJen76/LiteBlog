@extends('master.master')


@section('Title', $Title)


@section('Content')
<!-- <div class="container"> -->
    <!-- <div class="row"> -->
        <h1>登入</h1>
        <div class="col-6">    
            <form id="form1" class="form-group" method="post" action="login-process">
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
                    <!-- 錯誤訊息模板元件 -->
                    @include('normal.ValidatorError')
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-warning" onclick="javascript:location.href='sign'">註冊</button>
                    <button type="submit" class="btn btn-primary">登入</button>
                </div>
            </form>
        </div>
    <!-- </div> -->
<!-- </div> -->
@endsection