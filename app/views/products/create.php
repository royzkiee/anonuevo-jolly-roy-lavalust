<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($page_title ?? 'Add Product'); ?></title>
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

        .page-wrap {
            max-width: 680px;
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

        .alert-box {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: hsl(0, 85%, 96%);
            color: hsl(0, 75%, 45%);
            border: 1px solid hsl(0, 80%, 88%);
        }

        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 4px 24px hsl(270, 30%, 93%);
        }

        .form-group {
            margin-bottom: 1.5rem;
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

        input[type="text"], input[type="number"], textarea {
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

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        input:focus, textarea:focus {
            border-color: var(--purple-500);
            box-shadow: 0 0 0 3px var(--purple-100);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.75rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .btn-cancel {
            padding: 0.65rem 1.25rem;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-body);
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 10px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-cancel:hover {
            background: var(--border);
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: linear-gradient(135deg, var(--purple-400), var(--purple-600));
            color: #ffffff;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: transform 0.18s, box-shadow 0.18s;
            box-shadow: 0 4px 14px hsl(270, 60%, 70%, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px hsl(270, 60%, 60%, 0.45);
        }

        footer {
            text-align: center;
            padding: 2rem;
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
        <a href="<?= site_url('products'); ?>" class="active">Products</a>
    </div>
</nav>

<div class="page-wrap">
    <div class="header-card">
        <div class="header-badge">Inventory Management · Create Record</div>
        <h1>Add Motorcycle Part</h1>
        <p>Fill out the details below to add a new product item into the database.</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert-box">
            <span>⚠</span>
            <?= html_escape($error); ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST" action="<?= site_url('products/create'); ?>">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" value="<?= html_escape($old['product_name'] ?? ''); ?>" placeholder="e.g. RCB Rear Shock Absorber" required autofocus>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Product details and specifications..."><?= html_escape($old['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (₱)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="<?= html_escape($old['price'] ?? ''); ?>" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" step="1" min="0" value="<?= html_escape($old['quantity'] ?? ''); ?>" placeholder="0" required>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= site_url('products'); ?>" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Save Product</button>
            </div>
        </form>
    </div>
</div>

<footer>
    &copy; <?= date('Y'); ?> Jolly Roy Añonuevo · MCC2024-00100 · Student Information System
</footer>

</body>
</html>
