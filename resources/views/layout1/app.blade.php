<!DOCTYPE html>
<html lang="en">
@include('layout1.assets_head')
@yield('_style')
<body>
@include('menu1.horizantal')
<div class="content">
    @yield('content')
</div>
@include('layout1.assets_script')
@yield('_script')
</body>
</html>
