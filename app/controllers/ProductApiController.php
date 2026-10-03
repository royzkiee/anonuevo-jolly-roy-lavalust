<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
        $this->call->model('ProductModel');
    }

    /**
     * GET /api/products
     * Display all products
     */
    public function index()
    {
        $this->api->require_method('GET');
        $this->api->require_jwt();

        $products = $this->ProductModel->all();

        $this->api->respond([
            'status' => 'success',
            'data'   => $products ?: []
        ], 200);
    }

    /**
     * GET /api/products/{id}
     * Display single product
     */
    public function show($id)
    {
        $this->api->require_method('GET');
        $this->api->require_jwt();

        $product = $this->ProductModel->find($id);

        if (!$product) {
            $this->api->respond_error('Product not found', 404);
        }

        $this->api->respond([
            'status' => 'success',
            'data'   => $product
        ], 200);
    }

    /**
     * POST /api/products
     * Create a new product
     */
    public function store()
    {
        $this->api->require_method('POST');
        $this->api->require_jwt();

        $data = $this->api->body();

        $product_name = trim($data['product_name'] ?? '');
        $description  = trim($data['description'] ?? '');
        $price        = trim($data['price'] ?? '');
        $quantity     = trim($data['quantity'] ?? '');

        if ($product_name === '' || $price === '' || $quantity === '') {
            $this->api->respond_error('Product name, price, and quantity are required.', 422);
        }

        if (!is_numeric($price) || (float)$price < 0) {
            $this->api->respond_error('Price must be a valid non-negative number.', 422);
        }

        if (!is_numeric($quantity) || (int)$quantity < 0) {
            $this->api->respond_error('Quantity must be a valid non-negative integer.', 422);
        }

        $insertData = [
            'product_name' => $product_name,
            'description'  => $description,
            'price'        => number_format((float)$price, 2, '.', ''),
            'quantity'     => (int)$quantity
        ];

        $insertedId = $this->ProductModel->insert($insertData);

        if ($insertedId) {
            $this->api->respond([
                'status'  => 'success',
                'message' => 'Product created successfully.',
                'data'    => array_merge(['id' => $insertedId], $insertData)
            ], 201);
        } else {
            $this->api->respond_error('Failed to create product.', 500);
        }
    }

    /**
     * PUT /api/products/{id} or PATCH /api/products/{id}
     * Update an existing product
     */
    public function update($id)
    {
        $this->api->require_jwt();

        $product = $this->ProductModel->find($id);
        if (!$product) {
            $this->api->respond_error('Product not found', 404);
        }

        $data = $this->api->body();
        $updateData = [];

        if (isset($data['product_name'])) {
            $product_name = trim($data['product_name']);
            if ($product_name === '') {
                $this->api->respond_error('Product name cannot be empty.', 422);
            }
            $updateData['product_name'] = $product_name;
        }

        if (isset($data['description'])) {
            $updateData['description'] = trim($data['description']);
        }

        if (isset($data['price'])) {
            $price = trim($data['price']);
            if (!is_numeric($price) || (float)$price < 0) {
                $this->api->respond_error('Price must be a valid non-negative number.', 422);
            }
            $updateData['price'] = number_format((float)$price, 2, '.', '');
        }

        if (isset($data['quantity'])) {
            $quantity = trim($data['quantity']);
            if (!is_numeric($quantity) || (int)$quantity < 0) {
                $this->api->respond_error('Quantity must be a valid non-negative integer.', 422);
            }
            $updateData['quantity'] = (int)$quantity;
        }

        if (empty($updateData)) {
            $this->api->respond_error('No data provided to update.', 400);
        }

        $this->ProductModel->update($id, $updateData);

        $this->api->respond([
            'status'  => 'success',
            'message' => 'Product updated successfully.',
            'data'    => array_merge($product, $updateData)
        ], 200);
    }

    /**
     * DELETE /api/products/{id}
     * Delete a product
     */
    public function destroy($id)
    {
        $this->api->require_method('DELETE');
        $this->api->require_jwt();

        $product = $this->ProductModel->find($id);
        if (!$product) {
            $this->api->respond_error('Product not found', 404);
        }

        $this->ProductModel->delete($id);

        $this->api->respond([
            'status'  => 'success',
            'message' => 'Product deleted successfully.'
        ], 200);
    }
}
