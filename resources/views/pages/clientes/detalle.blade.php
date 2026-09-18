@extends('layouts.main')

@section('page', 'clientes')
@section('nav', 'clientes')
@section('title', 'Detalle de cliente · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Clientes', 'url' => route('clientes.index')], ['label' => 'Detalle']]"
    title="Detalle del cliente"
    subtitle="Historial de compras y datos de contacto">
    <x-slot:buttons>
      <a href="{{ route('clientes.index') }}" class="btn btn-light-outline"><i class="bi bi-arrow-left me-2"></i>Volver al directorio</a>
    </x-slot:buttons>
  </x-page-header>

  <input type="hidden" id="customerId" value="{{ $cliente }}">

  <div id="customerDetail">
    <div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>
  </div>

  <div class="card mt-4">
    <div class="card-header-clean">
      <h5 class="card-title mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Pedidos del cliente</h5>
    </div>
    <div class="table-responsive">
      <table class="table table-clean align-middle mb-0">
        <thead>
          <tr><th>Pedido</th><th>Fecha</th><th>Artículos</th><th>Método</th><th>Total</th><th>Estado</th></tr>
        </thead>
        <tbody id="customerOrdersTable"></tbody>
      </table>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const id = parseInt(document.getElementById('customerId').value) || 1;
    const D = window.APP_DATA;
    const c = D.customers.find(x => x.id === id);
    const box = document.getElementById('customerDetail');

    if (!c) {
      box.innerHTML = '<div class="card empty-state"><i class="bi bi-person"></i><h5>Cliente no encontrado</h5>' +
        '<a href="/clientes" class="btn btn-primary mt-3">Volver al directorio</a></div>';
      return;
    }

    box.innerHTML =
      '<div class="row g-3 g-md-4 mb-4">' +
      '<div class="col-12 col-sm-6 col-xl-3">' +
      '<div class="stat-card"><div class="stat-ic c-3"><i class="bi bi-person-badge"></i></div>' +
      '<div class="stat-title">Cliente</div><div class="stat-value" style="font-size:22px;color:var(--primary)">ID #' + String(c.id).padStart(3, '0') + '</div></div></div>' +
      '<div class="col-12 col-sm-6 col-xl-3">' +
      '<div class="stat-card"><div class="stat-ic c-2"><i class="bi bi-receipt"></i></div>' +
      '<div class="stat-title">Pedidos</div><div class="stat-value" style="font-size:22px">' + c.orders + '</div></div></div>' +
      '<div class="col-12 col-sm-6 col-xl-3">' +
      '<div class="stat-card"><div class="stat-ic c-5"><i class="bi bi-wallet2"></i></div>' +
      '<div class="stat-title">Total gastado</div><div class="stat-value" style="font-size:22px">' + fmt(c.total) + '</div></div></div>' +
      '<div class="col-12 col-sm-6 col-xl-3">' +
      '<div class="stat-card"><div class="stat-ic c-4"><i class="bi bi-calendar-check"></i></div>' +
      '<div class="stat-title">Última compra</div><div class="stat-value" style="font-size:22px">' + c.last + '</div></div></div>' +
      '</div>' +
      '<div class="card"><div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-person me-2 text-primary"></i>Información de contacto</h5></div>' +
      '<div class="card-body-clean">' +
      '<div class="d-flex align-items-center gap-3 mb-4">' +
      '<span class="avatar-sm ' + c.avatar + '" style="width:54px;height:54px;font-size:18px;border-radius:14px">' + initials(c.name) + '</span>' +
      '<div><h5 class="fw-bold mb-0">' + c.name + '</h5>' +
      '<span class="small text-muted-soft">Cliente registrado</span></div></div>' +
      '<div class="row g-3">' +
      '<div class="col-12 col-md-4"><label class="form-label-clean">Email</label><div class="fw-semibold">' + c.email + '</div></div>' +
      '<div class="col-12 col-md-4"><label class="form-label-clean">Teléfono</label><div class="fw-semibold">' + c.phone + '</div></div>' +
      '<div class="col-12 col-md-4"><label class="form-label-clean">Última compra</label><div class="fw-semibold">' + c.last + '</div></div>' +
      '</div></div></div>';

    const orders = D.orders.filter(o => o.customer === c.name);
    document.getElementById('customerOrdersTable').innerHTML = orders.length ? orders.map(o =>
      '<tr>' +
      '<td class="fw-semibold" style="color:var(--primary)">' + o.id + '</td>' +
      '<td>' + o.date + '</td>' +
      '<td>' + o.items + ' art.</td>' +
      '<td>' + o.method + '</td>' +
      '<td class="fw-bold">' + fmt(o.total) + '</td>' +
      '<td>' + statusBadge(o.status) + '</td>' +
      '</tr>'
    ).join('') : '<tr><td colspan="6" class="text-center text-muted-soft py-5">Sin pedidos registrados</td></tr>';
  });
</script>
@endpush