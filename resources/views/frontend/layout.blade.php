<!DOCTYPE html>
<html>

<head>
    @include('frontend.component.head')
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>
    @include('frontend.component.header')
    {{-- <section class="section"> --}}
    @yield('clientContent')
    {{-- </section> --}}
    @include('frontend.component.footer')
    </div>

    @include('frontend.component.script')
</body>

</html>
