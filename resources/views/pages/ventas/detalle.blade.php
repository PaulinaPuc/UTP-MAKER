@extends('layouts.main')

@section('page', 'ventas')
@section('nav', 'ventas')
@section('title', 'Detalle de venta · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Ventas', 'url' => route('ventas.index')], ['label' => 'Detalle']]"
    title="Detalle de venta"
    subtitle="Información completa de la transacción">
    <x-slot:buttons>
      <a href="{{ route('ventas.index') }}" class="btn btn-light-outline"><i class="bi bi-arrow-left me-2"></i>Volver a ventas</a>
      <button class="btn btn-primary no-print" onclick="window.print()"><i class="bi bi-printer me-2"></i>Imprimir recibo</button>
    </x-slot:buttons>
  </x-page-header>

  <input type="hidden" id="ventaId" value="{{ $venta }}">

  <div id="saleDetail">
    <div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>
  </div>

  <div class="card mt-4">
    <div class="card-header-clean">
      <h5 class="card-title mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Historial del cliente</h5>
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
    const id = document.getElementById('ventaId').value;
    const D = window.APP_DATA;
    const sale = D.sales.find(s => s.id === id) || D.sales[0];
    const box = document.getElementById('saleDetail');

    if (!sale) {
      box.innerHTML = '<div class="card empty-state"><i class="bi bi-receipt"></i><h5>Venta no encontrada</h5>' +
        '<a href="/ventas" class="btn btn-primary mt-3">Volver a ventas</a></div>';
      return;
    }

    box.innerHTML =
      '<div class="row g-3 g-md-4 mb-4">' +
      '<div class="col-12 col-sm-6 col-xl-3">' +
      '<div class="stat-card"><div class="stat-ic c-1"><i class="bi bi-receipt"></i></div>' +
      '<div class="stat-title">Folio</div><div class="stat-value" style="font-size:22px;color:var(--primary)">' + sale.id + '</div></div></div>' +
      '<div class="col-12 col-sm-6 col-xl-3">' +
      '<div class="stat-card"><div class="stat-ic c-5"><i class="bi bi-wallet2"></i></div>' +
      '<div class="stat-title">Total</div><div class="stat-value" style="font-size:22px">' + fmt(sale.total) + '</div></div></div>' +
      '<div class="col-12 col-sm-6 col-xl-3">' +
      '<div class="stat-card"><div class="stat-ic c-3"><i class="bi bi-credit-card"></i></div>' +
      '<div class="stat-title">Método de pago</div><div class="stat-value" style="font-size:22px">' + sale.method + '</div></div></div>' +
      '<div class="col-12 col-sm-6 col-xl-3">' +
      '<div class="stat-card"><div class="stat-ic c-2"><i class="bi bi-check2-circle"></i></div>' +
      '<div class="stat-title">Estado</div><div class="stat-value" style="font-size:22px">' + statusBadge(sale.status) + '</div></div></div>' +
      '</div>' +
      '<div class="row g-4">' +
      '<div class="col-12 col-lg-6">' +
      '<div class="card h-100"><div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-person me-2 text-primary"></i>Cliente</h5></div>' +
      '<div class="card-body-clean">' +
      '<div class="d-flex align-items-center gap-3 mb-3">' +
      '<span class="avatar-sm av-a">' + initials(sale.customer) + '</span>' +
      '<div><strong class="d-block">' + sale.customer + '</strong>' +
      '<span class="small text-muted-soft">Cliente registrado</span></div></div>' +
      '<div class="row g-3">' +
      '<div class="col-6"><label class="form-label-clean">Folio de venta</label><div class="fw-semibold">' + sale.id + '</div></div>' +
      '<div class="col-6"><label class="form-label-clean">Fecha</label><div class="fw-semibold">' + sale.date + '</div></div>' +
      '</div></div></div></div>' +
      '<div class="col-12 col-lg-6">' +
      '<div class="card h-100"><div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-bell me-2 text-primary"></i>Notas</h5></div>' +
      '<div class="card-body-clean text-muted-soft" style="line-height:1.8">' +
      '<p class="mb-3"><i class="bi bi-check-circle text-success me-2"></i>La venta fue registrada y notificada al cliente.</p>' +
      '<p class="mb-3"><i class="bi bi-truck me-2"></i>Envío estimado: 24-48 horas hábiles.</p>' +
      '<p class="mb-0"><i class="bi bi-receipt me-2"></i>Recibo disponible para su reimpresión.</p>' +
      '</div></div></div>' +
      '</div>';

    const orders = D.orders.filter(o => o.customer === sale.customer);
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