<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">--}}
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

    {{--<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.5.0/css/all.css"--}}
          {{--integrity="sha384-j8y0ITrvFafF4EkV1mPW0BKm6dp3c+J9Fky22Man50Ofxo2wNe5pT1oZejDH9/Dt" crossorigin="anonymous">--}}

    <script defer src="https://pro.fontawesome.com/releases/v5.7.2/js/all.js" integrity="sha384-I3Hhe9TkmlsxzooTtbRzdeLbmkFQE9DVzX/19uTZfHk1zn/uWUyk+a+GyrHyseSq" crossorigin="anonymous"></script>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">

    <title>Park Right</title>
    
</head>
<body class="bg-grey-lighter antialiased text-grey-darkest relative">
<div class="h-2 bg-primary"></div>
<div id="app" class="min-h-screen flex flex-col">
    <app></app>
</div>

<script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>
