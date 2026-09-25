@extends('layouts.main')

@section('page', 'carrito')
@section('nav', 'ventas')
@section('title', 'Nueva venta · Carrito · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Ventas', 'url' => route('ventas.index')], ['label' => 'Nueva venta']]"
    title="Nueva venta · Carrito de compras"
    subtitle="Revisa y confirma los productos antes de generar el pedido">
    <x-slot:buttons>
      <a href="{{ route('productos.index') }}" class="btn btn-light-outline"><i class="bi bi-plus-lg me-2"></i>Seguir comprando</a>
    </x-slot:buttons>
  </x-page-header>

  <div class="card empty-state" id="cartEmpty" style="display:none">
    <i class="bi bi-bag"></i>
    <h5>Tu carrito está vacío</h5>
    <p class="mb-4">Agrega productos desde el catálogo para comenzar una venta.</p>
    <a href="{{ route('productos.index') }}" class="btn btn-primary mx-auto"><i class="bi bi-box-seam me-2"></i>Ver productos</a>
  </div>

  <div class="row g-3 g-lg-4" id="cartWrap">
    <div class="col-12 col-lg-8">
      <div class="card">
        <div class="card-header-clean d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0"><i class="bi bi-bag-check me-2 text-primary"></i>Productos seleccionados</h5>
          <button class="btn btn-link btn-sm text-danger p-0" onclick="clearCart()">Vaciar carrito</button>
        </div>
        <div class="card-body-clean" id="cartItems"></div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="card summary-card">
        <div class="card-header-clean"><h5 class="card-title mb-0">Resumen del pedido</h5></div>
        <div class="card-body-clean">
          <div id="couponApplied" class="discount-chip mb-3" style="display:none"></div>
          <div class="summary-row">
            <span>Subtotal (<span id="cartItemCount">0</span>)</span>
            <strong id="cartSubtotal">$0</strong>
          </div>
          <div class="summary-row" id="discountRow">
            <span>Descuento</span>
            <strong style="color:var(--success)" id="cartDiscount">$0</strong>
          </div>
          <div class="summary-row">
            <span class="code">Envío</span>
            <strong id="cartShipping">—</strong>
          </div>
          <div class="summary-total">
            <span>Total</span>
            <span id="cartTotal" style="color:var(--primary)">$0</span>
          </div>
          <div class="input-group mt-4 mb-3" style="border-radius:12px;overflow:hidden">
            <input type="text" id="couponInput" class="form-control" placeholder="Cupón de descuento (ej. LAVANDIA10)"
              style="border:1px solid var(--line);padding:11px 14px;font-size:13.5px">
            <button class="btn btn-soft" id="couponBtn" type="button">Aplicar</button>
          </div>
          <button class="btn btn-success-grad w-100 btn-lg" id="checkoutBtn">
            <i class="bi bi-lightning-charge me-2"></i>Generar pedido
          </button>
          <p class="text-center mt-3 mb-0 small text-muted-soft">
            <i class="bi bi-shield-lock me-1"></i>Pago seguro · Envío gratis arriba de $3,000
          </p>
        </div>
      </div>
    </div>
  </div>

@endsection