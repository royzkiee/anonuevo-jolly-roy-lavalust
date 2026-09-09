<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login()
    {
        $this->startSession();

        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            redirect('products');
            exit;
        }

        $error = $_SESSION['auth_error'] ?? $_SESSION['login_error'] ?? null;
        unset($_SESSION['auth_error'], $_SESSION['login_error']);

        $this->call->view('auth/login', [
            'page_title' => 'Login',
            'error' => $error
        ]);
    }

    public function authenticate()
    {
        $this->startSession();

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = 'Username and password are required.';
            redirect('login');
            exit;
        }

        $this->call->model('AccountModel');
        $account = $this->AccountModel->find_by_username($username);

        if ($account && ($password === $account['password'] || password_verify($password, $account['password']))) {
            $_SESSION['user_id'] = $account['id'];
            $_SESSION['username'] = $account['username'];
            redirect('products');
            exit;
        }

        $_SESSION['login_error'] = 'Invalid username or password.';
        redirect('login');
        exit;
    }

    public function logout()
    {
        $this->startSession();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
        redirect('login');
        exit;
    }
}
?>
