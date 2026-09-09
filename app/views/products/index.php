<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($page_title ?? 'Products'); ?></title>
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

        .nav-links a.btn-logout {
            background: hsl(0, 85%, 96%);
            color: hsl(0, 75%, 50%);
            border: 1px solid hsl(0, 80%, 90%);
            margin-left: 0.5rem;
        }

        .nav-links a.btn-logout:hover {
            background: hsl(0, 85%, 92%);
            color: hsl(0, 75%, 42%);
        }

        .page-wrap {
            max-width: 1100px;
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
        }

        .alert-success {
            background: hsl(140, 70%, 96%);
            color: hsl(140, 65%, 30%);
            border: 1px solid hsl(140, 60%, 85%);
        }

        .alert-danger {
            background: hsl(0, 85%, 96%);
            color: hsl(0, 75%, 45%);
            border: 1px solid hsl(0, 80%, 88%);
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
            gap: 1rem;
            flex-wrap: wrap;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
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
            font-family: 'JetBrains Mono', monospace;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: linear-gradient(135deg, var(--purple-400), var(--purple-600));
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 0.55rem 1.25rem;
            border-radius: 10px;
            transition: transform 0.18s, box-shadow 0.18s;
            box-shadow: 0 4px 14px hsl(270, 60%, 70%, 0.4);
            border: none;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px hsl(270, 60%, 60%, 0.45);
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
            padding: 1rem 1.25rem;
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
            padding: 1.1rem 1.25rem;
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

        .product-name {
            font-weight: 700;
            color: var(--text-dark);
        }

        .product-desc {
            color: var(--text-muted);
            font-size: 0.86rem;
            max-width: 280px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .price-badge {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            color: var(--purple-700);
            font-size: 0.92rem;
        }

        .qty-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.2rem 0.55rem;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-body);
        }

        .date-cell {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .actions-cell {
            text-align: right;
            white-space: nowrap;
        }

        .action-edit {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--purple-600);
            background: var(--purple-100);
            border: 1px solid var(--purple-200);
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .action-edit:hover {
            background: var(--purple-200);
        }

        .action-delete {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: hsl(0, 75%, 50%);
            background: hsl(0, 85%, 96%);
            border: 1px solid hsl(0, 80%, 90%);
            border-radius: 6px;
            text-decoration: none;
            margin-left: 0.4rem;
            cursor: pointer;
            transition: background 0.15s;
        }

        .action-delete:hover {
            background: hsl(0, 85%, 90%);
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

        @media (max-width: 768px) {
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
        <a href="<?= site_url('users'); ?>">Users</a>
        <a href="<?= site_url('products'); ?>" class="active">Products</a>
        <a href="<?= site_url('logout'); ?>" class="btn-logout">Sign Out</a>
    </div>
</nav>

<div class="page-wrap">
    <div class="header-card">
        <div class="header-badge">Database Management · mydb.products</div>
        <h1>Motorcycle Parts Directory</h1>
        <p>Complete CRUD management for motorcycle parts inventory connected to MySQL database via ProductModel.</p>
    </div>

    <?php if (!empty($success)): ?>
        <div class="alert-box alert-success">
            <span>✓</span>
            <?= html_escape($success); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert-box alert-danger">
            <span>⚠</span>
            <?= html_escape($error); ?>
        </div>
    <?php endif; ?>

    <div class="table-card">
        <div class="table-toolbar">
            <div class="toolbar-left">
                <span class="table-title">Inventory Catalog</span>
                <span class="count-pill"><?= !empty($products) ? count($products) : 0; ?> Total Items</span>
            </div>
            <a href="<?= site_url('products/create'); ?>" class="btn-add">+ Add Product</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Date Added</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><span class="id-badge">#<?= html_escape($p['id']); ?></span></td>
                                <td class="product-name"><?= html_escape($p['product_name']); ?></td>
                                <td class="product-desc" title="<?= html_escape($p['description'] ?? ''); ?>"><?= html_escape($p['description'] ?? '—'); ?></td>
                                <td><span class="price-badge">₱<?= number_format((float)$p['price'], 2); ?></span></td>
                                <td><span class="qty-badge"><?= html_escape($p['quantity']); ?> pcs</span></td>
                                <td class="date-cell"><?= html_escape(date('M d, Y', strtotime($p['created_at']))); ?></td>
                                <td class="actions-cell">
                                    <a href="<?= site_url('products/edit/' . $p['id']); ?>" class="action-edit">Edit</a>
                                    <a href="<?= site_url('products/delete/' . $p['id']); ?>" class="action-delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-icon">📦</div>
                                <p>No products found in the catalog. Click "+ Add Product" to create one.</p>
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
