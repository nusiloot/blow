<!DOCTYPE html>
<html lang="fr">
 <head>
    @include('layouts.head')
    @include('components.calendar')
 </head>
 <body>
    @include('layouts.header')
      @yield('content')
    @include('layouts.footer')
    @include('layouts.footer-scripts')
 </body>
</html>