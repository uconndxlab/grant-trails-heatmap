<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Grant Trails Heatmap - University of Connecticut')</title>

    @vite(['resources/scss/app.scss'])
</head>
<body>
    <x-uconn-banner />

    <header>
        <nav class="navbar navbar-expand-lg border-bottom border-5 border-secondary">
            <div class="container py-3 align-items-end">
                <div class="text-start me-3">
                    <a href="https://core.uconn.edu/" target="_blank" class="uconn-brand-parent-site-title d-block link-dark fw-normal text-uppercase" style="letter-spacing: 1px; font-size: 13px">Center for Open Research Resources & Equipment</a>
                    <a href="/" class="d-block pt-0 uconn-brand-site-title fw-semibold fs-4 link-dark">Grant Trails Heatmap</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <!--start light footer-->
        <div class="i3-footer i3-footer--light py-4">
            <img src="{{ asset('img/i3-symbol-blue.svg') }}" alt="i3 symbol" />
            <p>Powered by</p>
            <a class="i3-footer-btn" href="https://innovation.provost.uconn.edu/"> i3 </a>
        </div>
        <!--end light footer-->
        <div class="bg-dark text-white py-5">
            <div class="container">
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center links-underline-on-hover text-small">
                    <a class="link-light pe-lg-5 mb-2" href="https://uconn.edu">&copy; {{ date('Y') }} University of
                    Connecticut</a>
                    <a class="link-light pe-lg-5 mb-2" href="https://provost.uconn.edu">Office of the Provost</a>
                    <a class="link-light pe-lg-5 mb-2" href="https://uconn.edu/disclaimers-privacy-copyright/">Disclaimers, Privacy &amp; Copyright</a>
                    <a class="link-light pe-lg-5 mb-2" href="https://accessibility.uconn.edu/">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>

    @vite('resources/js/app.js')
</body>
</html>