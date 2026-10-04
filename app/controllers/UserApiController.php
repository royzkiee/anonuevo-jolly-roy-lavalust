<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
        $this->call->model('UsersModel');
    }

    /**
     * GET /api/users or GET /users-list
     * Display all users
     */
    public function index()
    {
        $this->api->require_method('GET');
        $this->api->require_jwt();

        $users = $this->UsersModel->all();

        $this->api->respond([
            'status' => 'success',
            'data'   => $users ?: []
        ], 200);
    }

    /**
     * GET /api/users/{id}
     * Display single user
     */
    public function show($id)
    {
        $this->api->require_method('GET');
        $this->api->require_jwt();

        $user = $this->UsersModel->find($id);

        if (!$user) {
            $this->api->respond_error('User not found', 404);
        }

        $this->api->respond([
            'status' => 'success',
            'data'   => $user
        ], 200);
    }

    /**
     * POST /api/users
     * Create a new user
     */
    public function store()
    {
        $this->api->require_method('POST');
        $this->api->require_jwt();

        $data = $this->api->body();

        $firstname = trim($data['firstname'] ?? '');
        $lastname  = trim($data['lastname'] ?? '');
        $email     = trim($data['email'] ?? '');
        $username  = trim($data['username'] ?? '');

        if ($firstname === '' || $lastname === '' || $email === '' || $username === '') {
            $this->api->respond_error('Firstname, lastname, email, and username are required.', 422);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->api->respond_error('Invalid email format.', 422);
        }

        $insertData = [
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $email,
            'username'  => $username
        ];

        $insertedId = $this->UsersModel->insert($insertData);

        if ($insertedId) {
            $this->api->respond([
                'status'  => 'success',
                'message' => 'User created successfully.',
                'data'    => array_merge(['id' => $insertedId], $insertData)
            ], 201);
        } else {
            $this->api->respond_error('Failed to create user.', 500);
        }
    }

    /**
     * PUT/PATCH/POST /api/users/{id}
     * Update an existing user
     */
    public function update($id)
    {
        $this->api->require_jwt();

        $user = $this->UsersModel->find($id);
        if (!$user) {
            $this->api->respond_error('User not found', 404);
        }

        $data = $this->api->body();
        $updateData = [];

        if (isset($data['firstname'])) {
            $firstname = trim($data['firstname']);
            if ($firstname === '') {
                $this->api->respond_error('Firstname cannot be empty.', 422);
            }
            $updateData['firstname'] = $firstname;
        }

        if (isset($data['lastname'])) {
            $lastname = trim($data['lastname']);
            if ($lastname === '') {
                $this->api->respond_error('Lastname cannot be empty.', 422);
            }
            $updateData['lastname'] = $lastname;
        }

        if (isset($data['email'])) {
            $email = trim($data['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->api->respond_error('Invalid email format.', 422);
            }
            $updateData['email'] = $email;
        }

        if (isset($data['username'])) {
            $username = trim($data['username']);
            if ($username === '') {
                $this->api->respond_error('Username cannot be empty.', 422);
            }
            $updateData['username'] = $username;
        }

        if (empty($updateData)) {
            $this->api->respond_error('No data provided to update.', 400);
        }

        $this->UsersModel->update($id, $updateData);

        $this->api->respond([
            'status'  => 'success',
            'message' => 'User updated successfully.',
            'data'    => array_merge($user, $updateData)
        ], 200);
    }

    /**
     * DELETE/POST /api/users/{id}
     * Delete a user
     */
    public function destroy($id)
    {
        $this->api->require_jwt();

        $user = $this->UsersModel->find($id);
        if (!$user) {
            $this->api->respond_error('User not found', 404);
        }

        $this->UsersModel->delete($id);

        $this->api->respond([
            'status'  => 'success',
            'message' => 'User deleted successfully.'
        ], 200);
    }
}
