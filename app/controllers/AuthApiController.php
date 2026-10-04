<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
        $this->call->model('AccountModel');
    }

    /**
     * POST /api/auth/login
     */
    public function login()
    {
        $this->api->require_method('POST');
        $body = $this->api->body();

        $username = trim($body['username'] ?? '');
        $password = trim($body['password'] ?? '');

        if (empty($username) || empty($password)) {
            $this->api->respond_error('Username and password are required.', 422);
        }

        $account = $this->AccountModel->find_by_username($username);

        if (!$account) {
            $this->api->respond_error('Invalid username or password.', 401);
        }

        $isValid = ($password === $account['password'] || password_verify($password, $account['password']));

        if (!$isValid) {
            $this->api->respond_error('Invalid username or password.', 401);
        }

        $tokens = $this->api->issue_tokens([
            'id'       => $account['id'],
            'username' => $account['username']
        ]);

        $this->api->respond([
            'status'       => 'success',
            'message'      => 'Login successful',
            'user'         => [
                'id'       => $account['id'],
                'username' => $account['username']
            ],
            'access_token' => $tokens['access_token'],
            'refresh_token'=> $tokens['refresh_token'],
            'expires_in'   => $tokens['expires_in'],
            'token_type'   => $tokens['token_type'],
            'tokens'       => $tokens
        ], 200);
    }

    /**
     * POST /api/auth/register
     */
    public function register()
    {
        $this->api->require_method('POST');
        $body = $this->api->body();

        $username = trim($body['username'] ?? '');
        $password = trim($body['password'] ?? '');

        if (empty($username) || empty($password)) {
            $this->api->respond_error('Username and password are required.', 422);
        }

        if (strlen($username) < 3) {
            $this->api->respond_error('Username must be at least 3 characters.', 422);
        }

        if (strlen($password) < 6) {
            $this->api->respond_error('Password must be at least 6 characters.', 422);
        }

        $existing = $this->AccountModel->find_by_username($username);
        if ($existing) {
            $this->api->respond_error('Username is already taken.', 409);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $insertId = $this->AccountModel->insert([
            'username' => $username,
            'password' => $hashedPassword
        ]);

        if ($insertId) {
            $this->api->respond([
                'status'  => 'success',
                'message' => 'Account created successfully.',
                'data'    => [
                    'id'       => $insertId,
                    'username' => $username
                ]
            ], 201);
        } else {
            $this->api->respond_error('Failed to create account.', 500);
        }
    }

    /**
     * GET /api/auth/me
     */
    public function me()
    {
        $this->api->require_method('GET');
        $payload = $this->api->require_jwt();

        $account = $this->AccountModel->find($payload['sub'] ?? 0);
        if (!$account) {
            $this->api->respond_error('User not found.', 404);
        }

        $studentProfile = [
            'student_id' => 'MCC2024-00100',
            'name'       => 'Jolly Roy Añonuevo',
            'course'     => 'Bachelor of Science in Information Technology',
            'year'       => '3rd Year',
            'section'    => 'BSIT-3-F2',
            'email'      => 'jollyroyp.anonuevo@mcc.edu.ph',
            'address'    => 'Bangkatan, Baco, Oriental Mindoro',
            'contact'    => '09677504593',
            'skills'     => 'Playing Games',
            'hobbies'    => 'Studying Different Kinds of Motorcycle',
            'bio'        => "Hey! I'm Jolly Roy, a 3rd-year IT major at MinSU. Tech student by day, gamer by night, and full-time motorcycle nerd in between.",
            'tiktok'     => '@royyzxxx',
            'facebook'   => 'Jolly Roy Añonuevo',
        ];

        $this->api->respond([
            'status'  => 'success',
            'user'    => [
                'id'       => $account['id'],
                'username' => $account['username']
            ],
            'student' => $studentProfile
        ], 200);
    }

    /**
     * POST /api/auth/refresh
     */
    public function refresh()
    {
        $this->api->require_method('POST');
        $body = $this->api->body();
        $token = $body['refresh_token'] ?? '';

        if (empty($token)) {
            $this->api->respond_error('Refresh token is required.', 422);
        }

        $this->api->refresh_access_token($token);
    }

    /**
     * POST /api/auth/logout
     */
    public function logout()
    {
        $this->api->require_method('POST');
        $body = $this->api->body();
        $token = $body['refresh_token'] ?? '';

        if (!empty($token)) {
            $this->api->revoke_refresh_token($token);
        }

        $this->api->respond([
            'status'  => 'success',
            'message' => 'Logged out successfully.'
        ], 200);
    }
}
