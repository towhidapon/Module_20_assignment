<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layout');
// });

// Route to display all products
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Route to show the form to create a new product
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Route to store a new product
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Route to show a specific product's details
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Route to show the form to edit an existing product
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

// Route to update an existing product
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

// Route to delete a product
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
