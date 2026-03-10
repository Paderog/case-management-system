<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <title>@yield('title', 'Cases CRUD')</title> -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>
            @hasSection('title')
                @yield('title') | Cases CRUD
            @else
                Cases CRUD
            @endif
        </title>
       @vite(['resources/js/app.js'])
    </head>
        <body class="bg-dark">
            <div id="app">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>  
            
            @yield('script')
        </body>
</html>