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

        /* Color Variables */
        :root {
            --color-primary: #2a6571;
            --color-secondary: #dcdde6;
            --color-accent: #866eaf;
            --color-light: #6a99cb;
        }

        /* Full height flex layout */
        html, body {
            min-height: 100vh;
            font-family: "Almarai", "Arial", sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* Header Styling */
        header {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
            flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        header a {
            color: #fff !important;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        header a:hover {
            color: rgba(255, 255, 255, 0.8) !important;
            transform: translateY(-1px);
        }

        .logo {
            height: 50px;
            width: auto;
            object-fit: contain;
            transition: transform 0.2s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .brand-title {
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Navigation Styling */
        .main-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .nav-link {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            text-decoration: none !important;
            color: white !important;
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .nav-link i {
            font-size: 0.9rem;
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Footer Styling */
        footer {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
            border-top: 3px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .footer-logo {
            height: 30px;
            width: auto;
            object-fit: contain;
        }

        footer p {
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .main-nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                z-index: 1000;
            }

            .main-nav.show {
                display: flex;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .nav-link {
                width: 100%;
                justify-content: center;
                text-align: center;
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 768px) {
            .logo {
                height: 35px;
            }

            .brand-title {
                font-size: 1.25rem;
            }

            header .container {
                flex-wrap: wrap;
            }

            .header-brand {
                width: 100%;
                justify-content: center;
                margin-bottom: 0.5rem;
            }

            .mobile-menu-toggle {
                position: absolute;
                top: 1rem;
                left: 1rem;
            }
        }

        @media (max-width: 576px) {
            .brand-title {
                font-size: 1.1rem;
            }

            .nav-link {
                font-size: 0.9rem;
                padding: 0.6rem 0.8rem;
            }
        }

        /* Loading animation for logo */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            animation: fadeIn 0.5s ease-out;
        }

        /* Header container positioning */
        .header-container {
            position: relative;
        }
    </style>
</head>
<body>



{{-- المحتوى --}}
<main class="container mt-4">
    @yield('content')
</main>


{{-- JavaScript --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>
