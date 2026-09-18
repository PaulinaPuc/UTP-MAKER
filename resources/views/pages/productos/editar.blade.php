@extends('layouts.main')

@section('page', 'productos.editar')
@section('nav', 'productos')
@section('title', 'Editar producto · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Productos', 'url' => route('productos.index')], ['label' => 'Editar']]"
    title="Editar producto"
    subtitle="Actualiza la información del producto seleccionado">
    <x-slot:buttons>
      <a href="{{ route('productos.index') }}" class="btn btn-light-outline"><i class="bi bi-arrow-left me-2"></i>Volver al catálogo</a>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-4">
    <div class="col-12 col-lg-8">
      <div class="card">
        <div class="card-header-clean">
          <h5 class="card-title mb-0"><i class="bi bi-pencil-square me-2 text-primary"></i>Información del producto</h5>
        </div>
        <form id="productForm">
          <div class="card-body-clean">
            <input type="hidden" id="p-id">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label-clean">Nombre del producto *</label>
                <input type="text" id="p-name" class="form-control-clean w-100" required placeholder="Ej. Audífonos Inalámbricos Aura">
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label-clean">Categoría *</label>
                <select id="p-category" class="form-select-clean w-100"></select>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label-clean">Precio (MXN) *</label>
                <input type="number" id="p-price" class="form-control-clean w-100" required min="0" step="0.01" placeholder="0.00">
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label-clean">Precio anterior</label>
                <input type="number" id="p-oldPrice" class="form-control-clean w-100" min="0" step="0.01" placeholder="Opcional">
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label-clean">Stock *</label>
                <input type="number" id="p-stock" class="form-control-clean w-100" required min="0" placeholder="0">
              </div>
              <div class="col-12 col-md-8">
                <label class="form-label-clean">Descripción</label>
                <input type="text" id="p-desc" class="form-control-clean w-100" placeholder="Breve descripción del producto">
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent d-flex gap-2" style="border-top:1px solid var(--line)">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Guardar cambios</button>
            <a href="{{ route('productos.index') }}" class="btn btn-light-outline">Cancelar</a>
          </div>
        </form>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="card">
        <div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Nota</h5></div>
        <div class="card-body-clean small text-muted-soft" style="line-height:1.8">
          <p class="mb-3">Los cambios se aplican de inmediato al catálogo.</p>
          <p class="mb-3">El rating y la imagen se conservan al editar.</p>
          <p class="mb-0">Puedes ver el detalle del producto antes de guardar.</p>
        </div>
      </div>
    </div>
  </div>

@endsection