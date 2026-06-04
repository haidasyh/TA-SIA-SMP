<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SMP Negeri 1 Bataguh')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --sage: #78a083;
            --teal: #50727b;
            --slate: #344955;
            --navy: #35374b;
            --page-bg: #f4f7f4;
            --surface: #ffffff;
            --surface-soft: #edf3ef;
            --surface-alt: #e3ece8;
            --text-dark: #22323a;
            --muted: #5f7278;
            --line: rgba(52, 73, 85, 0.14);
            --card-line: rgba(80, 114, 123, 0.14);
            --shadow-soft: 0 18px 40px rgba(53, 55, 75, 0.08);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Instrument Sans", Arial, sans-serif;
            background: var(--page-bg);
            color: var(--text-dark);
            background-image:
                radial-gradient(circle at top left, rgba(120, 160, 131, 0.15), transparent 28%),
                radial-gradient(circle at top right, rgba(80, 114, 123, 0.12), transparent 22%);
        }

        .navbar-school {
            background: rgba(244, 247, 244, 0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--line);
        }

        .navbar-school .navbar-collapse {
            flex-grow: 1;
        }

        .navbar-school .navbar-nav {
            width: auto;
            justify-content: flex-end;
            margin-left: auto;
        }

        .navbar-school-brand {
            flex-shrink: 0;
            color: #111111;
            font-size: 0.94rem;
            font-weight: 700;
            text-decoration: none;
            margin-right: 0.7rem;
            margin-left: 0;
        }

        .navbar-school-brand:hover {
            color: #111111;
        }

        .navbar-school .navbar-brand-box {
            width: 48px;
            height: 48px;
            border-radius: 0.8rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .navbar-school .navbar-brand-logo {
            width: 160%;
            height: 160%;
            object-fit: contain;
            display: block;
        }

        .navbar-school .navbar-brand-text {
            font-size: 0.92rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .navbar-school .nav-link {
            color: #151515;
            font-size: 0.88rem;
            font-weight: 500;
            position: relative;
            padding: 0.4rem 0.15rem;
        }

        .navbar-school .nav-link:hover,
        .navbar-school .nav-link:focus {
            color: var(--navy);
        }

        .navbar-school .nav-link::after {
            content: "";
            position: absolute;
            left: 0.5rem;
            right: 0.5rem;
            bottom: 0.1rem;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--sage), var(--teal));
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.25s ease;
        }

        .navbar-school .nav-link:hover::after,
        .navbar-school .nav-link:focus::after {
            transform: scaleX(1);
        }

        .navbar-register-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border-radius: 0.65rem;
            background: #d9d9d9;
            border: 1px solid #d1d1d1;
            color: #111111;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 0.55rem 0.8rem;
        }

        .navbar-register-btn:hover {
            background: #cfcfcf;
            color: #111111;
        }

        .navbar-register-btn i {
            font-size: 0.95rem;
            line-height: 1;
        }

        .section-frame {
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        .hero-section {
            min-height: 430px;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 78% 22%, rgba(120, 160, 131, 0.3), transparent 18%),
                linear-gradient(135deg, rgba(120, 160, 131, 0.18), rgba(80, 114, 123, 0.1) 45%, rgba(255, 255, 255, 0.92));
        }

        .hero-section::before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            right: -90px;
            top: -90px;
            border-radius: 50%;
            background: rgba(53, 55, 75, 0.08);
        }

        .about-section {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.82), rgba(227, 236, 232, 0.95));
        }

        .vision-section {
            background: linear-gradient(180deg, rgba(52, 73, 85, 0.06), rgba(80, 114, 123, 0.12));
        }

        .gallery-section {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(237, 243, 239, 1));
        }

        .footer-section {
            background: linear-gradient(135deg, rgba(52, 73, 85, 0.1), rgba(120, 160, 131, 0.12));
        }

        .section-space {
            padding-top: 4.75rem;
            padding-bottom: 4.75rem;
        }

        .school-title {
            font-size: clamp(2rem, 4vw, 3.25rem);
            font-weight: 700;
            line-height: 1.15;
            color: var(--navy);
        }

        .school-subtitle {
            font-size: clamp(1.9rem, 3vw, 2.75rem);
            font-weight: 700;
            line-height: 1.15;
            color: var(--navy);
        }

        .section-heading {
            font-size: clamp(2.05rem, 3.5vw, 3rem);
            font-weight: 700;
            line-height: 1.15;
            color: var(--navy);
        }

        .section-copy {
            color: var(--muted);
            font-size: 0.98rem;
            line-height: 1.95;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(120, 160, 131, 0.12);
            color: var(--teal);
            border: 1px solid rgba(120, 160, 131, 0.18);
            border-radius: 999px;
            padding: 0.5rem 0.9rem;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sage), var(--teal));
        }

        .hero-copy {
            max-width: 520px;
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.9;
        }

        .btn-cta,
        .btn-ghost {
            border-radius: 999px;
            font-size: 0.84rem;
            font-weight: 700;
            padding: 0.75rem 1.35rem;
        }

        .btn-cta {
            background: linear-gradient(135deg, var(--sage), var(--teal));
            border: 0;
            color: #fff;
            box-shadow: 0 16px 30px rgba(80, 114, 123, 0.22);
        }

        .btn-cta:hover {
            background: linear-gradient(135deg, #6e9578, #45656d);
            color: #fff;
        }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(52, 73, 85, 0.12);
            color: var(--navy);
        }

        .btn-ghost:hover {
            background: #fff;
            color: var(--navy);
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.9rem;
        }

        .info-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(52, 73, 85, 0.1);
            border-radius: 999px;
            padding: 0.65rem 1rem;
            color: var(--slate);
            font-size: 0.86rem;
            font-weight: 600;
            box-shadow: var(--shadow-soft);
        }

        .placeholder-box {
            width: 100%;
            background:
                linear-gradient(145deg, rgba(52, 73, 85, 0.98), rgba(53, 55, 75, 0.98)),
                linear-gradient(135deg, var(--sage), var(--teal));
            border: 1px solid rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.88);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
        }

        .placeholder-box::before,
        .placeholder-box::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(120, 160, 131, 0.22);
        }

        .placeholder-box::before {
            width: 180px;
            height: 180px;
            top: -40px;
            right: -40px;
        }

        .placeholder-box::after {
            width: 140px;
            height: 140px;
            bottom: -45px;
            left: -30px;
            background: rgba(80, 114, 123, 0.22);
        }

        .hero-image {
            aspect-ratio: 1 / 1;
            max-width: 360px;
            margin-inline: auto;
            border-radius: 2rem;
        }

        .about-image {
            aspect-ratio: 1 / 1;
            max-width: 320px;
            min-height: 320px;
            border-radius: 1.75rem;
        }

        .gallery-image {
            aspect-ratio: 3 / 4;
            max-width: 320px;
            min-height: 360px;
            margin-inline: auto;
            border-radius: 1.5rem;
        }

        .placeholder-box i,
        .placeholder-box .placeholder-label {
            position: relative;
            z-index: 1;
        }

        .placeholder-box i {
            font-size: clamp(4rem, 10vw, 7rem);
            line-height: 1;
        }

        .placeholder-label {
            position: absolute;
            left: 1.25rem;
            bottom: 1.1rem;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 999px;
            padding: 0.45rem 0.8rem;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .content-card {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(80, 114, 123, 0.12);
            border-radius: 1.75rem;
            padding: 2.25rem;
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(6px);
        }

        .vision-card {
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid var(--card-line);
            border-radius: 1.25rem;
            min-height: 360px;
            padding: 2rem 1.75rem;
            box-shadow: var(--shadow-soft);
        }

        .vision-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--navy);
        }

        .vision-card p {
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.95;
            margin-bottom: 0;
        }

        .vision-icon {
            width: 64px;
            height: 64px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1.1rem;
            margin-bottom: 1.25rem;
            background: linear-gradient(135deg, rgba(120, 160, 131, 0.18), rgba(80, 114, 123, 0.18));
            color: var(--teal);
            font-size: 1.5rem;
        }

        .gallery-title {
            letter-spacing: 0.35em;
            font-size: 0.9rem;
            text-transform: uppercase;
            color: var(--teal);
            font-weight: 700;
        }

        .gallery-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--navy);
            margin: 0.5rem auto 0;
        }

        .footer-brand {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--navy);
        }

        .footer-copy,
        .footer-link,
        .footer-contact {
            color: var(--muted);
            font-size: 0.93rem;
            line-height: 1.85;
            text-decoration: none;
        }

        .footer-link:hover {
            color: var(--navy);
        }

        .social-icon {
            width: 34px;
            height: 34px;
            border: 1px solid rgba(80, 114, 123, 0.16);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--teal);
            text-decoration: none;
            background: rgba(255, 255, 255, 0.72);
        }

        .social-icon:hover {
            color: #fff;
            border-color: transparent;
            background: linear-gradient(135deg, var(--sage), var(--teal));
        }

        .copyright {
            font-size: 0.8rem;
            color: var(--muted);
        }

        .section-title-wrap {
            max-width: 640px;
            margin-inline: auto;
        }

        .footer-panel {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(80, 114, 123, 0.12);
            border-radius: 1.75rem 1.75rem 0 0;
            padding: 1rem 1rem 0;
            box-shadow: var(--shadow-soft);
        }

        @media (max-width: 991.98px) {
            .navbar-school-brand {
                max-width: calc(100% - 64px);
                margin-right: 0;
            }

            .navbar-school .navbar-brand-text {
                font-size: 1rem;
            }

            .navbar-school .navbar-nav {
                align-items: flex-start !important;
                gap: 0.4rem !important;
                width: 100%;
                justify-content: flex-start;
                margin-top: 1rem;
            }

            .navbar-school .nav-link {
                padding-left: 0;
                padding-right: 0;
            }

            .navbar-register-btn {
                margin-top: 0.75rem;
            }

            .hero-section {
                min-height: auto;
            }

            .section-space {
                padding-top: 3.5rem;
                padding-bottom: 3.5rem;
            }

            .content-card,
            .vision-card {
                padding: 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
