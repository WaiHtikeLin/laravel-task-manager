<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style>

        .task-row:hover {
          background: #eee;
        }

        </style>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
      <nav>
        <a href="/">Home</a>

        <a href="/projects">Projects</a>
      </nav>
      <br><br>
        <div>
          @yield('content')
        </div>
    </body>
</html>
