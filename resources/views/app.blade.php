<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Thesis</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.ts')
        @inertiaHead
        @routes
    </head>
    <body>
        @inertia
    </body>
</html>
