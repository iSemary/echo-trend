<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="description"
        content="Full-stack web application built with PHP Laravel on the backend and React on the frontend. It provides a personalized news feeds, and engaging features." />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#ff184e">
    <link rel="stylesheet" href="{{ asset('static/css/style.min.css') }}?v={{ filemtime('static/css/style.min.css') }}">
</head>

<body>
    <div id="root"></div>
    {{-- React Bundle File --}}
    <script src="{{ asset('static/js/app.min.js') }}?v={{ filemtime('static/js/app.min.js') }}" async></script>
</body>

</html>
