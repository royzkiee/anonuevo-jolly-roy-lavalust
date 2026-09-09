<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($page_title ?? 'Login'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
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

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface-2);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
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
            align-items: center;
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

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }

        .login-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.75rem 2.25rem;
            max-width: 440px;
            width: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 24px hsl(270, 30%, 93%);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--purple-400), var(--purple-600));
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-icon {
            width: 60px;
            height: 60px;
            background: var(--purple-100);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 1.25rem;
            border: 1px solid var(--purple-200);
        }

        .header-badge {
            display: inline-block;
            background: var(--purple-100);
            color: var(--purple-600);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.76rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            margin-bottom: 0.75rem;
            border: 1px solid var(--purple-200);
        }

        .login-header h1 {
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text-dark);
            margin-bottom: 0.35rem;
        }

        .login-header p {
            font-size: 0.9rem;
            color: var(--text-body);
        }

        .alert-box {
            padding: 0.85rem 1rem;
            border-radius: 10px;
            font-size: 0.86rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: hsl(0, 85%, 96%);
            color: hsl(0, 75%, 45%);
            border: 1px solid hsl(0, 80%, 88%);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--purple-600);
            margin-bottom: 0.5rem;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.92rem;
            font-family: inherit;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        input:focus {
            border-color: var(--purple-500);
            box-shadow: 0 0 0 3px var(--purple-100);
        }

        .btn-signin {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            background: linear-gradient(135deg, var(--purple-400), var(--purple-600));
            color: #ffffff;
            font-weight: 700;
            font-size: 0.92rem;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: transform 0.18s, box-shadow 0.18s;
            box-shadow: 0 4px 14px hsl(270, 60%, 70%, 0.4);
            margin-top: 0.75rem;
        }

        .btn-signin:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px hsl(270, 60%, 60%, 0.45);
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            font-size: 0.82rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            background: var(--surface);
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
        <a href="<?= site_url('student'); ?>">Home</a>
        <a href="<?= site_url('student/profile'); ?>">Profile</a>
        <a href="<?= site_url('users'); ?>">Users</a>
    </div>
</nav>

<div class="main-content">
    <div class="login-card">
        <div class="login-header">
            <div class="login-icon">🔐</div>
            <div class="header-badge">Authentication · LavaLust</div>
            <h1>Account Login</h1>
            <p>Enter your credentials to access product management</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert-box">
                <span>⚠</span>
                <?= html_escape($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= site_url('login'); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus autocomplete="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn-signin">Sign In</button>
        </form>
    </div>
</div>

<footer>
    &copy; <?= date('Y'); ?> Jolly Roy Añonuevo · MCC2024-00100 · Student Information System
</footer>

</body>
</html>
