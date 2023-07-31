<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Invoice Manager</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />


</head>
<body>
    <div class="container">
        <h1>Deposit Management System</h1>
        <hr>
        @yield('content')
    </div>

    <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>

</body>
</html>
