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
        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true);

        // If JSON request (e.g. from API tester or frontend)
        if (is_array($jsonData) && !empty($jsonData)) {
            $this->call->library('api');
            $username = trim($jsonData['username'] ?? '');
            $password = trim($jsonData['password'] ?? '');

            if (empty($username) || empty($password)) {
                $this->api->respond_error('Username and password are required.', 422);
            }

            $this->call->model('AccountModel');
            $account = $this->AccountModel->find_by_username($username);

            if ($account && ($password === $account['password'] || password_verify($password, $account['password']))) {
                $tokens = $this->api->issue_tokens([
                    'id'       => $account['id'],
                    'username' => $account['username']
                ]);
                $this->api->respond([
                    'status'        => 'success',
                    'message'       => 'Login successful',
                    'user'          => [
                        'id'       => $account['id'],
                        'username' => $account['username']
                    ],
                    'access_token'  => $tokens['access_token'],
                    'refresh_token' => $tokens['refresh_token'],
                    'expires_in'    => $tokens['expires_in'] ?? 900,
                    'token_type'    => 'Bearer',
                    'tokens'        => $tokens
                ], 200);
            }

            $this->api->respond_error('Invalid username or password.', 401);
        }

        // Web session authentication (Lab 5)
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
        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true);
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        // If JSON or API token logout
        if ((is_array($jsonData) && !empty($jsonData)) || !empty($authHeader)) {
            $this->call->library('api');
            $refreshToken = $jsonData['refresh_token'] ?? null;
            if (!empty($refreshToken)) {
                $this->api->revoke_refresh_token($refreshToken);
            }
            $this->api->respond([
                'status'  => 'success',
                'message' => 'Logged out successfully.'
            ], 200);
        }

        // Web session logout (Lab 5)
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
