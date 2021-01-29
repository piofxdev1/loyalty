<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Piofx</title>

        @include('components.themes.loyalty.blocks.styles')

    </head>
    <body class="bg-light">

        @include('components.themes.loyalty.blocks.header')

        <div class="container">
            {{ $slot }}
        </div>

        @include('components.themes.loyalty.blocks.footer')
        @include('components.themes.loyalty.blocks.scripts')

    </body>
</html>
