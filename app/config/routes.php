<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/
/** @var object $router **/

$router->get('/', 'Welcome::index');

load_class('config', 'kernel')->load('middleware');

$router->get('/student', 'StudentController::index');
$router->get('/student/profile', 'StudentController::profile')->middleware('student');
$router->get('/users', 'UsersController::index');

$router->get('/login', 'AuthController::login');
$router->post('/login', 'AuthController::authenticate');
$router->get('/logout', 'AuthController::logout');
$router->post('/logout', 'AuthController::logout');

$router->get('/products', 'ProductController::index')->middleware('auth');
$router->get('/products/create', 'ProductController::create')->middleware('auth');
$router->post('/products/create', 'ProductController::store')->middleware('auth');
$router->post('/products/store', 'ProductController::store')->middleware('auth');
$router->get('/products/edit/{id}', 'ProductController::edit')->middleware('auth');
$router->post('/products/edit/{id}', 'ProductController::update')->middleware('auth');
$router->post('/products/update/{id}', 'ProductController::update')->middleware('auth');
$router->get('/products/delete/{id}', 'ProductController::delete')->middleware('auth');
$router->post('/products/delete/{id}', 'ProductController::delete')->middleware('auth');

// Migration Routes
$router->get('create-migration/{migration_class}', 'MigrationController::create_migration');
$router->get('migrate', 'MigrationController::migrate');
$router->get('rollback', 'MigrationController::rollback');
$router->get('rollback-all', 'MigrationController::rollback_all');
$router->get('refresh', 'MigrationController::refresh');
$router->get('status', 'MigrationController::status');

// -------------------------------------------------------------
// Laboratory Exercise No. 6: REST API Endpoints
// -------------------------------------------------------------
// Auth API
$router->post('api/auth/login', 'AuthApiController::login');
$router->post('api/auth/register', 'AuthApiController::register');
$router->post('api/auth/refresh', 'AuthApiController::refresh');
$router->post('api/auth/logout', 'AuthApiController::logout');
$router->get('api/auth/me', 'AuthApiController::me');

// Product CRUD API
$router->get('api/products', 'ProductApiController::index');
$router->get('api/products/{id}', 'ProductApiController::show');
$router->post('api/products', 'ProductApiController::store');
$router->put('api/products/{id}', 'ProductApiController::update');
$router->patch('api/products/{id}', 'ProductApiController::update');
$router->delete('api/products/{id}', 'ProductApiController::destroy');
// Users CRUD API
$router->get('api/users', 'UserApiController::index');
$router->get('api/users/{id}', 'UserApiController::show');
$router->post('api/users', 'UserApiController::store');
$router->put('api/users/{id}', 'UserApiController::update');
$router->patch('api/users/{id}', 'UserApiController::update');
$router->delete('api/users/{id}', 'UserApiController::destroy');

// API Tester Default Aliases
$router->post('api/login', 'AuthApiController::login');
$router->post('api/refresh', 'AuthApiController::refresh');
$router->post('api/logout', 'AuthApiController::logout');
$router->get('api/profile', 'AuthApiController::me');
$router->get('api/list', 'ProductApiController::index');
$router->post('api/create', 'ProductApiController::store');
$router->put('api/update/{id}', 'ProductApiController::update');
$router->post('api/update/{id}', 'ProductApiController::update');
$router->delete('api/delete/{id}', 'ProductApiController::destroy');
$router->post('api/delete/{id}', 'ProductApiController::destroy');

// Direct Root Aliases for API Tester (when Base URL is http://127.0.0.1:3000)
$router->post('refresh', 'AuthApiController::refresh');
$router->get('profile', 'AuthApiController::me');
$router->get('list', 'ProductApiController::index');
$router->post('create', 'ProductApiController::store');
$router->put('update/{id}', 'ProductApiController::update');
$router->post('update/{id}', 'ProductApiController::update');
$router->delete('delete/{id}', 'ProductApiController::destroy');
$router->post('delete/{id}', 'ProductApiController::destroy');

// Dedicated Users and Profile Aliases for API Tester
$router->get('users-list', 'UserApiController::index');
$router->get('api/users-list', 'UserApiController::index');
$router->get('api/student/profile', 'AuthApiController::me');