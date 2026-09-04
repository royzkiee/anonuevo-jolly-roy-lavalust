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

        .nav-links a.btn-profile {
            background: var(--purple-500);
            color: #fff;
        }

        .nav-links a.btn-profile:hover {
            background: var(--purple-600);
        }

        .page-wrap {
            max-width: 960px;
            margin: 3rem auto 5rem;
            padding: 0 1.5rem;
        }

        .header-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px hsl(270, 40%, 93%);
        }

        .header-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--purple-400), var(--purple-600));
        }

        .header-badge {
            display: inline-block;
            background: var(--purple-100);
            color: var(--purple-600);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            margin-bottom: 1rem;
            border: 1px solid var(--purple-200);
        }

        .header-card h1 {
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text-dark);
            margin-bottom: 0.4rem;
        }

        .header-card p {
            font-size: 0.95rem;
            color: var(--text-body);
            line-height: 1.6;
        }

        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 24px hsl(270, 30%, 93%);
        }

        .table-toolbar {
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-title {
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--purple-600);
        }

        .count-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--purple-50);
            border: 1px solid var(--purple-200);
            color: var(--purple-700);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        thead {
            background: var(--surface-2);
            border-bottom: 1px solid var(--border);
        }

        thead th {
            padding: 1rem 1.5rem;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--purple-600);
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--purple-50);
        }

        tbody td {
            padding: 1.1rem 1.5rem;
            color: var(--text-dark);
            vertical-align: middle;
        }

        .id-badge {
            display: inline-block;
            background: var(--purple-100);
            color: var(--purple-700);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            border: 1px solid var(--purple-200);
        }

        .user-name {
            font-weight: 700;
            color: var(--text-dark);
        }

        .user-email {
            color: var(--text-body);
        }

        .user-handle {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.84rem;
            color: var(--purple-600);
            background: var(--surface-2);
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
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
            .page-wrap { margin-top: 2rem; }
            .header-card { padding: 1.75rem 1.25rem; }
            tbody td, thead th { padding: 0.85rem 1rem; }
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
        <a href="<?= site_url('users'); ?>" class="active">Users</a>
    </div>
</nav>

<div class="page-wrap">
    <div class="header-card">
        <div class="header-badge">Database Management · mydb.users</div>
        <h1>Users Directory</h1>
        <p>Dynamic listing of all registered users retrieved from the MySQL database via UsersModel.</p>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <span class="table-title">Registered Accounts</span>
            <span class="count-pill"><?= !empty($users) ? count($users) : 0; ?> Total Users</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><span class="id-badge">#<?= html_escape($user['id']); ?></span></td>
                                <td class="user-name"><?= html_escape($user['firstname']); ?></td>
                                <td><?= html_escape($user['lastname']); ?></td>
                                <td class="user-email"><?= html_escape($user['email']); ?></td>
                                <td><span class="user-handle">@<?= html_escape($user['username']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="empty-icon">👥</div>
                                <p>No users found in the database.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer>
    &copy; <?= date('Y'); ?> Jolly Roy Añonuevo · MCC2024-00100 · Student Information System
</footer>

</body>
</html>
