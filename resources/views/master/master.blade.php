<!DOCTYPE html>
<html>
<head>
    
    <title>LiteBlog - @yield('Title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="Shortcut Icon" type="image/x-icon" href="{{ URL::asset('favicon.ico') }}">
    <script src="{{ URL::asset('js/jquery/jquery-2.2.4.js') }}"></script>

    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous"> -->

    <!-- Optional theme -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous"> -->

    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script> -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- iao-alert.js -->
    <script type="text/javascript" src="{{ URL::asset('js/iao-alert-master/iao-alert.jquery.js') }}"></script>
    <!-- iao-alert.css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('js/iao-alert-master/iao-alert.css') }}">
    <!-- main.css -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">

    <script type="text/javascript">
        $(document).ready(function(){

            $("form[name='searchForm']").submit(function(){

                let searchContent = document.forms['searchForm'].elements.searchContent.value.trim();

                if(searchContent==''){
                    alert("請先輸入搜尋內容");
                    $("#searchContent").focus();
                    return false;
                }

                location.href = '/search/' + searchContent;
                return false;
            })
        })
    </script>

</head>
<body class="vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-gradient">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index">Community</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form name='searchForm' class="d-flex flex-fill">
                <input class="form-control me-2" id='searchContent' type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
            <ul class="navbar-nav mb-2 mb-lg-0 ms-2">

                @if(session()->has('UserID') === true)

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        我的資訊
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href='/user/{{ Auth::id() }}'>
                                Hi {{ Auth::user()['nickname'] }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/user/create-articles">建立文章</a></li>
                        <li><a class="dropdown-item" href="/user/editUser">修改個人資訊</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form id="logoutForm" action="/auth/logout" method="POST">
                                <a class="dropdown-item" href="#" onclick="document.getElementById('logoutForm').submit()">登出</a>
                                {!! csrf_field() !!}
                            </form>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    @if($_SERVER['REQUEST_URI']=="/user/my-articles")
                       
                        <a class="nav-link active" aria-current="page" href="/user/my-articles">我的文章列表</a>
                    
                    @else

                        <a class="nav-link" aria-current="page" href="/user/my-articles">我的文章列表</a>
                   
                    @endif
                </li>

                @else

                <li class="nav-item">

                    <a class="nav-link active" aria-current="page" href="/auth/login">登入</a>

                </li>

                @endif

                
                <!-- 
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
                 -->
            </ul>
            </div>
        </div>
    </nav>

    <!-- <div class="container pt-5 pb-5 h-100"> -->
    <div class="container pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-sm-8">

                @yield('Content')
                
            </div>
        </div>
    </div>

    <nav class="navbar fixed-bottom navbar-expand-lg navbar-light bg-light bg-gradient mt-5">
        <div class="container-fluid justify-content-center">
            <div class="text-dark">Community</div>
        </div>
    </nav>
    

</body>
</html>