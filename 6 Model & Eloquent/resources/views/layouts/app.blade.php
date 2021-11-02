<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $user->name ?? 'Tutor' }}</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans|Lato:100,300,400,600,700" rel="stylesheet">

    {{-- Style --}}
    <style>
        body {
            font-family: 'Fira Sans';
            padding: 0px;
            margin: 0px;
        }

    </style>
</head>

<body>
    {{-- Include header --}}
    @include('layouts.header')

    <!-- NOTE: check alert (Kalau mengganggu bisa dimatikan) -->
    @if (session('alert'))
        <script>
            alert("{{ session('alert') }}");
        </script>
    @endif

    {{-- alert all errors --}}
    @if ($errors->any())
        <script>
            alert("{{ collect($errors->all())->implode('\n') }}");
        </script>
    @endif

    {{-- Content --}}
    <div id="content" style="padding: 12px;">
        @yield('content')
    </div>

    {{-- Include footer --}}
    @include('layouts.footer')
</body>

</html>
