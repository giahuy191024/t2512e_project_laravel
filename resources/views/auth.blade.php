<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
</head>
<body>
@include('components.header')
@include('components.auth-modal')
@include('sections.about')
@include('sections.doctors')
@include('sections.services')
@include('sections.why-choose')
@include('sections.process')
@include('sections.feedback')
@include('sections.blog')
@include('sections.branches')
@include('components.footer')

<script src="{{asset('js/auth.js')}}" defer></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
