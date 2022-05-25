<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

        <title>Countries</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
       
    </head>
    <body >
        <div id="app">
            
            @include ('layouts.header')

            <section class="section">
                <div class="container">

                        <router-view to="/"></router-view>

                </div>
            </section>

        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
