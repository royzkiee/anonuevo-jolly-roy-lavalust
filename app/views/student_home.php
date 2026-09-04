<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --purple-50:  hsl(270, 100%, 98%);
            --purple-100: hsl(270, 95%, 94%);
            --purple-200: hsl(270, 90%, 88%);
            --purple-300: hsl(270, 85%, 78%);
            --purple-400: hsl(270, 75%, 65%);
            --purple-500: hsl(270, 65%, 52%);
            --purple-600: hsl(270, 60%, 44%);
            --purple-700: hsl(270, 55%, 36%);
            --text-dark:  hsl(270, 20%, 15%);
            --text-body:  hsl(270, 10%, 35%);
            --text-muted: hsl(270, 8%, 55%);
            --surface:    hsl(0, 0%, 100%);
            --surface-2:  hsl(270, 50%, 97%);
            --border:     hsl(270, 30%, 90%);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface-2);
            color: var(--text-dark);
            min-height: 100vh;
        }

        nav {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 12px hsl(270, 40%, 90%);
        }

        .nav-brand {
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--purple-600);
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-brand span {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--purple-400), var(--purple-600));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .nav-links {
            display: flex;
            gap: 0.25rem;
        }

        .nav-links a {
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.45rem 1rem;
            border-radius: 8px;
            color: var(--text-body);
            transition: background 0.18s, color 0.18s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: var(--purple-100);
            color: var(--purple-600);
        }

        .nav-links a.btn-profile {
            background: var(--purple-500);
            color: #fff;
        }

        .nav-links a.btn-profile:hover {
            background: var(--purple-600);
        }

        .hero {
            max-width: 860px;
            margin: 5rem auto 0;
            padding: 0 2rem;
            text-align: center;
        }

        .hero-badge {
            display: inline-block;
            background: var(--purple-100);
            color: var(--purple-600);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.35rem 1rem;
            border-radius: 999px;
            margin-bottom: 1.75rem;
            border: 1px solid var(--purple-200);
        }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.03em;
            color: var(--text-dark);
            margin-bottom: 1.25rem;
        }

        .hero h1 em {
            font-style: normal;
            color: var(--purple-500);
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--text-body);
            line-height: 1.75;
            max-width: 560px;
            margin: 0 auto 2.5rem;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--purple-400), var(--purple-600));
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 24px hsl(270, 60%, 70%, 0.45);
        }

        .hero-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px hsl(270, 60%, 60%, 0.5);
        }

        .cards {
            max-width: 860px;
            margin: 4rem auto 6rem;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1rem;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 32px hsl(270, 40%, 85%);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            background: var(--purple-100);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 1rem;
        }

        .card h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.4rem;
        }

        .card p {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        footer {
            text-align: center;
            padding: 2rem;
            font-size: 0.82rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            background: var(--surface);
        }

        @media (max-width: 600px) {
            nav { padding: 0 1rem; }
            .nav-links a:not(.btn-profile) { display: none; }
            .hero { margin-top: 3rem; }
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-brand">
        <span>👨‍💻</span>
        JollyRoy.dev
    </div>
    <div class="nav-links">
        <a href="<?= site_url('student'); ?>" class="active">Home</a>
        <a href="<?= site_url('student/profile'); ?>">Profile</a>
        <a href="<?= site_url('users'); ?>" class="btn-profile">Users →</a>
    </div>
</nav>

<div class="hero">
    <div class="hero-badge">MCC2024-00100 · BSIT-3-F2</div>
    <h1>Welcome to<br><em>Jolly Roy's</em> Page</h1>
    <p>A 3rd-year IT major at MinSU — tech student by day, gamer by night, and full-time motorcycle nerd in between.</p>
    <a href="<?= site_url('student/profile'); ?>" class="hero-cta">View My Profile →</a>
</div>

<div class="cards">
    <div class="card">
        <div class="card-icon">🎓</div>
        <h3>BSIT – 3rd Year</h3>
        <p>Currently enrolled in Bachelor of Science in Information Technology at MinSU.</p>
    </div>
    <div class="card">
        <div class="card-icon">🎮</div>
        <h3>Gamer at Heart</h3>
        <p>Passionate about gaming and exploring the latest titles when not studying IT.</p>
    </div>
    <div class="card">
        <div class="card-icon">🏍️</div>
        <h3>Motorcycle Enthusiast</h3>
        <p>Dedicated to studying different kinds of motorcycles — it's more than a hobby.</p>
    </div>
</div>

<footer>
    &copy; <?= date('Y'); ?> Jolly Roy Añonuevo · MCC2024-00100 · Oriental Mindoro
</footer>

</body>
</html>
