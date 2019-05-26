<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User Crud</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <div class="container">
                <router-link to="/">Home</router-link>

                <router-view></router-view>
            </div>
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
