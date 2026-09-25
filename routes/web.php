<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', fn () => view('pages.dashboard.index'))->name('dashboard');
Route::get('/', function () {return view('index');});
Route::get('/shop', function () {return view('product-info');});

Route::prefix('productos')->name('productos.')->group(function () {
    Route::get('/', fn () => view('pages.productos.listado'))->name('index');
    Route::get('/crear', fn () => view('pages.productos.crear'))->name('create');
    Route::get('/{producto}/editar', fn ($producto) => view('pages.productos.editar', ['productoId' => $producto]))->name('edit');
    Route::get('/{producto}', fn ($producto) => view('pages.productos.detalle', ['producto' => $producto]))->name('show');
});

Route::prefix('ventas')->name('ventas.')->group(function () {
    Route::get('/', fn () => view('pages.ventas.listado'))->name('index');
    Route::get('/crear', fn () => view('pages.ventas.crear'))->name('create');
    Route::get('/{venta}', fn ($venta) => view('pages.ventas.detalle', ['venta' => $venta]))->name('show');
});

Route::prefix('clientes')->name('clientes.')->group(function () {
    Route::get('/', fn () => view('pages.clientes.listado'))->name('index');
    Route::get('/crear', fn () => view('pages.clientes.crear'))->name('create');
    Route::get('/{cliente}', fn ($cliente) => view('pages.clientes.detalle', ['cliente' => $cliente]))->name('show');
});

Route::prefix('usuarios')->name('usuarios.')->group(function () {
    Route::get('/', fn () => view('pages.usuarios.listado'))->name('index');
    Route::get('/crear', fn () => view('pages.usuarios.editar'))->name('create');
    Route::get('/{usuario}/editar', fn ($usuario) => view('pages.usuarios.editar', ['usuarioId' => $usuario]))->name('edit');
});

Route::get('/pedidos', fn () => view('pages.pedidos.listado'))->name('pedidos');
Route::get('/inventario', fn () => view('pages.inventario.listado'))->name('inventario');
Route::get('/reportes', fn () => view('pages.reportes.index'))->name('reportes');
Route::get('/configuracion', fn () => view('pages.configuracion.index'))->name('configuracion');

Route::get('/login', fn () => view('pages.auth.login'))->name('login');
Route::get('/404', fn () => view('pages.not-found'))->name('not-found');

// Generated Routes for Template
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/become-vendor', fn () => view('become-vendor'))->name('become-vendor');
Route::get('/blogs-details', fn () => view('blogs-details'))->name('blogs-details');
Route::get('/blogs', fn () => view('blogs'))->name('blogs');
Route::get('/cart', fn () => view('cart'))->name('cart');
Route::get('/checkout', fn () => view('checkout'))->name('checkout');
Route::get('/compaire', fn () => view('compaire'))->name('compaire');
Route::get('/contact-us', fn () => view('contact-us'))->name('contact-us');
Route::get('/create-account', fn () => view('create-account'))->name('create-account');
Route::get('/empty-cart', fn () => view('empty-cart'))->name('empty-cart');
Route::get('/empty-wishlist', fn () => view('empty-wishlist'))->name('empty-wishlist');
Route::get('/faq', fn () => view('faq'))->name('faq');
Route::get('/flash-sale', fn () => view('flash-sale'))->name('flash-sale');
Route::get('/home-three', fn () => view('home-three'))->name('home-three');
Route::get('/home-two', fn () => view('home-two'))->name('home-two');
Route::get('/index04b9', fn () => view('index04b9'))->name('index04b9');
Route::get('/login', fn () => view('login'))->name('login');
Route::get('/order', fn () => view('order'))->name('order');
Route::get('/privacy', fn () => view('privacy'))->name('privacy');
Route::get('/product-info', fn () => view('product-info'))->name('product-info');
Route::get('/product-sidebar', fn () => view('product-sidebar'))->name('product-sidebar');
Route::get('/seller-sidebar', fn () => view('seller-sidebar'))->name('seller-sidebar');
Route::get('/sellers', fn () => view('sellers'))->name('sellers');
Route::get('/terms', fn () => view('terms'))->name('terms');
Route::get('/user-profile', fn () => view('user-profile'))->name('user-profile');
Route::get('/wishlist', fn () => view('wishlist'))->name('wishlist');
