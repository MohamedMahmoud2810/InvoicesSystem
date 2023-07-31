<?php

use App\Http\Controllers\InvoiceController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('invoice', InvoiceController::class)->except('show' , 'destroy' , 'index');
Route::get('/', [InvoiceController::class , 'index'])->name('invoice.index');
Route::get('invoice/{invoice}', [InvoiceController::class, 'delete'])->name('invoice.delete');
Route::get('/deposits/search', [InvoiceController::class, 'search'])->name('invoice.search');



