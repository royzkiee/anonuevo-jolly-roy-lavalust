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

        .nav-links a.btn-home {
            background: var(--surface-2);
            border: 1px solid var(--border);
        }

        .page-wrap {
            max-width: 780px;
            margin: 3rem auto 5rem;
            padding: 0 1.5rem;
        }

        .profile-header {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--purple-400), var(--purple-600));
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple-300), var(--purple-600));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 44px;
            flex-shrink: 0;
            box-shadow: 0 0 0 4px var(--purple-100), 0 0 0 8px var(--purple-200);
        }

        .profile-meta h1 {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .profile-meta .id-badge {
            display: inline-block;
            background: var(--purple-100);
            color: var(--purple-600);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            font-weight: 500;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            margin-bottom: 0.75rem;
            border: 1px solid var(--purple-200);
        }

        .profile-meta .bio {
            font-size: 0.9rem;
            color: var(--text-body);
            line-height: 1.65;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.4rem 1.5rem;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .info-card:hover {
            border-color: var(--purple-300);
            box-shadow: 0 4px 20px hsl(270, 50%, 88%);
        }

        .info-card .label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--purple-500);
            margin-bottom: 0.35rem;
        }

        .info-card .value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.4;
        }

        .full-card {
            grid-column: 1 / -1;
        }

        .section-title {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--purple-500);
            margin-bottom: 0.75rem;
            padding-left: 0.25rem;
        }

        .social-row {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.4rem 1.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .social-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-body);
            transition: background 0.18s, border-color 0.18s;
        }

        .social-chip:hover {
            background: var(--purple-100);
            border-color: var(--purple-300);
            color: var(--purple-600);
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
            .nav-links a:not(.active) { display: none; }
            .profile-header { flex-direction: column; text-align: center; }
            .info-grid { grid-template-columns: 1fr; }
            .full-card { grid-column: 1; }
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
        <a href="<?= site_url('student'); ?>" class="btn-home">← Home</a>
        <a href="<?= site_url('student/profile'); ?>" class="active">Student Profile</a>
        <a href="<?= site_url('users'); ?>" class="btn-home">Users →</a>
    </div>
</nav>

<div class="page-wrap">

    <div class="profile-header">
        <div class="avatar">👨‍💻</div>
        <div class="profile-meta">
            <h1><?php echo $student['name']; ?></h1>
            <div class="id-badge"><?php echo $student['student_id']; ?></div>
            <p class="bio"><?php echo $student['bio']; ?></p>
        </div>
    </div>

    <p class="section-title">Academic Information</p>
    <div class="info-grid">
        <div class="info-card">
            <div class="label">Student ID</div>
            <div class="value"><?php echo $student['student_id']; ?></div>
        </div>
        <div class="info-card">
            <div class="label">Full Name</div>
            <div class="value"><?php echo $student['name']; ?></div>
        </div>
        <div class="info-card">
            <div class="label">Course</div>
            <div class="value"><?php echo $student['course']; ?></div>
        </div>
        <div class="info-card">
            <div class="label">Year Level</div>
            <div class="value"><?php echo $student['year']; ?></div>
        </div>
        <div class="info-card">
            <div class="label">Section</div>
            <div class="value"><?php echo $student['section']; ?></div>
        </div>
        <div class="info-card">
            <div class="label">Email</div>
            <div class="value"><?php echo $student['email']; ?></div>
        </div>
        <div class="info-card full-card">
            <div class="label">Address</div>
            <div class="value"><?php echo $student['address']; ?></div>
        </div>
        <div class="info-card">
            <div class="label">Contact Number</div>
            <div class="value"><?php echo $student['contact']; ?></div>
        </div>
        <div class="info-card">
            <div class="label">Skills</div>
            <div class="value"><?php echo $student['skills']; ?></div>
        </div>
        <div class="info-card full-card">
            <div class="label">Hobbies</div>
            <div class="value"><?php echo $student['hobbies']; ?></div>
        </div>
    </div>

    <p class="section-title">Social Media</p>
    <div class="social-row">
        <div class="social-chip">🎵 TikTok: <?php echo $student['tiktok']; ?></div>
        <div class="social-chip">📘 Facebook: <?php echo $student['facebook']; ?></div>
    </div>

</div>

<footer>
    &copy; <?= date('Y'); ?> Jolly Roy Añonuevo · MCC2024-00100 · Student Information System
</footer>

</body>
</html>
