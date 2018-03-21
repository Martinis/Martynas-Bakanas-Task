<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="copyright" content="Martynas Bakanas" />  
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BitDegree Task</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ns-default.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ns-style-bar.css') }}" rel="stylesheet">
</head>
<body>
    <page id="app"></page>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('js/classie.js') }}"></script>
    <script src="{{ asset('js/notificationFx.js') }}"></script>
</body>
</html>
