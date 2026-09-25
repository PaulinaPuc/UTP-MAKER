@extends('layouts.main')

@section('page', 'inventario')
@section('nav', 'inventario')
@section('title', 'Inventario · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Inventario']]"
    title="Inventario"
    subtitle="Control de existencias, puntos de reorden y almacenes">
    <x-slot:buttons>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stockModal" onclick="openStockModal()"><i class="bi bi-plus-lg me-2"></i>Ajustar stock</button>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-3 g-md-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3"><x-stat-card icon="bi-boxes" color="3" title="Valor del inventario" value="$412,600" /></div>
    <div class="col-12 col-sm-6 col-xl-3"><x-stat-card icon="bi-check2-circle" color="2" title="Productos en stock" value="9,842" /></div>
    <div class="col-12 col-sm-6 col-xl-3"><x-stat-card icon="bi-exclamation-triangle" color="4" title="Stock bajo" value="4" /></div>
    <div class="col-12 col-sm-6 col-xl-3"><x-stat-card icon="bi-truck" color="1" title="Almacenes" value="3" /></div>
  </div>

  <div class="card mb-4">
    <div class="card-body-clean">
      <div class="alert d-flex align-items-center gap-2 flex-wrap mb-0" role="alert"
        style="background:var(--warning-soft);color:#92620a;border-radius:12px;border:none">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span>Hay <strong>4 productos</strong> por debajo del punto de reorden. Considera reabastecer.</span>
        <a href="#lowStock" class="ms-auto" style="color:#92620a;text-decoration:underline;white-space:nowrap">Ver productos</a>
      </div>
    </div>
  </div>

  <x-data-table id="lowStock" title="Existencias por producto"
    :headers="[['label' => 'Producto'], ['label' => 'SKU'], ['label' => 'Almacén'], ['label' => 'Existencia'], ['label' => 'Nivel'], ['label' => 'Min / Max'], ['label' => 'Acciones', 'class' => 'text-end']]">
    <x-slot:headerActions>
      <div class="filter-bar">
        <div style="position:relative">
          <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted)"></i>
          <input type="search" id="invSearch" class="search-input" style="padding-left:40px" placeholder="Buscar producto o SKU...">
        </div>
        <select id="invFilter" class="form-select-clean">
          <option value="all">Todos</option>
          <option value="low">Solo stock bajo</option>
          <option value="out">Sin stock</option>
        </select>
      </div>
    </x-slot:headerActions>
    <tbody id="inventoryTable"></tbody>
  </x-data-table>

  <x-modal id="stockModal" icon="bi-boxes" title="Ajustar existencias" hide-footer>
    <form id="stockForm">
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label-clean">Producto *</label>
            <select id="s-product" class="form-select-clean w-100"></select>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label-clean">Tipo de ajuste</label>
            <select id="s-type" class="form-select-clean w-100">
              <option value="in">Entrada (compra)</option>
              <option value="out">Salida (venta)</option>
              <option value="set">Asignar cantidad</option>
            </select>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label-clean">Cantidad *</label>
            <input type="number" id="s-qty" class="form-control-clean w-100" required min="0" placeholder="0">
          </div>
          <div class="col-12">
            <label class="form-label-clean">Concepto / Nota</label>
            <input type="text" class="form-control-clean w-100" placeholder="Ej. Recepción de proveedor">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-outline" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Guardar ajuste</button>
      </div>
    </form>
  </x-modal>

@endsection

@push('scripts')
<script>
  function renderInventory() {
    const q = (document.getElementById('invSearch').value || '').toLowerCase();
    const f = document.getElementById('invFilter').value;
    const data = window.APP_DATA.inventory.filter(i =>
      (f === 'all' || (f === 'low' ? i.stock <= i.min : i.stock === 0)) &&
      (!q || i.product.toLowerCase().includes(q) || i.sku.toLowerCase().includes(q))
    );
    document.getElementById('inventoryTable').innerHTML = data.length ? data.map(i => {
      const pct = Math.min(100, Math.round((i.stock / i.max) * 100));
      const color = i.stock === 0 ? 'bg-danger' : i.stock <= i.min ? 'bg-warning' : 'bg-success';
      const tag = i.stock === 0 ? '<span class="badge-soft badge-d">Sin stock</span>'
        : i.stock <= i.min ? '<span class="badge-soft badge-w">Bajo</span>'
          : '<span class="badge-soft badge-g">Sano</span>';
      return '<tr>' +
        '<td class="fw-semibold">' + i.product + '</td>' +
        '<td><span class="badge-soft badge-o">' + i.sku + '</span></td>' +
        '<td>' + i.warehouse + '</td>' +
        '<td class="fw-bold">' + i.stock + ' uds ' + tag + '</td>' +
        '<td style="min-width:150px"><div class="d-flex align-items-center gap-2">' +
        '<div class="progress flex-grow-1" style="height:7px;border-radius:10px;background:var(--lavanda-100)">' +
        '<div class="progress-bar ' + color + '" style="width:' + pct + '%;border-radius:10px"></div></div>' +
        '<span class="small text-muted-soft" style="min-width:32px">' + pct + '%</span></div></td>' +
        '<td>' + i.min + ' / ' + i.max + '</td>' +
        '<td class="text-end"><button class="btn btn-soft btn-sm" data-bs-toggle="modal" data-bs-target="#stockModal" ' +
        'onclick="openStockModal(' + i.id + ')"><i class="bi bi-plus-slash-minus me-1"></i>Ajustar</button></td></tr>';
    }).join('') : '<tr><td colspan="7" class="text-center text-muted-soft py-5">Sin resultados</td></tr>';
  }

  function openStockModal(id) {
    const select = document.getElementById('s-product');
    select.innerHTML = window.APP_DATA.inventory.map(i =>
      '<option value="' + i.id + '" ' + (i.id === id ? 'selected' : '') + '>' + i.product + ' (' + i.sku + ')</option>').join('');
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('invSearch').addEventListener('input', renderInventory);
    document.getElementById('invFilter').addEventListener('change', renderInventory);
    renderInventory();
    document.getElementById('stockForm').addEventListener('submit', e => {
      e.preventDefault();
      bootstrap.Modal.getInstance(document.getElementById('stockModal')).hide();
      e.target.reset();
      notify('success', 'bi-check-circle', 'Existencias actualizadas');
    });
  });
</script>
@endpush