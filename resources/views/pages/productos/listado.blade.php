@extends('layouts.main')

@section('page', 'productos')
@section('nav', 'productos')
@section('title', 'Productos · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Inventario'], ['label' => 'Productos']]"
    title="Catálogo de productos"
    subtitle="Administra tu catálogo: agrega, edita o elimina productos">
    <x-slot:buttons>
      <a href="{{ route('productos.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Agregar producto</a>
    </x-slot:buttons>
  </x-page-header>

  <div class="card mb-4">
    <div class="card-body-clean">
      <div class="filter-bar">
        <div style="position:relative;flex:1;min-width:220px">
          <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
          <input type="search" id="productSearch" class="search-input" style="width:100%;padding-left:40px" placeholder="Buscar por nombre o categoría...">
        </div>
        <select id="productCategory" class="form-select-clean">
          <option value="all">Todas las categorías</option>
          @foreach(['Audio', 'Tecnologia', 'Ropa', 'Hogar', 'Calzado', 'Belleza', 'Accesorios'] as $cat)
            <option value="{{ $cat }}">{{ $cat }}</option>
          @endforeach
        </select>
        <span class="badge-soft badge-p ms-auto small" id="productCount">10 productos</span>
      </div>
    </div>
  </div>

  <div class="p-grid" id="productGrid"></div>

  <div class="card empty-state mt-4" id="productEmpty" style="display:none">
    <i class="bi bi-inbox"></i>
    <h5>No se encontraron productos</h5>
    <p class="mb-4">Prueba con otro término de búsqueda o agrega uno nuevo.</p>
    <a href="{{ route('productos.create') }}" class="btn btn-primary mx-auto"><i class="bi bi-plus-lg me-2"></i>Agregar producto</a>
  </div>

  <x-modal id="productModal" icon="bi-box-seam" title="Agregar nuevo producto"
    title-id="productModalTitle" subtitle="Todos los campos con * son obligatorios" size="lg" hide-footer>
    <form id="productForm">
      <div class="modal-body">
        <input type="hidden" id="p-id">
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label-clean">Nombre del producto *</label>
            <input type="text" id="p-name" class="form-control-clean w-100" required placeholder="Ej. Audífonos Inalámbricos">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-light-outline" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Guardar producto</button>
      </div>
    </form>
  </x-modal>

  <x-modal id="deleteConfirmModal" icon="bi-trash" title="¿Eliminar producto?" centered hide-footer>
    <div class="modal-body p-4">
      <span class="modal-title-ic mx-auto mb-3" style="width:56px;height:56px;font-size:24px;background:var(--danger-soft);color:var(--danger)"><i class="bi bi-trash"></i></span>
      <p class="text-muted-soft mb-4">Se eliminará <strong id="deleteProductName"></strong> de forma permanente. Esta acción no se puede deshacer.</p>
      <div class="d-flex gap-2 justify-content-center">
        <button class="btn btn-light-outline" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-danger-soft" id="confirmDeleteBtn"><i class="bi bi-trash me-2"></i>Sí, eliminar</button>
      </div>
    </div>
  </x-modal>

@endsection