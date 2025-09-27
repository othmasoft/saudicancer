<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'جمعية السرطان السعودية')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.rtl.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" crossorigin="anonymous">

    <style>
        /* Font Face Declarations */
        @font-face {
            font-family: 'Almarai';
            src: url('{{ asset("fonts/Almarai/Almarai-Regular.ttf") }}') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Almarai';
            src: url('{{ asset("fonts/Almarai/Almarai-Bold.ttf") }}') format('truetype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Almarai';
            src: url('{{ asset("fonts/Almarai/Almarai-Light.ttf") }}') format('truetype');
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Almarai';
            src: url('{{ asset("fonts/Almarai/Almarai-ExtraBold.ttf") }}') format('truetype');
            font-weight: 800;
            font-style: normal;
            font-display: swap;
        }
        body {
            font-family: "Almarai", "Arial", sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100vw;
            background-color: #fcf5f2;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

    </style>
</head>
<body>

{{-- المحتوى --}}
<main class="container ">
    @yield('content')
</main>

{{-- JavaScript --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>
