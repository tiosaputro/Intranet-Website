@extends('errors::minimal')
<html>
    <head>
        <title>Error</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">

        <style>
            body {
                background-color: #fff;
                font-family: 'Raleway', sans-serif;
                margin: 0;
            }
            .container{
                text-align: center;
            }
            a {
                color : rgb(55, 55, 214) !important;
            }
        </style>
    </head>
    <title>Error Page</title>
    <body>
        <div class="container">
                @section('code', '403')
                @section('message', __('Forbidden Access Page'))
                <img src="{{ asset('app-assets/images/logo/logo.png') }}" style="max-width:136px; max-height: 40px;margin-top:10px;" />
                <a href="{{ url('/') }}" class="btn btn-sm btn-primary"><h4>Go to Home Page</h4></a>
        </div>
    </body>
</html>
