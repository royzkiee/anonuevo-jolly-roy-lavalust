<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function before_action()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            $_SESSION['auth_error'] = 'Please log in to access this page.';
            redirect('login');
            exit;
        }
    }

    public function index()
    {
        $this->call->model('ProductModel');
        $products = $this->ProductModel->all();

        $success = $_SESSION['success'] ?? null;
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['success'], $_SESSION['error']);

        $this->call->view('products/index', [
            'page_title' => 'Products',
            'products' => $products ?: [],
            'success' => $success,
            'error' => $error,
            'username' => $_SESSION['username'] ?? 'Admin'
        ]);
    }

    public function create()
    {
        $error = $_SESSION['error'] ?? null;
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['error'], $_SESSION['old']);

        $this->call->view('products/create', [
            'page_title' => 'Add Product',
            'error' => $error,
            'old' => $old
        ]);
    }

    public function store()
    {
        $product_name = trim($_POST['product_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $quantity = trim($_POST['quantity'] ?? '');

        if ($product_name === '' || $price === '' || $quantity === '') {
            $_SESSION['error'] = 'Product name, price, and quantity are required.';
            $_SESSION['old'] = $_POST;
            redirect('products/create');
            exit;
        }

        if (!is_numeric($price) || (float)$price < 0) {
            $_SESSION['error'] = 'Price must be a valid non-negative number.';
            $_SESSION['old'] = $_POST;
            redirect('products/create');
            exit;
        }

        if (!is_numeric($quantity) || (int)$quantity < 0 || (string)(int)$quantity !== (string)$quantity) {
            $_SESSION['error'] = 'Quantity must be a valid non-negative integer.';
            $_SESSION['old'] = $_POST;
            redirect('products/create');
            exit;
        }

        $this->call->model('ProductModel');
        $this->ProductModel->insert([
            'product_name' => $product_name,
            'description' => $description,
            'price' => number_format((float)$price, 2, '.', ''),
            'quantity' => (int)$quantity
        ]);

        $_SESSION['success'] = 'Product created successfully.';
        redirect('products');
        exit;
    }

    public function edit($id)
    {
        $this->call->model('ProductModel');
        $product = $this->ProductModel->find($id);

        if (!$product) {
            $_SESSION['error'] = 'Product not found.';
            redirect('products');
            exit;
        }

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $this->call->view('products/edit', [
            'page_title' => 'Edit Product',
            'product' => $product,
            'error' => $error
        ]);
    }

    public function update($id)
    {
        $this->call->model('ProductModel');
        $product = $this->ProductModel->find($id);

        if (!$product) {
            $_SESSION['error'] = 'Product not found.';
            redirect('products');
            exit;
        }

        $product_name = trim($_POST['product_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $quantity = trim($_POST['quantity'] ?? '');

        if ($product_name === '' || $price === '' || $quantity === '') {
            $_SESSION['error'] = 'Product name, price, and quantity are required.';
            redirect('products/edit/' . $id);
            exit;
        }

        if (!is_numeric($price) || (float)$price < 0) {
            $_SESSION['error'] = 'Price must be a valid non-negative number.';
            redirect('products/edit/' . $id);
            exit;
        }

        if (!is_numeric($quantity) || (int)$quantity < 0 || (string)(int)$quantity !== (string)$quantity) {
            $_SESSION['error'] = 'Quantity must be a valid non-negative integer.';
            redirect('products/edit/' . $id);
            exit;
        }

        $this->ProductModel->update($id, [
            'product_name' => $product_name,
            'description' => $description,
            'price' => number_format((float)$price, 2, '.', ''),
            'quantity' => (int)$quantity
        ]);

        $_SESSION['success'] = 'Product updated successfully.';
        redirect('products');
        exit;
    }

    public function delete($id)
    {
        $this->call->model('ProductModel');
        $product = $this->ProductModel->find($id);

        if (!$product) {
            $_SESSION['error'] = 'Product not found.';
            redirect('products');
            exit;
        }

        $this->ProductModel->delete($id);

        $_SESSION['success'] = 'Product deleted successfully.';
        redirect('products');
        exit;
    }
}
?>
