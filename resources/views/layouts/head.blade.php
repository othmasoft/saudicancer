<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>@yield('title', 'جمعية السرطان السعودية')</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.rtl.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" crossorigin="anonymous">
<style>
    /* Font Face Declarations with multiple format support */
    @font-face {
        font-family: 'Almarai';
        src: url('{{ asset("fonts/Almarai/Almarai-Regular.woff2") }}') format('woff2'),
        url('{{ asset("fonts/Almarai/Almarai-Regular.woff") }}') format('woff'),
        url('{{ asset("fonts/Almarai/Almarai-Regular.ttf") }}') format('truetype');
        font-weight: 400;
        font-style: normal;
        font-display: swap;
    }

    @font-face {
        font-family: 'Almarai';
        src: url('{{ asset("fonts/Almarai/Almarai-Bold.woff2") }}') format('woff2'),
        url('{{ asset("fonts/Almarai/Almarai-Bold.woff") }}') format('woff'),
        url('{{ asset("fonts/Almarai/Almarai-Bold.ttf") }}') format('truetype');
        font-weight: 700;
        font-style: normal;
        font-display: swap;
    }

    @font-face {
        font-family: 'Almarai';
        src: url('{{ asset("fonts/Almarai/Almarai-Light.woff2") }}') format('woff2'),
        url('{{ asset("fonts/Almarai/Almarai-Light.woff") }}') format('woff'),
        url('{{ asset("fonts/Almarai/Almarai-Light.ttf") }}') format('truetype');
        font-weight: 300;
        font-style: normal;
        font-display: swap;
    }

    @font-face {
        font-family: 'Almarai';
        src: url('{{ asset("fonts/Almarai/Almarai-ExtraBold.woff2") }}') format('woff2'),
        url('{{ asset("fonts/Almarai/Almarai-ExtraBold.woff") }}') format('woff'),
        url('{{ asset("fonts/Almarai/Almarai-ExtraBold.ttf") }}') format('truetype');
        font-weight: 800;
        font-style: normal;
        font-display: swap;
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

    header, footer {
        background: linear-gradient(135deg, #2a6571 0%, #866eaf 100%);
        flex-shrink: 0;
    }

    header a, footer a {
        color: #fff !important;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    header a:hover, footer a:hover {
        text-decoration: underline;
        opacity: 0.8;
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

    /* Enhanced footer logo */
    .footer-logo {
        height: 30px;
        width: auto;
        object-fit: contain;
    }

    /* Navigation enhancements */
    header nav a {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        margin: 0 0.25rem;
    }

    header nav a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        text-decoration: none;
    }

    /* Title styling */
    .brand-title {
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .logo {
            height: 35px;
        }

        .brand-title {
            font-size: 1.25rem;
        }

        header .container {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        header nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
        }

        header nav a {
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .brand-title {
            font-size: 1.1rem;
        }

        header nav a {
            font-size: 0.85rem;
            padding: 0.3rem 0.6rem;
        }
    }

    /* Footer enhancements */
    footer {
        border-top: 3px solid rgba(255, 255, 255, 0.1);
    }

    footer p {
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    /* Main content spacing */
    main.container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    /* Loading animation for logo */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .logo {
        animation: fadeIn 0.5s ease-out;
    }

    .bg-primary{
        background-color: #866eaf !important;
    }

    .text-primary{
        color: #6a99cb !important;
    }
</style>
