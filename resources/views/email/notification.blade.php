<!-- 
<script src="{{ URL::asset('js/jquery/jquery-2.2.4.js') }}" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
-->

<div class="container"> 
    <div class="d-flex flex-column mx-auto border border-danger w-50 mt-5 p-2">
        <p>歡迎註冊 Communtity </p>
        <span>您好: <strong>{{ $nickName }}</strong></span>
        <span>請點選以下URL啟動帳號:  
            <small>
                <a href="{{ $verifyUrl }}">{{ $verifyUrl }}</a>
            </small>
        </span>
    </div>
</div>