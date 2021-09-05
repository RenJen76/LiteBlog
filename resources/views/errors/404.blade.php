<!-- <!DOCTYPE html>
<html>
    <head>
        <title>Community</title>

        
    </head>
    <body>
        
    </body>
</html> -->
@extends('master.master')

@section('Title', '404 Page')

@section('Content')
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>

        .error-container {
            color: #B0BEC5;
            text-align: center;
            vertical-align: middle;
            font-weight: 100;
            font-family: 'Lato', sans-serif;
        }

        .error-content {
            text-align: center;
        }

        .error-title {
            font-size: 72px;
            margin-bottom: 40px;
        }
    </style>

    <div class="error-container">
        <div class="error-content">
            <div class="error-title">404</div>
            <div class="error-title">找不到頁面</div>
            <div>
                <a href='#' onclick='javascript:history.back()'>點我回上一頁</a>
            </div>
        </div>
    </div>
@endsection