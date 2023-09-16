<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('Title')</title>

    @include('include.master_style')
    @yield('Style')
</head>

<body class="hold-transition sidebar-mini">
    @include('sweetalert::alert')
    <div class="wrapper">
        @include('include.master_navbar')
        @include('include.master_sidebar')

        <div class="content-wrapper" style="padding-top: 15px">
            @yield('Content')
        </div>

        @include('include.master_footer')
    </div>

    @include('include.master_script')
    @yield('Script')
</body>

</html>
